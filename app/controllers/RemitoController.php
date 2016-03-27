<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Phalcon\Paginator\Adapter\Model as PaginatorModelo;
use \DataTables\DataTable;

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

    private function recuperarPosiciones($cabeceraId)
    {
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_posicion')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: ', array('columna_cabeceraId' => 75))
            ->orderBy('columna_id ASC')
            ->getQuery()
            ->execute()->toArray();
        if ($columnas)
            return $columnas;
        else
            return null;
    }
    /**
     * =================================================================================================
     *
     * =================================================================================================
     */
    /**
     *
     */
    public function indexAction()
    {

    }

    /**
     * =================================================================================================
     *                          BUSQUEDA DE REMITOS SIN PDF
     *
     * =================================================================================================
     */
    public function searchRemitoSinPDFAction()
    {
        //SELECT2
        $this->importarSelect2();
        //DATATABLES
        $this->importarDataTables();
        //Posiciones:
        $columnas = $this->recuperarPosiciones(27);
        //Vistas
        $this->view->columnas = $columnas;
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

    public function buscarSinRemitoEscaneadoAction()
    {
        $this->view->disable();
        /*=================*/
        if ($this->request->getPost('remito_planillaId') == null)
            $error[] = "No se encontró la planilla";

        /*====================*/
        if (!empty($retorno)) {
            $query = Criteria::fromInput($this->di, "Remito", $retorno);
            $this->persistent->parameters = $query->getParams();
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "remito_id";
        $remito = Remito::find(array('remito_planillaId = :planilla_id: AND remito_pdf IS NULL',
            'bind' => array('planilla_id' => $this->request->getPost('remito_planillaId'))));
        $tabla = $this->generarTablaDeRemitosNuevo($remito);
        echo json_encode(array('data' => $tabla));
    }
    /**
     * =================================================================================================
     *                          BUSQUEDA DE REMITOS POR PLANILLA
     * =================================================================================================
     */
    /**
     * @return bool
     */
    public function buscarRemitoPorPlanillaAction()
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
     * Se encarga de buscar todos los remitos segun la planilla_id enviada por post.
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
        echo json_encode(array('data' => $tabla,'errores'=>$data));
    }
    /**
     * =================================================================================================
     *                          BUSQUEDA DE REMITOS GRAL AJAX
     * =================================================================================================
     */
    public function searchDataTablePlanillaAction(){
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
     * OK.
     * Se encarga de mostrar el formulario de busqueda de remitos, y de preparar la tabla a generar por la busqueda.
     */
    public function searchDataTableAction()
    {
        $this->importarDataTables();
        //Vistas
        $this->view->remitoForm = new RemitoForm();
        $this->view->clienteForm = new ClienteNewForm();
    }

    /**
     * Llamada ajax por el submit de searchDataTable. Se encarga de realizar un criteria con los datos enviado por POST
     * (form serializable) y luego busca los datos que se van a mostrar en la datatable.
     * Devuelve un arreglo.
     */
    public function busquedaAjaxAction()
    {
        $this->view->disable();
        /*=================*/
        $retorno = array();
        foreach ($_POST as $arreglo) {
            $retorno[$arreglo['name']] = $arreglo['value'];
        }
        /*====================*/

        if (!empty($retorno)) {
            $query = Criteria::fromInput($this->di, "Remito", $retorno);
            $this->persistent->parameters = $query->getParams();
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "remito_id";
        $remito = Remito::find($parameters);
        $tabla = $this->generarTablaDeRemitosNuevo($remito);
        echo json_encode(array('data' => $tabla));
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
            $planilla = Planilla::findFirstByPlanilla_id($unRemito->getRemitoPlanillaId());
            /*================ Planilla ================*/

            $fila['planilla_nombreCliente'] = $planilla->getPlanillaNombreCliente();
            $fila['remito_planillaId'] = $unRemito->getRemitoPlanillaId();

            /*================ Remito ================*/
            $fila['ORDEN'] = $unRemito->getRemitoNroOrden();
            $fila['FECHA'] = date('d/m/Y', date(strtotime(date($unRemito->getRemitoFecha()))));
            $fila['REMITO'] = $unRemito->getRemitoNro();//remito Sya
            $fila['remito_pdf'] = $unRemito->getRemitoPdf();//remito Sya


            /*================ Transporte ================*/
            $fila['PATENTE'] = $unRemito->getTransporte()->getTransporteDominio();
            $fila['INTERNO'] = $unRemito->getTransporte()->getTransporteNroInterno();

            /*================ TipoEquipo ================*/
            $fila['TIPO EQUIPO'] = $unRemito->getTipoequipo()->getTipoEquipoNombre();

            /*================ TipoCarga ================*/
            $fila['TIPO CARGA'] = $unRemito->getTipocarga()->getTipoCargaNombre();

            /*================ Chofer ================*/
            $fila['DNI'] = $unRemito->getChofer()->getChoferDni();
            $fila['CHOFER'] = $unRemito->getChofer()->getChoferNombreCompleto();
            $fila['chofer_esFletero'] = ($unRemito->getChofer()->getChoferEsFletero() == 1 ? 'SI' : 'NO');

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
            $fila['LINEA'] = $linea->getLineaNombre();

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
                'bind'=>array('cabecera_id'=>$planilla->getCabecera()->getCabeceraId())));
            if(!empty($columnas))
            {
                foreach ($columnas as $col) {
                    $contenidoExtra = Contenidoextra::findFirst(array('contenidoExtra_columnaId=:columna_id: AND contenidoExtra_habilitado=1',
                        'bind'=>array('columna_id'=>$col->getColumnaId())));
                    if($contenidoExtra)
                        $descripcion = $contenidoExtra->getContenidoExtraDescripcion();
                    else
                        $descripcion= "SIN ESPECIFICAR";
                    $fila[$col->getColumnaNombre()]=$descripcion;
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

        if (!$this->request->isPost()) {

            $remito = Remito::findFirstByremito_id($remito_id);
            if (!$remito) {
                $this->flash->error("remito was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "remito",
                    "action" => "index"
                ));
            }

            $this->view->remito_id = $remito->remito_id;

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

    /***************************************************************************************************
     * Nuevo remito, arma un formulario para cargar todos los datos correspondientes a un remito.
     */
    public function nuevoRemitoAction($planilla_id)
    {
        $planilla = Planilla::findFirstByPlanilla_id($planilla_id);
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind' => array('cabecera_id' => $planilla->getPlanillaCabeceraid())
        ));

        if (count($columnas) != 0) {
            $this->view->columnaExtraForm = new ColumnaExtraForm(null, array('extra' => $columnas));
        }
        $this->view->remitoForm = new RemitoForm(null, array('required' => ''));
        $this->view->clienteForm = new ClienteNewForm(null, array('required' => ''));
        $this->view->planilla = $planilla;
    }

    /**
     * Guarda todos los campos correspondiente a un remito y sus dependientes.
     */
    public function guardarRemitoAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }
        $this->db->begin();


        $nuevoRemito = new Remito();
        $planilla_id = $this->request->getPost("remito_planillaId");
        $planilla = Planilla::findFirstByPlanilla_id($planilla_id);
        if(!$planilla)
        {
            $this->flash->error('Hubo un problema, la planilla no existe.');
            $this->db->rollback();
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevoRemito",
                "params" => $planilla_id
            ));
        }
        /*==================== Generar Ultimo Nro de Remito ===============================*/
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
                    "action" => "nuevoRemito",
                    "params" => $planilla_id
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
        $tipo =$this->request->getPost('remito_tipo');

        if($tipo !=  $planilla->getPlanillaTipo())
        {
            $this->flash->error("El remito no coincide con el tipo de planilla, verifique que sean del mismo tipo");
            $this->db->rollback();
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevoRemito",
                "params" => $planilla_id
            ));
        }
        $nuevoRemito->setRemitoTipo($tipo);
        $nuevoRemito->setRemitoObservacion($this->request->getPost('remito_observacion'));
        $nuevoRemito->setRemitoConformidad($this->request->getPost('remito_conformidad'));
        $nuevoRemito->setRemitoNoConformidad($this->request->getPost('remito_noConformidad'));
        /* ==================== ==================== ==================== ==================== */
        $nuevoRemito->setRemitoTransporteId($this->request->getPost('remito_transporteId'));
        $nuevoRemito->setRemitoTipoEquipoId($this->request->getPost('remito_tipoEquipoId'));
        $nuevoRemito->setRemitoTipoCargaId($this->request->getPost('remito_tipoCargaId'));
        $nuevoRemito->setRemitoChoferId($this->request->getPost('remito_choferId'));
        /* ==================== ==================== ==================== ==================== */
        $nuevoRemito->setRemitoClienteId($this->request->getPost('cliente_id'));
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
                "action" => "nuevoRemito",
                "params" => $planilla_id
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
                $contenidoExtra->setContenidoExtraDescripcion($this->request->getPost($col->getColumnaNombre()));
                if (!$contenidoExtra->save()) {
                    foreach ($tarifa->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    $this->db->rollback();
                    return $this->dispatcher->forward(array(
                        "controller" => "remito",
                        "action" => "nuevoRemito",
                        "params" => $planilla_id
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
                "action" => "nuevoRemito",
                "params" => $planilla_id
            ));
        }
        //Limpieza del formulario.
        $remitoForm = new RemitoForm();
        $remitoForm->bind($_POST, $nuevoRemito);
        $remitoForm->clear();

        $this->db->commit();
        $this->flash->success('Remito creado satisfactoriamente');
        return $this->dispatcher->forward(array(
            "controller" => "remito",
            "action" => "nuevoRemito",
            "params" => array($planilla_id)
        ));
    }
    /***************************************************************************************************
     * Permite buscar la planilla a la cual se le va agregar el remito, y se lo redirecciona al nuevoRemito.
     */
    public function nuevoRemitoPorPlanillaAction()
    {
        $this->importarSelect2();
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
                'required' => ''
            ));
    }
    public function generarFormularioNuevoAction()
    {

        if(!$this->request->hasPost('remito_planillaId') || $this->request->getPost('remito_planillaId')==null){
            $this->flash->error("Es necesario que seleccione una planilla");
            $this->redireccionar('remito/nuevoRemitoPorPlanilla');
        }
        $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('remito_planillaId'));
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind' => array('cabecera_id' => $planilla->getPlanillaCabeceraid())
        ));

        if (count($columnas) != 0) {
            $this->view->columnaExtraForm = new ColumnaExtraForm(null, array('extra' => $columnas));
        }
        $this->view->remitoForm = new RemitoForm(null, array('required' => ''));
        $this->view->clienteForm = new ClienteNewForm(null, array('required' => ''));
        $this->view->planilla = $planilla;
        $this->view->pick('remito/nuevoRemito');
    }
    /**
     * Formulario de busqueda de remitos.
     */
    public function busquedaPersonalizadaAction()
    {
        $this->persistent->parameters = null;
        //Las columnas extras se deberian generar cuando elige una planilla (ajax)
        $this->view->remitoForm = new RemitoForm(null, array('required' => ''));
        $this->view->clienteForm = new ClienteNewForm(null, array('required' => ''));
    }



    /**
     * Encargado de recuperar los datos por post para generar un arreglo que pueda ser usado por Criteria.
     * @param $datos
     * @return array
     */
    private function generarCriterioBusqueda($datos)
    {
        $buscarRemitos = array();
        $buscarRemitos['remito_planillaId'] = $this->request->get('remito_planillaId');
        $buscarRemitos['remito_fecha'] = $this->request->get('remito_fecha');
        $buscarRemitos['remito_remito'] = $this->request->get('remito_remito');
        $buscarRemitos['remito_transporteId'] = $this->request->get('remito_transporteId');
        $buscarRemitos['remito_tipoEquipoId'] = $this->request->get('remito_tipoEquipoId');
        $buscarRemitos['remito_tipoCargaId'] = $this->request->get('remito_tipoCargaId');
        $buscarRemitos['remito_choferId'] = $this->request->get('remito_choferId');
        $buscarRemitos['remito_clienteId'] = $this->request->get('cliente_id');
        $buscarRemitos['remito_frsId'] = $this->request->get('frs_id');
        $buscarRemitos['remito_equipoPozoId'] = $this->request->get('equipoPozo_id');
        $buscarRemitos['remito_centroCostoId'] = $this->request->get('centroCosto_id');
        $buscarRemitos['remito_viajeId'] = $this->request->get('remito_viajeId');
        $buscarRemitos['remito_concatenadoId'] = $this->request->get('remito_concatenadoId');
        //Recupero la operadora_id y busco al cliente, y con el cliente puedo buscar las ordenes
        if ($this->request->has('operadora_id') && $this->request->getPost("operadora_id") != '') {
            $operadora = Operadora::findFirst(array(
                "operadora_habilitado=1 AND operadora_id = :operadora_id:",
                'bind' => array('operadora_id' => $this->request->getPost("operadora_id"))
            ));
            $buscarRemitos['remito_clienteId'] = $operadora->getOperadoraClienteId();
        }
        if ($this->request->has('linea_id') && $this->request->getPost("linea_id") != '') {
            $linea = Linea::findFirst(array(
                "linea_habilitado=1 AND linea_id = :linea_id:",
                'bind' => array('linea_id' => $this->request->getPost("linea_id"))
            ));
            $buscarRemitos['remito_clienteId'] = $linea->getLineaClienteid();
        }
        if ($this->request->has('yacimiento_id') && $this->request->getPost("yacimiento_id") != '') {
            $yacimiento = Yacimiento::findFirst(array(
                "yacimiento_habilitado=1 AND yacimiento_id = :yacimiento_id:",
                'bind' => array('yacimiento_id' => $this->request->getPost("yacimiento_id"))
            ));
            $operadora = Operadora::findFirst(array(
                "operadora_habilitado=1 AND operadora_id = :operadora_id:",
                'bind' => array('operadora_id' => $yacimiento->getYacimientoOperadoraId())
            ));
            if ($operadora)
                $buscarRemitos['remito_clienteId'] = $operadora->getOperadoraClienteId();
        }
        return $buscarRemitos;
    }


    /**
     * Proviene de << nuevoRemitoPorPlanillaAction >>
     * Selecciona la planilla a la cual se le agregará el nuevo remito.
     * Utiliza Select2
     */
    public function nuevoAction()
    {
        $this->assets->collection("headerCss")
            ->addCss('plugins/iCheck/all.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/iCheck/icheck.min.js');

        if(!$this->request->hasPost('remito_planillaId') || $this->request->getPost('remito_planillaId')==null){
            $this->flash->error("Es necesario que seleccione una planilla");
            return $this->redireccionar('remito/nuevoRemitoPorPlanilla');
        }
        $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('remito_planillaId'));
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind' => array('cabecera_id' => $planilla->getPlanillaCabeceraid())
        ));

        if (count($columnas) != 0) {
            $this->view->columnaExtraForm = new ColumnaExtraForm(null, array('extra' => $columnas));
        }
        $this->view->remitoForm = new RemitoForm(null, array('required' => ''));
        $cliente = Cliente::findFirst(array('cliente_id=:cliente_id:','bind'=>array('cliente_id'=>$planilla->getPlanillaClienteId())));
        $this->view->clienteForm  = new ClienteNewForm($cliente, array('required' => ''));
        $this->view->planilla = $planilla;
    }

    /**
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
        //Controlamos que exista la planilla
        $planilla_id = $this->request->getPost("remito_planillaId");
        $planilla = Planilla::findFirstByPlanilla_id($planilla_id);
        if(!$planilla)
        {
            $this->flash->error('Hubo un problema, la planilla no existe.');
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
                    "action" => "nuevoRemito",
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
        $tipo =$this->request->getPost('remito_tipo');
        if($tipo !=  $planilla->getPlanillaTipo())
        {
            $this->flash->error($tipo . " - ".$planilla->getPlanillaTipo()."El remito no coincide con el tipo de planilla, verifique que sean del mismo tipo");
            $this->db->rollback();
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevoRemito",
                "params" => array($planilla_id)
            ));
        }
        $nuevoRemito->setRemitoTipo($tipo);
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
                "action" => "nuevoRemito",
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
                $contenidoExtra->setContenidoExtraDescripcion($this->request->getPost($col->getColumnaNombre()));
                if (!$contenidoExtra->save()) {
                    foreach ($tarifa->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    $this->db->rollback();
                    return $this->dispatcher->forward(array(
                        "controller" => "remito",
                        "action" => "nuevoRemito",
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
                "action" => "nuevoRemito",
                "params" => array($planilla_id)
            ));
        }

        $this->db->commit();
        $this->flash->success('Remito creado satisfactoriamente');
        return $this->dispatcher->forward(array(
            "controller" => "remito",
            "action" => "nuevo",
            "params" => array($planilla_id)
        ));
    }
}
