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
    private  function recuperarPosiciones($cabeceraId){
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_posicion')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: ',array('columna_cabeceraId'=>75))
            ->orderBy('columna_id ASC')
            ->getQuery()
            ->execute()->toArray();
        if($columnas)
            return $columnas;
        else
            return null;
    }
    /**
     * =================================================================================================
     *                          BUSQUEDA DE REMITOS POR PLANILLA
     * =================================================================================================
     */
    /**
     * Arma un formulario con un datalist de planillas. Seleccionando la planilla se obtendrán todas sus columnas
     * para que sean reordenadas.
     * Index action
     *
     * XXXX
     */
    public function indexAction()
    {
        $this->importarDataTables();
        $this->importarSelect2();

        $this->persistent->parameters = null;
        //Posiciones:
        $columnas= $this->recuperarPosiciones(9);
        //Vistas
        $this->view->columnas = $columnas;
        $this->view->clienteForm = new ClienteNewForm();
        $this->view->formulario =  new \Phalcon\Forms\Element\Select('remito_planillaId',
            Planilla::find(array('planilla_habilitado=1 AND planilla_armada=1','order'=>'planilla_nombreCliente DESC')),
            array(
                'using'      => array('planilla_id', 'planilla_nombreCliente'),
                'useEmpty'   => false,
                'emptyText'  => 'Seleccione una planilla',
                'emptyValue' => '',
                'class'=>'form-control autocompletar',
                'style'=>'width:100%',
                'required'=>''
            ));
    }
    /**
     * =================================================================================================
     *                          BUSQUEDA DE REMITOS POR PLANILLA
     * =================================================================================================
     */
    /**
     * @return bool
     */
    public function buscarRemitoPorPlanillaAction(){
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
            Planilla::find(array('planilla_habilitado=1 AND planilla_armada=1','order'=>'planilla_nombreCliente DESC')),
            array(
                'using'      => array('planilla_id', 'planilla_nombreCliente'),
                'useEmpty'   => false,
                'emptyText'  => 'Seleccione una planilla',
                'emptyValue' => '',
                'class'=>'form-control autocompletar',
                'style'=>'width:100%',
                'required'=>''
            ));

    }

    /**
     * Se encarga de buscar todos los remitos segun la planilla_id enviada por post.
     * Muestra las columnas extras.
     */
    public function buscarRemitosPorPlanillaIdAjaxAction()
    {
        $this->view->disable();
        $remito=null;
        if($this->request->getPost()!=null)
            $remito = Remito::find(array('remito_habilitado = 1 AND remito_planillaId =:planilla_id:',
        'bind'=>array('planilla_id'=>$this->request->getPost('planilla_id')),'order by'=>'remito_nroOrden ASC'));
        $tabla= $this->generarTablaDeRemitosNuevo($remito);
        echo json_encode(array('data'=>$tabla,'id'=>count($remito)));
    }
    /**
     * =================================================================================================
     *                          BUSQUEDA DE REMITOS GRAL AJAX
     * =================================================================================================
     */

    /**
     * OK.
     * Se encarga de mostrar el formulario de busqueda de remitos, y de preparar la tabla a generar por la busqueda.
     */
    public function searchDataTableAction()
    {
        $this->importarDataTables();
        //Posiciones:
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_posicion')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: ',array('columna_cabeceraId'=>75))
            ->orderBy('columna_id ASC')
            ->getQuery()
            ->execute()->toArray();
        //Vistas
        $this->view->columnas = $columnas;
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
        foreach($_POST as $arreglo)
        {
            $retorno[$arreglo['name']]= $arreglo['value'];
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
        $tabla= $this->generarTablaDeRemitosNuevo($remito);
        echo json_encode(array('data'=>$tabla));
    }
    /**
     * A partir de una orden recuperar los datos importantes obtenidos con la clave foranea
     * @param $remito
     * @return array
     */
    private function generarTablaDeRemitosNuevo($remito,$extra=''){
        $tabla = array();
        foreach ($remito as $unRemito) {
            $fila = array();
            $planilla = Planilla::findFirstByPlanilla_id($unRemito->getRemitoPlanillaId());

            /*================ Planilla ================*/
            $fila['planilla_nombreCliente']=$planilla->getPlanillaNombreCliente();
            $fila['remito_planillaId']=$unRemito->getRemitoPlanillaId();

            /*================ Remito ================*/
            $fila['remito_nroOrden']=$unRemito->getRemitoNroOrden();
            $fila['remito_fecha']= date('d/m/Y', date(strtotime(date($unRemito->getRemitoFecha()))));
            $fila['remito_nro']=$unRemito->getRemitoNro();//remito Sya
            $fila['remito_pdf']=$unRemito->getRemitoPdf();//remito Sya


            /*================ Transporte ================*/
            $fila['transporte_dominio']=$unRemito->getTransporte()->getTransporteDominio();
            $fila['transporte_nroInterno']=$unRemito->getTransporte()->getTransporteNroInterno();

            /*================ TipoEquipo ================*/
            $fila['tipoEquipo_nombre']=$unRemito->getTipoequipo()->getTipoEquipoNombre();

            /*================ TipoCarga ================*/
            $fila['tipoCarga_nombre']=$unRemito->getTipocarga()->getTipoCargaNombre();

            /*================ Chofer ================*/
            $fila['chofer_dni']=$unRemito->getChofer()->getChoferDni();
            $fila['chofer_nombreCompleto']=$unRemito->getChofer()->getChoferNombreCompleto();
            $fila['chofer_esFletero']=($unRemito->getChofer()->getChoferEsFletero()==1?'SI':'NO');

            /*================ Cliente ================*/
            $fila['cliente_nombre']=$unRemito->getCliente()->getClienteNombre();

            /*================ Operadora ================*/
            //FIXME: NO puedo mostrar el nombre de la operadora!! Porque no tiene operadora cargada!
            if($unRemito->getOperadora() != null)
                $fila['operadora_nombre'] = $unRemito->getOperadora()->getOperadoraNombre();
            else
                $fila['operadora_nombre'] = "NO ESTA CARGADO";

            /*================ EquipoPozo ================*/
            $fila['equipoPozo_nombre']= $unRemito->getEquipopozo()->getEquipoPozoNombre();

            /*================ Yacimiento ================*/
            $yacimiento = Yacimiento::findFirstByYacimiento_id($unRemito->getEquipopozo()->getEquipopozoYacimientoid());
            $fila['yacimiento_destino'] = $yacimiento->getYacimientoDestino();


            /*================ CentroCosto ================*/
            $fila['centroCosto_codigo'] = $unRemito->getCentrocosto()->getCentroCostoCodigo();

            /*================ Linea ================*/
            $linea = Linea::findFirstByLinea_id($unRemito->getCentrocosto()->getCentroCostoLineaId());
            $fila['linea_nombre']= $linea->getLineaNombre();

            /*================ Viaje ================*/
            $fila['viaje_origen']= $unRemito->getViaje()->getViajeOrigen();
            /*================ Concatenado ================*/
            $fila['concatenado_nombre']= $unRemito->getConcatenado()->getConcatenadoNombre();

            /*================ Tarifa ================*/
            $fila['tarifa_hsServicio']= $unRemito->getTarifa()->getTarifaHsServicio();
            $fila['tarifa_hsKm']=  $unRemito->getTarifa()->getTarifaKm();
            $fila['tarifa_hsHidro']=  $unRemito->getTarifa()->getTarifaHsHidro();
            $fila['tarifa_hsMalacate']=  $unRemito->getTarifa()->getTarifaHsMalacate();
            $fila['tarifa_hsStand']=  $unRemito->getTarifa()->getTarifaHsStand();

            /*================ Orden ================*/
            $fila['remito_observaciones']=$unRemito->getRemitoObservacion();
            $fila['remito_conformidad']=($unRemito->getRemitoConformidad()==NULL?"SIN ESPECIFICAR":$unRemito->getRemitoConformidad());
            $fila['remito_noConformidad']=($unRemito->getRemitoNoConformidad()==NULL?"SIN ESPECIFICAR":$unRemito->getRemitoNoConformidad());
            /*================ Extra ================*/
            if($extra=="extra"){
                $cabecera= Cabecera::findFirst(array('cabecera_id=:cabecera_id: AND cabecera_habilitado=1',
                    array('bind'=>array('cabecera_id'=>$planilla->getPlanillaCabeceraid()))));
                if($cabecera)
                {
                    $columnas= Columna::find(array('columna_cabeceraId = :cabecera_id: AND columna_extra=1 AND columna_habilitado=1',
                        array('bind',array('cabecera_id'=>$cabecera->getCabeceraId()))));
                    foreach($columnas as $col){

                    }
                }
            }
            $tabla[] = $fila;
        }
        return $tabla;
    }
    /*==============================================================================================*/
    public function searchRemitoSinPDFAction(){
        $this->importarDataTables();
        //Posiciones:
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_posicion')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: ',array('columna_cabeceraId'=>75))
            ->orderBy('columna_id ASC')
            ->getQuery()
            ->execute()->toArray();
        //Vistas
        $this->view->columnas = $columnas;
        $this->view->remitoForm = new RemitoForm();
        $this->view->clienteForm = new ClienteNewForm();
    }
    public function buscarSinRemitoEscaneadoAction(){
        $this->view->disable();
        /*=================*/
        $retorno = array();
        foreach($_POST as $arreglo)
        {
            $retorno[$arreglo['name']]= $arreglo['value'];
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
        $remito = Remito::find(array(' remito_pdf IS NULL'));
        $tabla= $this->generarTablaDeRemitosNuevo($remito);
        echo json_encode(array('data'=>$tabla));
    }
    /*==============================================================================================*/


    /**
     * Searches for remito, suponiendo que siempre va a elegir una planilla
     */
    public function searchAction()
    {
        parent::importarJsTable();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Remito", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "remito_id";
        $remito = Remito::find($parameters);
        if (count($remito) == 0) {
            $this->flash->notice("The search did not find any remito");

            return $this->dispatcher->forward(array(
                "controller" => "index",
                "action" => "dashboard"
            ));
        }
        $paginator = new PaginatorModelo(array(
            "data" => $remito,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

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
     * Creates a new remito
     * X
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }

        $remito = new Remito();

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
                "action" => "new"
            ));
        }

        $this->flash->success("remito was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "remito",
            "action" => "index"
        ));

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
     * A partir de una orden recuperar los datos importantes obtenidos con la clave foranea
     * @param $remito
     * @return array
     * X NO SIRVE
     */
    private function generarTablaDeRemitos($remito){
        $tabla = null;
        foreach ($remito as $unRemito) {
            $fila = array();
            $planilla = Planilla::findFirstByPlanilla_id($unRemito->getRemitoPlanillaId());
            /*================ Planilla ================*/
            $fila['planilla_nombreCliente']=$planilla->getPlanillaNombreCliente();
            $fila['remito_planillaId']=$unRemito->getRemitoPlanillaId();

            /*================ Remito ================*/
            $fila['remito_nro']=$unRemito->getRemitoNro();
            $fila['remito_nroOrden']=$unRemito->getRemitoNroOrden();
            $fila['remito_fecha']= date('d/m/Y', date(strtotime(date($unRemito->getRemitoFecha()))));
            $fila['remito_periodo']=$unRemito->getRemitoPeriodo();

            /*================ Transporte ================*/
            $transporte = Transporte::findFirstByTransporte_id($unRemito->getRemitoTransporteId());
            $fila['transporte_dominio']=$transporte->getTransporteDominio();
            $fila['transporte_nroInterno']=$transporte->getTransporteNroInterno();

            /*================ TipoEquipo ================*/
            $tipoEquipo = Tipoequipo::findFirstByTipoEquipo_id($unRemito->getRemitoTipoEquipoId());
            $fila['tipoEquipo_nombre']=$tipoEquipo->getTipoEquipoNombre();

            /*================ TipoCarga ================*/
            $tipoCarga = Tipocarga::findFirstByTipoCarga_id($unRemito->getRemitoTipoCargaId());
            $fila['tipoCarga_nombre']=$tipoCarga->getTipoCargaNombre();

            /*================ Chofer ================*/
            $chofer = Chofer::findFirstByChofer_id($unRemito->getRemitoChoferId());
            $fila['chofer_dni']=$chofer->getChoferDni();
            $fila['chofer_nombreCompleto']=$chofer->getChoferNombreCompleto();
            $fila['chofer_esFletero']=($chofer->getChoferEsFletero()==1?'SI':'NO');

            /*================ Cliente ================*/
            $cliente = Cliente::findFirstByCliente_id($unRemito->getRemitoClienteId());
            $fila['cliente_nombre']=$cliente->getClienteNombre();

            /*================ Operadora ================*/
            $operadora = Operadora::findFirstByOperadora_id($unRemito->getRemitoOperadoraId());
            $fila['operadora_nombre'] = $operadora->getOperadoraNombre();

            /*================ EquipoPozo ================*/
            $equipoPozo = Equipopozo::findFirstByEquipoPozo_id($unRemito->getRemitoEquipoPozoId());
            $fila['equipoPozo_nombre']= $equipoPozo->getEquipoPozoNombre();

            /*================ Yacimiento ================*/
            $yacimiento = Yacimiento::findFirstByYacimiento_id($equipoPozo->getEquipoPozoYacimientoId());
            $fila['yacimiento_destino'] = $yacimiento->getYacimientoDestino();


            /*================ CentroCosto ================*/
            $centroCosto = Centrocosto::findFirstByCentroCosto_id($unRemito->getRemitoCentroCostoId());
            $fila['centroCosto_codigo'] = $centroCosto->getCentroCostoCodigo();

            /*================ Linea ================*/
            $linea = Linea::findFirstByLinea_id($centroCosto->getCentroCostoLineaId());
            $fila['linea_nombre']= $linea->getLineaNombre();

            /*================ Viaje ================*/
            $viaje = Viaje::findFirstByViajeId($unRemito->getRemitoViajeId());
            $fila['viaje_origen']= $viaje->getViajeOrigen();
            $fila['viaje_concatenado']= $viaje->getViajeConcatenado();

            /*================ Tarifa ================*/
            $tarifa = Tarifa::findFirst();
            $fila['tarifa_hsServicio']= $tarifa->getTarifaHsServicio();
            $fila['tarifa_hsKm']= $tarifa->getTarifaKm();
            $fila['tarifa_hsHidro']= $tarifa->getTarifaHsHidro();
            $fila['tarifa_hsMalacate']= $tarifa->getTarifaHsMalacate();
            $fila['tarifa_hsStand']= $tarifa->getTarifaHsStand();

            /*================ Remito ================*/
            $fila['remito_observaciones']=$unRemito->getRemitoObservacion();
            $fila['remito_conformidad']=($unRemito->getRemitoConformidad()==NULL?"SIN ESPECIFICAR":$unRemito->getRemitoConformidad());
            $fila['remito_noConformidad']=($unRemito->getRemitoNoConformidad()==NULL?"SIN ESPECIFICAR":$unRemito->getRemitoNoConformidad());

            $tabla[] = $fila;
        }
        return $tabla;
    }

    /**
     * Nuevo remito, arma un formulario para cargar todos los datos correspondientes a un remito.
     */
    public function nuevoRemitoAction($planilla_id){
        $planilla = Planilla::findFirstByPlanilla_id($planilla_id);
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind'=>array('cabecera_id'=>$planilla->getPlanillaCabeceraid())
        ));

        if(count($columnas)!=0)
        {
            $this->view->columnaExtraForm = new ColumnaExtraForm(null,array('extra'=>$columnas));
        }
        $this->view->remitoForm = new RemitoForm(null,array('required'=>''));
        $this->view->clienteForm = new ClienteNewForm(null,array('required'=>''));
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
        /*==================== Generar Ultimo Nro de Remito ===============================*/
        $ultimoRemito = Remito::findFirst(array(
            "remito_ultima = 1 AND remito_habilitado=1 AND remito_planillaId = :planilla_id:",
            'bind'=>array('planilla_id'=>$planilla_id)
        ));
        if(!$ultimoRemito){
            $nuevoRemito->setRemitoUltima(1);
            $nuevoRemito->setRemitoNroOrden(1);
        }else{
            $nuevoRemito->setRemitoUltima(1);
            $ultimoRemito->setRemitoUltima(0);
            $nuevoRemito->setRemitoNroOrden($ultimoRemito->getRemitoNroOrden()+1);
            if(!$ultimoRemito->update())
            {
                $this->flash->error('Hubo un problema con la conexion, intenteló nuevamente');
                $this->db->rollback();
                return $this->dispatcher->forward(array(
                    "controller" => "remito",
                    "action" => "nuevoRemito",
                    "params"=>$planilla_id
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
                "params"=>$planilla_id
            ));
        }
        $nuevoRemito->setRemitoTarifaId($tarifa->getTarifaId());
        /* ==================== ==================== ==================== ==================== */
        $planilla = Planilla::findFirstByPlanilla_id($planilla_id);
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1",
            'bind'=>array('cabecera_id'=>$planilla->getPlanillaCabeceraid())
        ));

        if(count($columnas)!=0)
        {
            foreach($columnas as $col){
                $contenidoExtra = new Contenidoextra();
                $contenidoExtra->setContenidoExtraHabilitado(1);
                $contenidoExtra->setContenidoExtraColumnaId($col->getColumnaId());
                $contenidoExtra->setContenidoExtraDescripcion($this->request->getPost($col->getColumnaNombre()));
                if(!$contenidoExtra->save())
                {
                    foreach ($tarifa->getMessages() as $mensaje) {
                        $this->flash->error($mensaje);
                    }
                    $this->db->rollback();
                    return $this->dispatcher->forward(array(
                        "controller" => "remito",
                        "action" => "nuevoRemito",
                        "params"=>$planilla_id
                    ));
                }
            }
        }
        /* ==================== ==================== ==================== ==================== */
        if(!$nuevoRemito->save())
        {
            foreach ($nuevoRemito->getMessages() as $mensaje) {
                $this->flash->error($mensaje);
            }
            $this->db->rollback();
            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "nuevoRemito",
                "params"=>$planilla_id
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
            "params"=>array($planilla_id)
        ));
    }

    /**
     * Formulario de busqueda de remitos.
     */
    public function busquedaPersonalizadaAction()
    {
        $this->persistent->parameters = null;
        //Las columnas extras se deberian generar cuando elige una planilla (ajax)
        $this->view->remitoForm = new RemitoForm(null,array('required'=>''));
        $this->view->clienteForm = new ClienteNewForm(null,array('required'=>''));
    }
    /**
     * Realizar una busqueda con filtros, personalizada.
     * Realizar una busqueda sin filtros. (Absolutamente Todos los remitos)
     * Realizar la busqueda de todos los remitos por planilla.
     */
    public function listarRemitosAction()
    {
        parent::importarJsTable();
        if ($this->request->isPost()) {
            //$buscarRemitos = $this->generarCriterioBusqueda($_POST);
            $query = Criteria::fromInput($this->di, "Remitos", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }
        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["remito"] = "remito_id";

        $remito = Remito::find($parameters);
        if (count($remito) == 0) {
            $this->flash->notice("No se han encontrado resultados.");

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }

        $tabla = $this->generarTablaDeRemitosNuevo($remito);
        $planilla = Planilla::findFirstByPlanilla_id($tabla[0]['remito_planillaId']);
        $cabeceraTh = Columna::verColumnasOrdenadasByCabeceraId($planilla->getPlanillaCabeceraid());

        if($cabeceraTh)
            $this->view->cabeceraTh = $cabeceraTh;

        /*$final = array();
        foreach($tabla as $cont) {
            $list = array();
            for ($i = 0; $i < count($cabeceraTh); $i++) {
                $list[$cabeceraTh[$i]->getColumnaClave()] = $cont[$cabeceraTh[$i]->getColumnaClave()];
            }
            $final[]=$list;
        }
*/
        $paginator = new Paginator(array(
            "data" => $tabla,
            "limit" => 100,
            "page" => $numberPage
        ));

        if($planilla)
            $this->view->planilla = $planilla;
        $this->view->page = $paginator->getPaginate();

    }
    /**
     * Encargado de recuperar los datos por post para generar un arreglo que pueda ser usado por Criteria.
     * @param $datos
     * @return array
     */
    private function generarCriterioBusqueda($datos){
        $buscarRemitos = array();
        $buscarRemitos['remito_planillaId']= $this->request->get('remito_planillaId');
        $buscarRemitos['remito_fecha']= $this->request->get('remito_fecha');
        $buscarRemitos['remito_remito']= $this->request->get('remito_remito');
        $buscarRemitos['remito_transporteId']= $this->request->get('remito_transporteId');
        $buscarRemitos['remito_tipoEquipoId']= $this->request->get('remito_tipoEquipoId');
        $buscarRemitos['remito_tipoCargaId']= $this->request->get('remito_tipoCargaId');
        $buscarRemitos['remito_choferId']= $this->request->get('remito_choferId');
        $buscarRemitos['remito_clienteId']= $this->request->get('cliente_id');
        $buscarRemitos['remito_frsId']= $this->request->get('frs_id');
        $buscarRemitos['remito_equipoPozoId']= $this->request->get('equipoPozo_id');
        $buscarRemitos['remito_centroCostoId']= $this->request->get('centroCosto_id');
        $buscarRemitos['remito_viajeId']= $this->request->get('remito_viajeId');
        $buscarRemitos['remito_concatenadoId']= $this->request->get('remito_concatenadoId');
        //Recupero la operadora_id y busco al cliente, y con el cliente puedo buscar las ordenes
        if($this->request->has('operadora_id') && $this->request->getPost("operadora_id")!='')
        {
            $operadora = Operadora::findFirst(array(
                "operadora_habilitado=1 AND operadora_id = :operadora_id:",
                'bind'=>array('operadora_id'=>$this->request->getPost("operadora_id"))
            ));
            $buscarRemitos['remito_clienteId']= $operadora->getOperadoraClienteId();
        }
        if($this->request->has('linea_id') && $this->request->getPost("linea_id")!='')
        {
            $linea = Linea::findFirst(array(
                "linea_habilitado=1 AND linea_id = :linea_id:",
                'bind'=>array('linea_id'=>$this->request->getPost("linea_id"))
            ));
            $buscarRemitos['remito_clienteId']= $linea->getLineaClienteid();
        }
        if($this->request->has('yacimiento_id') && $this->request->getPost("yacimiento_id")!='')
        {
            $yacimiento = Yacimiento::findFirst(array(
                "yacimiento_habilitado=1 AND yacimiento_id = :yacimiento_id:",
                'bind'=>array('yacimiento_id'=>$this->request->getPost("yacimiento_id"))
            ));
            $operadora = Operadora::findFirst(array(
                "operadora_habilitado=1 AND operadora_id = :operadora_id:",
                'bind'=>array('operadora_id'=>$yacimiento->getYacimientoOperadoraId())
            ));
            if($operadora)
                $buscarRemitos['remito_clienteId']= $operadora->getOperadoraClienteId();
        }
        return $buscarRemitos;
    }


}
