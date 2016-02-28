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
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }
    public function searchDataTableAction()
    {
        $this->assets->collection('footer')
            ->addCss('plugins/excel/tableExport.js')
            ->addCss('plugins/excel/jquery.base64.js');
        $this->importarDataTables();
        /*Criteria*/
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
            "limit"=> 3,
            "page" => $numberPage
        ));
        //Posiciones:
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_posicion')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: ',array('columna_cabeceraId'=>75))
            ->orderBy('columna_id ASC')
            ->getQuery()
            ->execute()->toArray();
        $this->view->columnas = $columnas;
        //Vistas
        $this->view->page = $paginator->getPaginate();
    }
    public function generarExcelAction()
    {
        $json = $this->request->get('json');
        $json = json_decode($json);
        var_dump($json);
       return  $this->redireccionar('remito/searchDataTable');
    }
        /*==============================================================================================*/
    /**
     * @return bool
     */
    public function searchAjaxAction(){

        $this->importarJsTable();
        /*Recuperamos la cabecera de cierta planilla*/
        $planilla = Planilla::findFirstByPlanilla_id(147);
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_nombre,columna_clave')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: ',array('columna_cabeceraId'=>$planilla->getPlanillaCabeceraId()))
            ->orderBy('columna_posicion ASC')
            ->getQuery()
            ->execute();

        $this->view->columnas = $columnas;

        /*Criteria*/
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
        //Recuperamos la planilla que contenga los criteria
        //


    }

    public function busquedaAjaxAction($offset=0, $limit=5)
    {
        $this->view->disable();
        //if($this->request->isAjax())
        //comprobamos si han llegado las variables get para setearlas
        $offset = !isset($_GET["offset"]) || $_GET["offset"] == "undefined" ? 0 : $_GET["offset"];
        $limit = !isset($_GET["limit"]) || $_GET["limit"] == "undefined" ? 200000 : $_GET["limit"];
        //obtenemos los posts
        $pag = $this->get_posts($offset,$limit);
        //obtenemos los enlaces para estos posts
        $links = $this->crea_links();
        //los devolvemos en formato json
       // echo json_encode(array("posts" => $pag,"links" => $links));

        $remito = Remito::find()->toArray();
        echo json_encode(array('data'=>$remito));
    }
    private function get_posts($offset = 0, $limit = 10)
    {
        if($offset == 0){
            $_SESSION["actual"] = 1;
        }else{
            $_SESSION["actual"] = ($offset+$limit)/$limit;
        }
        $_SESSION["limit"] = $limit;
        try {

            $sql = "SELECT * FROM Remito LIMIT ?,?";
            $query = $this->db->prepare($sql);
            $query->bindValue(1, (int) $offset, PDO::PARAM_INT);
            $query->bindValue(2, (int) $limit, PDO::PARAM_INT);
            $query->execute();

            //si existe el usuario
            if($query->rowCount() > 0)
            {

                return $query->fetchAll();

            }

        }catch(PDOException $e){

            print "Error!: " . $e->getMessage();

        }

    }
    //creamos los enlaces de nuestra paginación
    private function crea_links()
    {

        //html para retornar
        $html = "";

        //página actual
        $actual_pag = $_SESSION["actual"];

        //limite por página
        $limit = $_SESSION["limit"];

        //total de enlaces que existen
        $totalPag = floor($this->get_all_posts()/$limit);

        //links delante y detrás que queremos mostrar
        $pagVisibles = 2;

        if($actual_pag <= $pagVisibles)
        {
            $primera_pag = 1;
        }else{
            $primera_pag = $actual_pag - $pagVisibles;
        }

        if($actual_pag + $pagVisibles <= $totalPag)
        {
            $ultima_pag = $actual_pag + $pagVisibles;
        }else{
            $ultima_pag = $totalPag;
        }

        $html .= '<p>';
        $html .= ($actual_pag > 1) ?
            ' <a href="#" class="btn btn-flat" onclick="paginate(0,'.$limit.')">Primera</a>' :
            ' <a href="#" class="btn btn-flat disabled">Primera</a>';
        $html .= ($actual_pag > 1) ?
            ' <a href="#" class="btn btn-flat" onclick="paginate('.(($actual_pag-2)*$limit).','.$limit.')">Anterior</a>' :
            ' <a href="#" class="btn btn-flat disabled">Anterior</a>';

        for($i=$primera_pag; $i<=$ultima_pag+1; $i++)
        {
            $z = $i;
            $html .= ($i == $actual_pag) ?
                ' <a class="button secondary round disabled" href="#">'.$i.'</a>' :
                ' <a class="btn btn-flat" href="#" onclick="paginate('.(($z-1)*$limit).','.$limit.')">'.$i.'</a>';
        }

        $html .= ($actual_pag < $totalPag) ?
            ' <a href="#" class="btn btn-flat" onclick="paginate('.(($actual_pag)*$limit).','.$limit.')">Siguiente</a>' :
            ' <a href="#" class="btn btn-flat disabled">Siguiente</a>';
        $html .= ($actual_pag < $totalPag) ?
            ' <a href="#" class="btn btn-flat" onclick="paginate('.(($totalPag)*$limit).','.$limit.')">Última</a>' :
            ' <a href="#" class="btn btn-flat disabled">Última</a>';
        $html .= '</p>';

        return $html;

    }
    //obtenemos el número de posts totales
    private function get_all_posts()
    {
        try {

            $sql = "SELECT COUNT(*) from Remito";
            $query = $this->db->prepare($sql);
            $query->execute();

            //si es true
            if($query->rowCount() == 1)
            {

                return $query->fetchColumn();

            }

        }catch(PDOException $e){

            print "Error!: " . $e->getMessage();

        }
    }
    /*====================================================*/
    /**
     * Muestra todos los remitos de una planilla.
     * Utiliza el plugin BoostrapTable.
     */
    public function verRemitosAction($planillaId){
        if ($this->request->isAjax()) {
            $builder = $this->modelsManager->createBuilder()
                ->columns('remito_id, remito_nro, remito_transporteId, remito_conformidad')
                ->from('Example\Models\Remito');

            $dataTables = new DataTable();
            $dataTables->fromBuilder($builder)->sendResponse();
        }
    }
    /**
     * Searches for remito, suponiendo que siempre va a elegir una planilla
     */
    public function searchAction()
    {
        parent::importarJsTable();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $paginador = $this->request->getPost('paginador');
            $query = Criteria::fromInput($this->di, "Remito", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
            $paginador = 30;
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "remito_id";
        //BUSCAMOS LAS COLUMNAS NO EXTRA
        $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('remito_planillaId','int'));
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_nombre,columna_clave')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: AND columna_extra=0',array('columna_cabeceraId'=>$planilla->getPlanillaCabeceraId()))
            ->orderBy('columna_posicion ASC')
            ->getQuery()
            ->execute();
        $cad ="";
        for($i=0;$i<count($columnas);$i++){
            if($i!=0)
                $cad .=",";
            $cad .= $columnas[$i]->columna_clave;
        }
        $this->view->columnas= $columnas;

        //BUSCAMOS TODOS LOS REMITOS
        $remito = $this->modelsManager
            ->createBuilder($parameters)
            ->columns($cad)
            ->from('Remito')
            ->join('Tipoequipo')
            ->join('Transporte')
            ->join('Tipocarga')
            ->join('Chofer')
            ->join('Cliente')
            ->join('Equipopozo')
            ->join('Yacimiento','Yacimiento.yacimiento_id=Equipopozo.equipoPozo_yacimientoId','Yacimiento')
            ->join('Concatenado')
            ->join('Operadora')
            ->join('Viaje')
            ->join('Centrocosto')
            ->join('Linea','Linea.linea_id=Centrocosto.centroCosto_lineaId','Linea')
            ->join('Tarifa')
            ->getQuery()
            ->execute()->toArray();
        //BUSCAMOS LAS COLUMNAS EXTRAS Y  CONTENIDOS EXTRA
        $extra = $this->modelsManager
            ->createBuilder()
            ->columns('columna_nombre,Contenidoextra.contenidoExtra_descripcion')
            ->from('Columna')
            ->join('Contenidoextra')
            ->where('columna_cabeceraId=:columna_cabeceraId: AND columna_extra=1',array('columna_cabeceraId'=>$planilla->getPlanillaCabeceraId()))
            ->orderBy('columna_posicion ASC')
            ->getQuery()
            ->execute()->toArray();
        $this->view->extra=$extra;
        $total = array_merge($remito,$extra);
        echo "Total  ".count($remito);
        if (count($remito) == 0) {
            $this->flash->notice("No se han encontrado resultados");

            return $this->dispatcher->forward(array(
                "controller" => "remito",
                "action" => "index"
            ));
        }
        $paginator = new Paginator(array(
            "data" => $total,
            "limit"=> $paginador,
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
     * X
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
