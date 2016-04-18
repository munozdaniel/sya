<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class YacimientoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Yacimiento');
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
        $this->view->yacimientoForm = new YacimientoForm();
    }

    /**
     * Searches for yacimiento
     */
    public function searchAction()
    {
        parent::importarJsTable();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Yacimiento", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "yacimiento_id";

        $yacimiento = Yacimiento::find($parameters);
        if (count($yacimiento) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $yacimiento,
            "limit"=> 10000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->importarSelect2();
        $this->view->yacimientoForm = new YacimientoForm(null,array('edit'=>'true','required'=>'required'));

    }

    /**
     * Edits a yacimiento
     *
     * @param string $yacimiento_id
     * @return boolean
     */
    public function editAction($yacimiento_id)
    {

        if (!$this->request->isPost()) {

            $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
            if (!$yacimiento) {
                $this->flash->error("El yacimiento no se encontro");

                return $this->dispatcher->forward(array(
                    "controller" => "yacimiento",
                    "action" => "index"
                ));
            }
            $this->view->yacimientoForm = new YacimientoForm($yacimiento,array('required'=>'required'));

            $this->view->yacimiento_id = $yacimiento->yacimiento_id;

            $this->tag->setDefault("yacimiento_id", $yacimiento->getYacimientoId());
            $this->tag->setDefault("yacimiento_destino", $yacimiento->getYacimientoDestino());
            $operadoras = Operadora::find(array('operadora_habilitado=1 AND operadora_yacimientoId=:yacimiento_id:',
                'bind'=>array('yacimiento_id'=>$yacimiento->yacimiento_id)));

            $equiposPozos = Equipopozo::find(array('equipoPozo_habilitado=1 AND equipoPozo_yacimientoId=:yacimiento_id:',
                'bind'=>array('yacimiento_id'=>$yacimiento->yacimiento_id)));
            
        }
    }

    /**
     * Creates a new yacimiento
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }
        $yacimientoForm = new YacimientoForm(null,array('required'=>'required'));
        $yacimiento = new Yacimiento();
        $data = $this->request->getPost();
        if (!$yacimientoForm->isValid($data, $yacimiento)) {
            foreach ($yacimientoForm->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "new"
            ));
        }

        if (!$yacimiento->save()) {
            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "new"
            ));
        }
        $yacimientoForm->clear();
        $this->flash->success("El yacimiento fue creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));

    }

    /**
     * Saves a yacimiento edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento_id = $this->request->getPost("yacimiento_id");

        $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
        if (!$yacimiento) {
            $this->flash->error("El Yacimiento no existe ID: " . $yacimiento_id);

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento->setYacimientoDestino($this->request->getPost("yacimiento_destino"));
        $yacimiento->setYacimientoHabilitado($this->request->getPost("yacimiento_habilitado"));
        

        if (!$yacimiento->save()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "edit",
                "params" => array($yacimiento->yacimiento_id)
            ));
        }

        $this->flash->success("El yacimiento ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));

    }

    /**
     * Deletes a yacimiento
     *
     * @param string $yacimiento_id
     * @return string
     */
    public function deleteAction($yacimiento_id)
    {

        $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
        if (!$yacimiento) {
            $this->flash->error("El Yacimiento no se encuentra");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        if (!$yacimiento->delete()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "search"
            ));
        }

        $this->flash->success("El Yacimiento se ha eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));
    }
    /**
     * Eliminar un yacimiento de manera logica.
     *
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $yacimiento = Yacimiento::findFirstByYacimiento_id($id);
            if (!$yacimiento) {
                $this->flash->error("El yacimiento no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "yacimiento",
                    "action" => "index"
                ));
            }
            $yacimiento->yacimiento_habilitado = 0;
            if (!$yacimiento->update()) {

                foreach ($yacimiento->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "yacimiento",
                    "action" => "search"
                ));
            }

            $this->flash->success("El yacimiento ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "search"
            ));
        }
    }

    /**
     * Habilitar un yacimiento.
     * @param $idTransporte
     * @return bool
     */
    public function habilitarAction($idTransporte)
    {
        $yacimiento = Yacimiento::findFirstByYacimiento_id($idTransporte);
        $yacimiento->yacimiento_habilitado = 1;
        if (!$yacimiento->update()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "search"
            ));
        }

        $this->flash->success("El yacimiento ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "search"
        ));
    }
    public function buscarYacimientosAction()
    {
        $this->view->disable();
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");

                $lista = Yacimiento::find(array(
                    "yacimiento_operadoraId = :id: AND yacimiento_habilitado=1",'bind'=>array('id'=>$id)
                ));
                $resData = array();

                foreach ($lista as $item) {
                    $resData[] = array("yacimiento_id" => $item->getYacimientoId(), "yacimiento_destino" => $item->getYacimientoDestino());
                }
                if (count($lista) > 0) {
                    $this->response->setJsonContent(array("lista" => $resData));
                    $this->response->setStatusCode(200, "OK");
                }else{
                    $this->response->setJsonContent(array("lista" => null));

                }
                $this->response->send();
            }
        }
    }
    public function cargarDependientesAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success']=false;
        $retorno['mensaje'][]='-';
        if(!$this->request->isPost()){
            $retorno['mensaje']="LOS DATOS NO FUERON ENVIADO POR POST";
            echo json_encode($retorno);
            return;
        }
        $yacimiento_id = $this->request->getPost('yacimiento_id','int');
        $yacimiento = Yacimiento::findFirst(array('yacimiento_id=:yacimiento_id:',
            'bind'=>array('yacimiento_id'=>$yacimiento_id)));
        if(!$yacimiento)
        {
            $retorno['mensaje']="NO SE ENCONTRÓ NINGÚN YACIMIENTO CARGADO EN LA BASE DE DATOS";
            echo json_encode($retorno);
            return;
        }
        $operadoras = Operadora::find(array('operadora_habilitado=1 AND operadora_yacimientoId=:yacimiento_id:',
            'bind'=>array('yacimiento_id'=>$yacimiento_id)));
        if(!$operadoras)
        {
            $retorno['tiene_op']=false;
            $retorno['mensaje']="EL YACIMIENTO SELECCIONADO NO TIENE OPERADORAS CARGADAS.";
        }else{
            $retorno['tiene_op']=true;
            $op=array();
            foreach($operadoras as $operadora){
                $item = array();
                $item['valor']=$operadora->getOperadoraId();
                $item['nombre']=$operadora->getOperadoraNombre();
                $op[] = $item;
            }
            $retorno['operadoras']=$op;
        }
        $equipos= Equipopozo::find(array('equipoPozo_habilitado=1 AND equipoPozo_yacimientoId=:yacimiento_id:',
            'bind'=>array('yacimiento_id'=>$yacimiento_id)));
        if(!$equipos){
            $retorno['tiene_eq']=false;
            $retorno['mensaje']="EL YACIMIENTO SELECCIONADO NO TIENE EQUIPOS/POZOS CARGADAS.";
        }
        else{
            $retorno['tiene_eq']=true;
            $eq = array();
            foreach ($equipos as $equipo) {
                $item = array();
                $item['valor']=$equipo->getEquipoPozoId();
                $item['nombre']=$equipo->getEquipoPozoNombre();
                $eq[]=$item;
            }
            $retorno['equipos']=$eq;
        }
        $retorno['success']=true;
        echo json_encode($retorno);
        return;
    }
}
