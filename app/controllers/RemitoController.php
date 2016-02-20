<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Phalcon\Paginator\Adapter\Model as PaginatorModelo;

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
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }
    public function searchAjaxAction(){$this->importarDataTables();}
    public function ajaxAction()
    {
        $this->view->disable();
        $datos=array();
        $datos['draw']=1;
        $datos['recordsTotal']=57;
        $datos['recordsFiltered']=57;
        $columns = array();
        $columns[] = array('first_name'=>'Daniel','last_name'=>'Munoz','position'=>'Analista',
            'office'=>'SAN FRAN','start_date'=>'ojo','salary'=>'5pe');
        $datos['data']=$columns;

       echo json_encode($datos);
    }
    /**
     * Searches for remito
     */
    public function verRemitosAction()
    {
        parent::importarDataTables();

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
                "controller" => "remito",
                "action" => "index"
            ));
        }

        $paginator = new PaginatorModelo(array(
            "data" => $remito,
            "limit"=> 10,
            "page" => $numberPage
        ));
        $this->view->pick('remito/search');

        $this->view->page = $paginator->getPaginate();
    }

    /*====================================================*/
    /**
     * Muestra todos los remitos de una planilla.
     * Utiliza el plugin BoostrapTable.
     */
    public function verRemitos1Action($planillaId)
    {
        parent::importarJsTable();
        $numberPage = $this->request->getQuery("page", "int");

        $cabeceraTh = Columna::columnasOrdenadasByPlanilla(27);
        $select="";
        foreach($cabeceraTh as $c){
            $select .=$c->getColumnaClave()." , ";
        }


        $phql = "SELECT Remito.remito_id,Remito.remito_nro,Remito.remito_tipo, Remito.remito_planillaId,Planilla.planilla_nombreCliente,
 Remito.remito_periodo,Transporte.transporte_dominio,Transporte.transporte_nroInterno, Tipoequipo.tipoEquipo_nombre, Tipocarga.tipoCarga_nombre,
  Chofer.chofer_nombreCompleto,Chofer.chofer_dni,Chofer.chofer_esFletero, Viaje.viaje_origen, Concatenado.concatenado_nombre, Tarifa.tarifa_hsServicio,Tarifa.tarifa_hsHidro,
  Tarifa.tarifa_hsMalacate,Tarifa.tarifa_hsStand,Tarifa.tarifa_km, Remito.remito_clienteId, Centrocosto.centroCosto_codigo,Equipopozo.equipoPozo_nombre,
   Operadora.operadora_nombre, Remito.remito_observacion, Remito.remito_pdf, Remito.remito_fecha, Remito.remito_conformidad, Remito.remito_noConformidad
FROM Remito,Planilla,Transporte,Chofer,Tipocarga,Tipoequipo,Viaje,Concatenado,Cliente,Tarifa,Centrocosto,Equipopozo,Operadora
WHERE Remito.remito_planillaId=Planilla.planilla_id AND
Remito.remito_transporteId=Transporte.transporte_id AND
Remito.remito_choferId=Chofer.chofer_id AND
Remito.remito_tipoEquipoId=Tipoequipo.tipoEquipo_id AND
Remito.remito_tipoCargaId=Tipocarga.tipoCarga_id AND
Remito.remito_viajeId=Viaje.viaje_id AND
Remito.remito_concatenadoId=Concatenado.concatenado_id AND
Remito.remito_clienteId = Cliente.cliente_id AND
Remito.remito_tarifaId=Tarifa.tarifa_id AND
Remito.remito_centroCostoId = Centrocosto.centroCosto_id AND
Equipopozo.equipoPozo_id=Remito.remito_equipoPozoId AND
Remito.remito_operadoraId=Operadora.operadora_id AND
Planilla.planilla_id=27
";
        $remito = $this->modelsManager->executeQuery($phql);
        /*$remito = Remito::find(array(
            'columns'=>'DISTINCT remito.*',
            'conditions'=>''
        ));*/
        if (count($remito) == 0) {
            $this->flash->notice("The search did not find any remito");

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }

        //$tabla = $this->generarTablaDeRemitosNuevo($remito);
        if($cabeceraTh)
        $this->view->cabeceraTh = $cabeceraTh;
        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
            "builder" => $remito,
            "limit"=> 20,
            "page" => 1
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->pick('remito/search');

    }
    /**
     * Searches for remito, suponiendo que siempre va a elegir una planilla
     */
    public function searchAction()
    {/**
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
        var_dump($parameters);
        $cabeceraTh = Columna::columnasOrdenadasByPlanilla(27);
        $select="";
        foreach($cabeceraTh as $c){
            $select .=$c->getColumnaClave()." , ";
        }
        $remito = $this->modelsManager
            ->createBuilder($parameters)
            ->columns('DISTINCT *')
            ->addFrom('Remito','remito')
            ->join('Planilla','planilla.planilla_id=Remito.remito_planillaId','planilla')
            ->join('Cabecera','cabecera.cabecera_id=planilla.planilla_cabeceraId','cabecera')
            ->join('Columna','columna.columna_cabeceraId=cabecera.cabecera_id','columna')
            ->orderBy('columna.columna_posicion ASC')
            ->getQuery()
            ->execute()
            ->toArray();
        //$remito = Remito::find(array(
        //    'columns'=>'DISTINCT remito.*',
        //    'conditions'=>''
        //));
        if (count($remito) == 0) {
            $this->flash->notice("The search did not find any remito");

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }

        //$tabla = $this->generarTablaDeRemitosNuevo($remito);
        if($cabeceraTh)
            $this->view->cabeceraTh = $cabeceraTh;
        $paginator = new Paginator(array(
            "data" => $remito,
            "limit"=> 100000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
*/
        parent::importarDataTables();

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
                "controller" => "remito",
                "action" => "index"
            ));
        }

        $paginator = new PaginatorModelo(array(
            "data" => $remito,
            "limit"=> 10,
            "page" => $numberPage
        ));
        $this->view->pick('remito/search');

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
     */
    private function generarTablaDeRemitos($remito){
        $tabla = null;
        $remito = Remito::find();
        foreach ($remito as $unRemito) {
            $fila = array();
            $planilla = Planilla::findFirstByPlanilla_id($unRemito->getRemitoPlanillaId());
            /*================ Planilla ================*/
            $fila['planilla_nombreCliente']=$planilla->getPlanillaNombreCliente();
            $fila['remito_planillaId']=$unRemito->getRemitoPlanillaId();

            /*================ Remito ================*/
            $fila['remito_nro']=$unRemito->getRemitoNro();
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
        $cabeceraTh = Columna::columnasOrdenadasByPlanilla($planilla->getPlanillaCabeceraid());

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

    /**
     * A partir de una orden recuperar los datos importantes obtenidos con la clave foranea
     * @param $remito
     * @return array
     */
    private function generarTablaDeRemitosNuevo($remito){
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
            $fila['remito_periodo']=$unRemito->getRemitoPeriodo();
            $fila['remito_nro']=$unRemito->getRemitoNro();//remito Sya


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
           $fila['operadora_nombre'] = "9"; //$unRemito->getOperadora()->getOperadoraNombre();

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
            $tarifa = Tarifa::findFirst();
            $fila['tarifa_hsServicio']= $unRemito->getTarifa()->getTarifaHsServicio();
            $fila['tarifa_hsKm']=  $unRemito->getTarifa()->getTarifaKm();
            $fila['tarifa_hsHidro']=  $unRemito->getTarifa()->getTarifaHsHidro();
            $fila['tarifa_hsMalacate']=  $unRemito->getTarifa()->getTarifaHsMalacate();
            $fila['tarifa_hsStand']=  $unRemito->getTarifa()->getTarifaHsStand();

            /*================ Orden ================*/
            $fila['remito_observaciones']=$unRemito->getRemitoObservacion();
            $fila['remito_conformidad']=($unRemito->getRemitoConformidad()==NULL?"SIN ESPECIFICAR":$unRemito->getRemitoConformidad());
            $fila['remito_noConformidad']=($unRemito->getRemitoNoConformidad()==NULL?"SIN ESPECIFICAR":$unRemito->getRemitoNoConformidad());

            $tabla[] = $fila;
        }
        return $tabla;
    }
}
