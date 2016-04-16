<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Phalcon\Paginator\Adapter\Model as PaginatorModelo;
use \DataTables\DataTable;

/**
 * 1. Guardar un nuevo Remito: nuevoRemitoPorPlanillaAction nuevoAction guardarNuevoAction
 * 2. Agregar un nuevo Remito: agregarAction -> nuevoAction -> guardarNuevoAction
 * 3. Buscar Remitos por planilla: buscarRemitoPorPlanillaAction -> buscarRemitosPorPlanillaIdAjaxAction [generarTabla]
 * 4. Buscar todos los remitos que no tengan pdf: buscarRemitoPorPlanillaSinPDF ->  buscarRemitosPorPlanillaIdAjaxSinPDF [generarTabla]
 * Class RemitoController
 */
class RemitoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Agregar un remito nuevo');
        $miSesion = $this->session->get('auth');
        if ($miSesion['rol_nombre'] == 'ADMIN')
            $this->view->admin = 1;
        else
            $this->view->admin = 0;
        parent::initialize();

    }


    /**
     *
     */
    public function indexAction()
    {

    }

    /**
     * OK: Permite buscar una planilla.
     * @return bool
     */
    public function buscarRemitoPorPlanillaAction()
    {
        //SELECT2
        $this->importarSelect2();
        //DATATABLES
        $this->importarDataTables();
        $this->assets->collection("headerCss")
            ->addCss('plugins/validador-upload/css/file-validator.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/validador-upload/file-validator.js');
        //Select Autocomplete Planilla
        $this->view->formulario = new \Phalcon\Forms\Element\Select('remito_planillaId',
            Planilla::find(array('planilla_habilitado=1 AND planilla_armada=1', 'order' => 'planilla_nombreCliente DESC')),
            array(
                'using' => array('planilla_id', 'planilla_nombreCliente'),
                'useEmpty' => false,
                'emptyText' => 'Seleccione una planilla',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'required' => '',
                'onchange' => 'var x = document.getElementById("remito_planillaId").value;'
            ));
    }

    /**
     * OK Se encarga de buscar todos los remitos segun la planilla_id enviada por post.
     * Muestra las columnas extras.
     */
    public function buscarRemitosPorPlanillaIdAjaxAction()
    {
        $this->view->disable();
        $remito = null;
        $error = array();
        $data = array();
        $tabla = array();
        if ($this->request->getPost('remito_planillaId') == null)
            $error[] = "No se encontró la planilla";

        $remito = Remito::find(array('remito_habilitado = 1 AND remito_planillaId =:planilla_id:',
            'bind' => array('planilla_id' => $this->request->getPost('remito_planillaId')),
            'order by' => 'remito_nroOrden ASC'));
        if (count($remito) != 0)
            $tabla = $this->generarTablaDeRemitosNuevo($remito, 'extra');
        else {
            $error [] = "NO SE ENCONTRARON REMITOS";

        }
        $data['problemas'] = $error;
        echo json_encode(array('data' => $tabla, 'errores' => $data));
    }

    /**
     * OK: Permite seleccionar la planilla a buscar.
     * @return bool
     */
    public function buscarRemitoPorPlanillaSinPDFAction()
    {
        //SELECT2
        $this->importarSelect2();
        //DATATABLES
        $this->importarDataTables();
        //Select Autocomplete Planilla
        $this->view->formulario = new \Phalcon\Forms\Element\Select('remito_planillaId',
            Planilla::find(array('planilla_habilitado=1 AND planilla_armada=1', 'order' => 'planilla_nombreCliente DESC')),
            array(
                'using' => array('planilla_id', 'planilla_nombreCliente'),
                'useEmpty' => false,
                'emptyText' => 'Seleccione una planilla',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'required' => '',
                'onchange' => 'var x = document.getElementById("remito_planillaId").value;alert(x);'
            ));
    }

    /**
     * OK: Busca todas las planillas que no tengan los remitos escaneados
     * usado en buscarRemitoPorPlanillaSinPDFAction
     */
    public function buscarRemitosPorPlanillaIdAjaxSinPDFAction()
    {
        $this->view->disable();
        $remito = null;
        $error = array();
        $data = array();
        $tabla = array();
        if ($this->request->getPost('remito_planillaId') == null)
            $error[] = "No se encontró la planilla";

        $remito = Remito::find(array('remito_habilitado = 1 AND remito_planillaId =:planilla_id: AND remito_pdf IS NULL',
            'bind' => array('planilla_id' => $this->request->getPost('remito_planillaId')),
            'order by' => 'remito_nroOrden ASC'));
        if (count($remito) != 0)
            $tabla = $this->generarTablaDeRemitosNuevo($remito, 'extra');
        else {
            $error [] = "NO SE ENCONTRARON REMITOS";

        }
        $data['problemas'] = $error;
        echo json_encode(array('data' => $tabla, 'errores' => ""));
    }

    /**
     * =================================================================================================
     *                  METODO PRIVADO PARA PASAR DE UN MODELO A ARRAY CON FK
     * =================================================================================================
     */
    /**
     * A partir de una orden recuperar los datos importantes obtenidos con la clave foranea
     * @param $remitos
     * @return array
     */
    private function generarTablaDeRemitosNuevo($remitos, $extra = '')
    {
        $tabla = array();
        $planilla = "";
        foreach ($remitos as $unRemito) {
            $fila = array();
            $planilla = Planilla::findFirst(
                array('planilla_id=:planilla_id:',
                    'bind' => array('planilla_id' => $unRemito->getRemitoPlanillaId())));
            /*================ Planilla ================*/

            $fila['planilla_nombreCliente'] = $planilla->getPlanillaNombreCliente();
            $fila['remito_planillaId'] = $unRemito->getRemitoPlanillaId();

            /*================ Remito ================*/
            $fila['ADMIN'] = $this->tag->linkTo(array('remito/edit/' . $unRemito->getRemitoId(), '<i class="fa fa-pencil"></i>', 'class' => 'btn btn-flat bg-olive btn-block'));
            $fila['ORDEN'] = $unRemito->getRemitoNroOrden();
            $fila['FECHA'] = date('d/m/Y', date(strtotime(date($unRemito->getRemitoFecha()))));
            $fila['REMITO'] = $unRemito->getRemitoNro();//remito Sya
            if ($unRemito->getRemitoPdf() == null)
                $fila['PDF'] = '<a href="#agregarRemitoEscaneado" role="button" class="enviar-dato btn btn-flat btn-block bg-green-gradient"
                                    data-toggle="modal" data-id="' . $unRemito->getRemitoId() . '">AGREGAR REMITO</a>';
            else
                $fila['PDF'] = "<a href='/sya/" . $unRemito->getRemitoPdf() . "' target='_blank' class='btn btn-flat btn-block bg-light-blue-gradient'>ABRIR REMITO</a>";

            /*================ Transporte ================*/
            $fila['PATENTE'] = $unRemito->getTransporte()->getTransporteDominio();
            $fila['N° INTERNO'] = $unRemito->getTransporte()->getTransporteNroInterno();

            /*================ TipoEquipo ================*/
            $fila['TIPO EQUIPO'] = $unRemito->getTipoequipo()->getTipoEquipoNombre();

            /*================ TipoCarga ================*/
            $fila['TIPO CARGA'] = $unRemito->getTipocarga()->getTipoCargaNombre();

            /*================ Chofer ================*/
            $fila['DNI'] = $unRemito->getChofer()->getChoferDni();
            $fila['CHOFER'] = $unRemito->getChofer()->getChoferNombreCompleto();
            $fila['ES FLETERO'] = ($unRemito->getChofer()->getChoferEsFletero() == 1 ? 'SI' : 'NO');

            /*================ Cliente ================*/
            $fila['CLIENTE'] = $unRemito->getCliente()->getClienteNombre();

            /*================ Operadora ================*/
            //FIXME: NO puedo mostrar el nombre de la operadora!! Porque no tiene operadora cargada!
            if ($unRemito->getOperadora() != null)
                $fila['OPERADORA'] = $unRemito->getOperadora()->getOperadoraNombre();
            else
                $fila['OPERADORA'] = "NO ESTA CARGADO";

            /*================ EquipoPozo ================*/
            $fila['EQUIPO/POZO'] = $unRemito->getEquipopozo()->getEquipoPozoNombre();

            /*================ Yacimiento ================*/
            $yacimiento = Yacimiento::findFirstByYacimiento_id($unRemito->getEquipopozo()->getEquipopozoYacimientoid());
            $fila['DESTINO'] = $yacimiento->getYacimientoDestino();


            /*================ CentroCosto ================*/
            $fila['CENTRO COSTO'] = $unRemito->getCentrocosto()->getCentroCostoCodigo();

            /*================ Linea ================*/
            $linea = Linea::findFirstByLinea_id($unRemito->getCentrocosto()->getCentroCostoLineaId());
            $fila['LINEA-PSL'] = $linea->getLineaNombre();

            /*================ Viaje ================*/
            $fila['ORIGEN'] = $unRemito->getViaje()->getViajeOrigen();
            /*================ Concatenado ================*/
            $fila['CONCATENADO'] = $unRemito->getConcatenado()->getConcatenadoNombre();

            /*================ Tarifa ================*/
            $fila['HS TOTAL SERVICIO'] = $unRemito->getTarifa()->getTarifaHsServicio();
            $fila['KM'] = $unRemito->getTarifa()->getTarifaKm();
            $fila['HS HIDRO'] = $unRemito->getTarifa()->getTarifaHsHidro();
            $fila['HS MALACATE'] = $unRemito->getTarifa()->getTarifaHsMalacate();
            $fila['HS DE ESPERA'] = $unRemito->getTarifa()->getTarifaHsStand();

            /*================ Orden ================*/
            $fila['OBSERVACIONES'] = $unRemito->getRemitoObservacion();
            $fila['CONFORMIDAD RE'] = ($unRemito->getRemitoConformidad() == NULL ? "SIN ESPECIFICAR" : $unRemito->getRemitoConformidad());
            $fila['MOT NO CONFORM RE'] = ($unRemito->getRemitoNoConformidad() == NULL ? "SIN ESPECIFICAR" : $unRemito->getRemitoNoConformidad());
            /*================ Extra ================*/
            $columnas = Columna::find(array('columna_cabeceraId = :cabecera_id: AND columna_extra= 1 AND columna_habilitado=1',
                'bind' => array('cabecera_id' => $planilla->getCabecera()->getCabeceraId())));
            if (!empty($columnas)) {
                foreach ($columnas as $col) {
                    $contenidoExtra = Contenidoextra::findFirst(array('contenidoExtra_columnaId=:columna_id: AND contenidoExtra_habilitado=1',
                        'bind' => array('columna_id' => $col->getColumnaId())));
                    if ($contenidoExtra)
                        $descripcion = $contenidoExtra->getContenidoExtraDescripcion();
                    else
                        $descripcion = "SIN ESPECIFICAR";
                    $fila[$col->getColumnaNombre()] = $descripcion;
                }

            }
            $tabla[] = $fila;
        }


        return $tabla;
    }


    /**
     * Edits a remito
     *
     * @param string $remito_id
     */
    public function editAction($remito_id)
    {
        $this->importarSelect2();
        $this->assets->collection("headerCss")
            ->addCss('plugins/validador-upload/css/file-validator.css')
            ->addCss('plugins/iCheck/all.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/validador-upload/file-validator.js')
            ->addJs('plugins/iCheck/icheck.min.js');

        if (!$this->request->isPost()) {

            $remito = Remito::findFirst(array('remito_id=:remito_id:','bind'=>array('remito_id'=>$remito_id)));
            if (!$remito) {
                $this->flash->error("remito was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "remito",
                    "action" => "index"
                ));
            }

            $this->view->remito_id = $remito->getRemitoId();

            $this->tag->setDefault("remito_id", $remito->getRemitoId());
            $this->tag->setDefault("remito_nro", $remito->getRemitoNro());
            $this->tag->setDefault("remito_planillaId", $remito->getRemitoPlanillaid());
            $this->tag->setDefault("remito_periodo", $remito->getRemitoPeriodo());
            $this->tag->setDefault("remito_transporteId", $remito->getRemitoTransporteid());

            $this->tag->setDefault("remito_tipoEquipoId", $remito->getRemitoTipoequipoid());
            $this->tag->setDefault("remito_tipoCargaId", $remito->getRemitoTipocargaid());
            $this->tag->setDefault("remito_choferId", $remito->getRemitoChoferid());
            $this->tag->setDefault("remito_viajeId", $remito->getRemitoViajeid());
            $this->tag->setDefault("remito_concatenadoId", $remito->getRemitoConcatenadoid());
            $this->tag->setDefault("remito_tarifaId", $remito->getRemitoTarifaid());
            $this->tag->setDefault("remito_contenidoExtraId", $remito->getRemitoContenidoextraid());
            $this->tag->setDefault("remito_clienteId", $remito->getRemitoClienteid());
            $this->tag->setDefault("remito_centroCostoId", $remito->getRemitoCentrocostoid());
            $this->tag->setDefault("remito_equipoPozoId", $remito->getRemitoEquipopozoid());
            $this->tag->setDefault("remito_operadoraId", $remito->getRemitoOperadoraid());
            $this->tag->setDefault("remito_observacion", $remito->getRemitoObservacion());
            $this->tag->setDefault("remito_pdf", $remito->getRemitoPdf());
            $this->tag->setDefault("remito_fecha", $remito->getRemitoFecha());
            $this->tag->setDefault("remito_fechaCreacion", $remito->getRemitoFechacreacion());
            $this->tag->setDefault("remito_conformidad", $remito->getRemitoConformidad());
            $this->tag->setDefault("remito_noConformidad", $remito->getRemitoNoconformidad());
            $this->tag->setDefault("remito_creadoPor", $remito->getRemitoCreadopor());
            $this->tag->setDefault("remito_habilitado", $remito->getRemitoHabilitado());
            $this->tag->setDefault("remito_ultima", $remito->getRemitoUltima());



            $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_finalizada=0 AND planilla_habilitado=1 ',
                'bind' => array('planilla_id' => $remito->getRemitoPlanillaid())));
            $columnas = Columna::find(array(
                "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
                'bind' => array('cabecera_id' => $planilla->getPlanillaCabeceraid())
            ));

            if (count($columnas) != 0) {
                $this->view->columnaExtraForm = new ColumnaExtraForm(null, array('extra' => $columnas));
            }

            $this->view->remitoForm = new RemitoNuevoForm(null, array('required' => ''));

            $cliente = Cliente::findFirst(array('cliente_id=:cliente_id:', 'bind' => array('cliente_id' => $planilla->getPlanillaClienteId())));

            $this->view->clienteForm = new ClienteNewForm($cliente, array('required' => ''));

            $this->view->planilla = $planilla;
        }
    }


    /**
     * Saves a remito edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }

        $remito_id = $this->request->getPost("remito_id");

        $remito = Remito::findFirstByremito_id($remito_id);
        if (!$remito) {
            $this->flash->error("remito does not exist " . $remito_id);

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }

        $remito->setRemitoNro($this->request->getPost("remito_nro"));
        $remito->setRemitoPlanillaid($this->request->getPost("remito_planillaId"));
        $remito->setRemitoPeriodo($this->request->getPost("remito_periodo"));
        $remito->setRemitoTransporteid($this->request->getPost("remito_transporteId"));
        $remito->setRemitoTipoequipoid($this->request->getPost("remito_tipoEquipoId"));
        $remito->setRemitoTipocargaid($this->request->getPost("remito_tipoCargaId"));
        $remito->setRemitoChoferid($this->request->getPost("remito_choferId"));
        $remito->setRemitoViajeid($this->request->getPost("remito_viajeId"));
        $remito->setRemitoConcatenadoid($this->request->getPost("remito_concatenadoId"));
        $remito->setRemitoTarifaid($this->request->getPost("remito_tarifaId"));
        $remito->setRemitoContenidoextraid($this->request->getPost("remito_contenidoExtraId"));
        $remito->setRemitoClienteid($this->request->getPost("remito_clienteId"));
        $remito->setRemitoCentrocostoid($this->request->getPost("remito_centroCostoId"));
        $remito->setRemitoEquipopozoid($this->request->getPost("remito_equipoPozoId"));
        $remito->setRemitoOperadoraid($this->request->getPost("remito_operadoraId"));
        $remito->setRemitoObservacion($this->request->getPost("remito_observacion"));
        $remito->setRemitoPdf($this->request->getPost("remito_pdf"));
        $remito->setRemitoFecha($this->request->getPost("remito_fecha"));
        $remito->setRemitoFechacreacion($this->request->getPost("remito_fechaCreacion"));
        $remito->setRemitoConformidad($this->request->getPost("remito_conformidad"));
        $remito->setRemitoNoconformidad($this->request->getPost("remito_noConformidad"));
        $remito->setRemitoCreadopor($this->request->getPost("remito_creadoPor"));
        $remito->setRemitoHabilitado($this->request->getPost("remito_habilitado"));
        $remito->setRemitoUltima($this->request->getPost("remito_ultima"));


        if (!$remito->save()) {

            foreach ($remito->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "edit",
                "params" => array($remito->remito_id)
            ));
        }

        $this->flash->success("remito was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "remito",
            "action" => "index"
        ));

    }

    /**
     * Deletes a remito
     *
     * @param string $remito_id
     */
    public function deleteAction($remito_id)
    {

        $remito = Remito::findFirstByremito_id($remito_id);
        if (!$remito) {
            $this->flash->error("remito was not found");

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }

        if (!$remito->delete()) {

            foreach ($remito->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "search"
            ));
        }

        $this->flash->success("remito was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "remito",
            "action" => "index"
        ));
    }


    /**
     * Genera un formulario para guardar un nuevo remito.
     */
    public function nuevoAction()
    {
        $this->assets->collection("headerCss")
            ->addCss('plugins/validador-upload/css/file-validator.css')
            ->addCss('plugins/iCheck/all.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/validador-upload/file-validator.js')
            ->addJs('plugins/iCheck/icheck.min.js');
        if (!$this->request->hasPost('remito_planillaId') || $this->request->getPost('remito_planillaId') == null) {
            $this->flash->error("Es necesario que seleccione una planilla");
            return $this->redireccionar('remito/nuevoRemitoPorPlanilla');
        }

        $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_finalizada=0 AND planilla_habilitado=1 ',
            'bind' => array('planilla_id' => $this->request->getPost('remito_planillaId'))));
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind' => array('cabecera_id' => $planilla->getPlanillaCabeceraid())
        ));

        if (count($columnas) != 0) {
            $this->view->columnaExtraForm = new ColumnaExtraForm(null, array('extra' => $columnas));
        }

        $this->view->remitoForm = new RemitoForm(null, array('required' => ''));

        $cliente = Cliente::findFirst(array('cliente_id=:cliente_id:', 'bind' => array('cliente_id' => $planilla->getPlanillaClienteId())));

        $this->view->clienteForm = new ClienteNewForm($cliente, array('required' => ''));

        $this->view->planilla = $planilla;
    }

    /**
     * OK: Guarda los datos de un remito en la bd
     * usado por nuevoAction
     * @return bool
     */
    public function guardarNuevoAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }
        $planilla_id = $this->request->getPost("remito_planillaId");
        //Controlamos el formulario
        $data = $this->request->getPost();
        $remitoForm = new RemitoForm(null, array('required' => ''));
        if (!$remitoForm->isValid($data, new Remito)) {
            foreach ($remitoForm->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevo",
                "params" => array($planilla_id)
            ));
        }
        $clienteForm = new ClienteNewForm(null, array('required' => ''));
        if (!$clienteForm->isValid($data, new Cliente())) {
            foreach ($clienteForm->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevo",
                "params" => array($planilla_id)
            ));
        }

        //Controlamos que exista la planilla
        $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_finalizada=0 AND planilla_habilitado=1 AND planilla_armada=1',
            'bind' => array('planilla_id' => $planilla_id)));
        if (!$planilla) {
            $this->flash->error('Hubo un problema, la planilla no permite agregar más remitos.');
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevo",
                "params" => array($planilla_id)
            ));
        }

        /*==================== Generar Ultimo Nro de Remito ===============================*/
        $this->db->begin();

        $nuevoRemito = new Remito();
        $ultimoRemito = Remito::findFirst(array(
            "remito_ultima = 1 AND remito_habilitado=1 AND remito_planillaId = :planilla_id:",
            'bind' => array('planilla_id' => $planilla_id)
        ));
        if (!$ultimoRemito) {
            $nuevoRemito->setRemitoUltima(1);
            $nuevoRemito->setRemitoNroOrden(1);
        } else {
            $nuevoRemito->setRemitoUltima(1);
            $ultimoRemito->setRemitoUltima(0);
            $nuevoRemito->setRemitoNroOrden($ultimoRemito->getRemitoNroOrden() + 1);
            if (!$ultimoRemito->update()) {
                $this->flash->error('Hubo un problema con la conexion, intenteló nuevamente');
                $this->db->rollback();
                return $this->dispatcher->forward(array(
                    "controller" => "remito",
                    "action" => "nuevo",
                    "params" => array($planilla_id)
                ));
            }
        }
        /*==================== Guardando Datos del Remito ===============================*/
        $nuevoRemito->setRemitoPlanillaId($planilla_id);
        $nuevoRemito->setRemitoFechaCreacion(date('Y-m-d'));
        $nuevoRemito->setRemitoCreadoPor($this->session->get('auth')['usuario_nick']);
        $nuevoRemito->setRemitoHabilitado(1);
        $nuevoRemito->setRemitoFecha($this->request->getPost('remito_fecha'));
        $nuevoRemito->setRemitoNro($this->request->getPost('remito_nro'));
        $nuevoRemito->setRemitoPeriodo(date('m', date(strtotime(date($this->request->getPost("remito_fecha"))))));
        if ($this->request->hasFiles() && $this->request->getUploadedFiles()[0]!=NULL   ) {
            var_dump($this->request->getUploadedFiles());
            $upload = $this->guardarPDF($this->request->getUploadedFiles(), $planilla->getPlanillaClienteId(), $planilla->getPlanillaFecha());
            if (!$upload['success']) {
                $this->flash->error($upload['mensaje']);
                $this->db->rollback();
                return $this->dispatcher->forward(array(
                    "controller" => "remito",
                    "action" => "nuevo",
                    "params" => array($planilla_id)
                ));
            }
            $nuevoRemito->setRemitoPdf($upload['path']);
        }


        $nuevoRemito->setRemitoObservacion($this->request->getPost('remito_observacion'));
        $nuevoRemito->setRemitoConformidad($this->request->getPost('remito_conformidad'));
        $nuevoRemito->setRemitoNoConformidad($this->request->getPost('remito_noConformidad'));
        /* ==================== ==================== ==================== ==================== */
        $nuevoRemito->setRemitoTransporteId($this->request->getPost('remito_transporteId'));
        $nuevoRemito->setRemitoTipoEquipoId($this->request->getPost('remito_tipoEquipoId'));
        $nuevoRemito->setRemitoTipoCargaId($this->request->getPost('remito_tipoCargaId'));
        $nuevoRemito->setRemitoChoferId($this->request->getPost('remito_choferId'));
        /* ==================== ==================== ==================== ==================== */
        $nuevoRemito->setRemitoClienteId($planilla->getPlanillaClienteId());
        $nuevoRemito->setRemitoCentroCostoId($this->request->getPost('centroCosto_id'));
        $nuevoRemito->setRemitoEquipoPozoId($this->request->getPost('equipoPozo_id'));
        $nuevoRemito->setRemitoOperadoraId($this->request->getPost('operadora_id'));
        /* ==================== ==================== ==================== ==================== */
        $nuevoRemito->setRemitoViajeId($this->request->getPost('remito_viajeId'));
        $nuevoRemito->setRemitoConcatenadoId($this->request->getPost('remito_concatenadoId'));
        /* ==================== ==================== ==================== ==================== */
        $tarifa = new Tarifa();
        $tarifa->setTarifaHoraInicial($this->request->getPost("tarifa_horaInicial"));
        $tarifa->setTarifaHoraFinal($this->request->getPost("tarifa_horaFinal"));
        $tarifa->setTarifaHsServicio($this->request->getPost("tarifa_hsServicio"));
        $tarifa->setTarifaHsHidro($this->request->getPost("tarifa_hsHidro"));
        $tarifa->setTarifaHsMalacate($this->request->getPost("tarifa_hsMalacate"));
        $tarifa->setTarifaHsStand($this->request->getPost("tarifa_hsStand"));
        $tarifa->setTarifaKm($this->request->getPost("tarifa_km"));
        if (!$tarifa->save()) {
            foreach ($tarifa->getMessages() as $mensaje) {
                $this->flash->error($mensaje);
            }
            $this->db->rollback();
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevo",
                "params" => array($planilla_id)
            ));
        }
        $nuevoRemito->setRemitoTarifaId($tarifa->getTarifaId());
        /* ==================== ==================== ==================== ==================== */
        $planilla = Planilla::findFirstByPlanilla_id($planilla_id);
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind' => array('cabecera_id' => $planilla->getPlanillaCabeceraid())
        ));

        if (count($columnas) != 0) {
            foreach ($columnas as $col) {
                $contenidoExtra = new Contenidoextra();
                $contenidoExtra->setContenidoExtraHabilitado(1);
                $contenidoExtra->setContenidoExtraColumnaId($col->getColumnaId());
                echo "<br> COl NOmbre".$col->getColumnaClave();
                echo "<br> getPOst".$this->request->getPost($col->getColumnaClave());
                $contenidoExtra->setContenidoExtraDescripcion($this->request->getPost($col->getColumnaClave()));
                if (!$contenidoExtra->save()) {
                    foreach ($contenidoExtra->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    $this->db->rollback();
                    return $this->dispatcher->forward(array(
                        "controller" => "remito",
                        "action" => "nuevo",
                        "params" => array($planilla_id)
                    ));
                }
            }
        }
        /* ==================== ==================== ==================== ==================== */
        if (!$nuevoRemito->save()) {
            foreach ($nuevoRemito->getMessages() as $mensaje) {
                $this->flash->error($mensaje);
            }
            $this->db->rollback();
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevo",
                "params" => array($planilla_id)
            ));
        }

        $this->db->commit();
        $this->flash->success('Remito creado satisfactoriamente');
        return $this->dispatcher->forward(array(
            "controller" => "remito",
            "action" => "finaliza",
            "params" => array($planilla_id)
        ));
    }

    /**
     * Muestra un mensaje de que el remito se guardo correctamente, permite que el usuario decida que desea continuar haciendo
     */
    public function finalizaAction($planilla_id)
    {
        $this->view->planilla_id = $planilla_id;
    }

    /**
     * Guarda el archivo pdf en la carpeta : 'CLIENTE/fechaCreacionPlanilla/NombrePDF'
     * @param $file
     */
    private function guardarPDF($archivos, $cliente_id, $fechaCreacion)
    {
        $retorno = array();
        $retorno['path'] = '';//Nombre de la ruta en donde se guardo el archivo
        $retorno['success'] = false;//Si finaliza correctamente o no.
        $retorno['mensaje'] = '';//Mensaje de error en caso de que falle.

        foreach ($archivos as $archivo) {

            //Creando Carpeta
            $nombreArchivo = $archivo->getName();
            $cliente = Cliente::findFirst(array('cliente_id=:cliente_id: AND cliente_habilitado=1',
                'bind' => array('cliente_id' => $cliente_id)));
            $nombreCarpeta = 'temp/' . $cliente->getClienteNombre() . '/' . $fechaCreacion;
            if (!file_exists($nombreCarpeta)) {
                mkdir($nombreCarpeta, 0777, true);
            }
            $path = $nombreCarpeta . '/' . $nombreArchivo;
            #move the file and simultaneously check if everything was ok
            ($archivo->moveTo($path)) ? $retorno['success'] = true : $retorno['success'] = false;
            if (!$retorno['success'])
                $retorno = "Ocurrio un problema al guardar el archivo en el servidor.";
            else {
                $retorno['path'] = $path;
            }

        }
        return $retorno;

    }

    /***************************************************************************************************
     * Permite buscar la planilla a la cual se le va agregar el remito, y se lo redirecciona al nuevoRemito.
     */
    public function nuevoRemitoPorPlanillaAction()
    {
        $this->importarSelect2();
        //Select Autocomplete Planilla
        $this->view->formulario = new \Phalcon\Forms\Element\Select('remito_planillaId',
            Planilla::find(array('planilla_habilitado=1 AND planilla_finalizada=0 AND planilla_armada=1', 'order' => 'planilla_nombreCliente DESC')),
            array(
                'using' => array('planilla_id', 'planilla_nombreCliente'),
                'useEmpty' => false,
                'emptyText' => 'Seleccione una planilla',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'required' => ''
            ));
    }

    /**
     * Nuevo remito por Planilla_id. Reutiliza la vista remito/nuevo.volt
     */
    public function agregarAction($planilla_id)
    {
        $this->assets->collection("headerCss")
            ->addCss('plugins/iCheck/all.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/iCheck/icheck.min.js');
        if ($planilla_id == null) {
            $this->flash->error("No se encontro la planilla solicitada #$planilla_id");
            return $this->redireccionar('remito/nuevoRemitoPorPlanilla');
        }

        $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_armada=1 AND planilla_finalizada=0 AND planilla_habilitado=1 ',
            'bind' => array('planilla_id' => $planilla_id)));
        if (!$planilla) {
            $this->flash->error("La planilla con ID $planilla_id no se encontró disponible para agregar remitos.");
            return $this->redireccionar('remito/nuevoRemitoPorPlanilla');
        }
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind' => array('cabecera_id' => $planilla->getPlanillaCabeceraid())
        ));

        if (count($columnas) != 0) {
            $this->view->columnaExtraForm = new ColumnaExtraForm(null, array('extra' => $columnas));
        }

        $this->view->remitoForm = new RemitoForm(null, array('required' => ''));

        $cliente = Cliente::findFirst(array('cliente_id=:cliente_id:', 'bind' => array('cliente_id' => $planilla->getPlanillaClienteId())));

        $this->view->clienteForm = new ClienteNewForm($cliente, array('required' => ''));

        $this->view->planilla = $planilla;
        $this->view->pick('remito/nuevo');
    }

    /**
     * Guarda un remito escaneado en el servidor. La peticion se hace a traves de un modal.
     * [AJAX]
     */
    public function guardarRemitoEscaneadoAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = true;
        $retorno['mensaje'] = '';
        if ($this->request->isPost()) {
            $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_habilitado=1 AND planilla_armada=1 AND planilla_finalizada=0',
                'bind' => array('planilla_id' => $this->request->getPost('planilla_id'))));
            if (!$planilla) {
                $retorno['success'] = false;
                $retorno['mensaje'] = "NO SE ENCONTRO NINGUNA PLANILLA HABILITADA. ID: " . $this->request->getPost('planilla_id');
            } else {
                $nombreCarpeta = 'temp/' . $planilla->getCliente()->getClienteNombre() . '/' . $planilla->getPlanillaFecha();
                if (!file_exists($nombreCarpeta)) {
                    mkdir($nombreCarpeta, 0777, true);
                }
                $path = $nombreCarpeta . '/' . $_FILES['file']['name'];
                #move the file and simultaneously check if everything was ok
                (move_uploaded_file($_FILES['file']['tmp_name'], $path)) ? $retorno['success'] = true : $retorno['success'] = false;
                if (!$retorno['success']) {
                    $retorno['success'] = false;
                    $retorno['mensaje'] = "Ocurrio un problema al guardar el archivo en el servidor. ";
                } else {
                    $remito = Remito::findFirst(array('remito_id=:remito_id:', 'bind' => array('remito_id' => $this->request->getPost('remito_id'))));
                    if (!$remito) {
                        $retorno['success'] = false;
                        $retorno['mensaje'] = "El Remito no se encontró ID:" . $this->request->getPost('remito_id');
                        echo json_encode($retorno);
                        return;
                    }
                    $remito->setRemitoPdf($path);
                    if (!$remito->update()) {
                        $retorno['success'] = false;
                        foreach ($remito->getMessages() as $mensaje) {

                            $retorno['mensaje'] .= $mensaje . "<br>";
                        }

                    } else {
                        $retorno['mensaje'] = "Operación Exitosa, el archivo se ha guardado en $path";
                    }
                }
            }

        }

        echo json_encode($retorno);
        return;
    }
    /**
     * Editar Remito por planilla
     * @return bool
     */
    public function editarRemitoPorPlanillaAction()
    {
        //SELECT2
        $this->importarSelect2();
        //DATATABLES

        $this->importarDataTablesEditor();
        $this->assets->collection("headerCss")
            ->addCss('plugins/validador-upload/css/file-validator.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/validador-upload/file-validator.js');
        //Select Autocomplete Planilla
        $this->view->formulario = new \Phalcon\Forms\Element\Select('remito_planillaId',
            Planilla::find(array('planilla_habilitado=1 AND planilla_armada=1', 'order' => 'planilla_nombreCliente DESC')),
            array(
                'using' => array('planilla_id', 'planilla_nombreCliente'),
                'useEmpty' => false,
                'emptyText' => 'Seleccione una planilla',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'required' => '',
                'onchange' => 'var x = document.getElementById("remito_planillaId").value;'
            ));
    }
}
