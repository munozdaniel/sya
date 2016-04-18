<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * Las Siguientes busquedas deberán ser cambiadas para utilizar datatables
 * buscarLineaPorId
 * searchAction
 * buscarLineasPorClienteAction
 * Class LineaController
 */
class LineaController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Linea');
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
    /*INICIO BUSCADORES*/
    /**
     * Searches for linea
     */
    public function searchAction()
    {
        parent::importarJsTable();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Linea", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "linea_id";

        $linea = Linea::find($parameters);
        if (count($linea) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $linea,
            "limit"=> 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    /**
     * Busca todas las lineas de un cliente especifico. Se utiliza en las tablas.
     */
    public function buscarLineasPorClienteAction($cliente_id)
    {
        parent::importarJsTable();

        $numberPage = 1;
        $numberPage = $this->request->getQuery("page", "int");
        $linea = Linea::find(array('linea_clienteId=:cliente_id: AND linea_habilitado=1',
            'bind'=>array('cliente_id'=>$cliente_id),'order by'=>'linea_nombre ASC'));
        if (count($linea) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }
        $paginator = new Paginator(array(
            "data" => $linea,
            "limit"=> 10000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->pick('linea/search');
    }
    /**
     * Buscar la linea correspondiente a un ID enviado por GET
     * @return bool
     */
    public function buscarLineaPorIdAction()
    {
        if(!$this->request->isGet()){
            return $this->redireccionar('linea/index');
        }
        parent::importarJsSearch();

        $numberPage = 1;
        $numberPage = $this->request->getQuery("page", "int");
        $linea = Linea::find(array('linea_id=:linea_id:',
            'bind'=>array('linea_id'=>$this->request->get('linea_id')),'order by'=>'linea_nombre ASC'));
        if (count($linea) == 0) {
            $this->flash->notice("No se encontraron resultados en la búsqueda");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }
        $paginator = new Paginator(array(
            "data" => $linea,
            "limit"=> 10000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->pick('linea/search');
    }
    /*FIN BUSCADORES*/
    /**
     * Displays the creation form
     */
    public function newAction()
    {
        //SELECT2
        $this->importarSelect2();
        $select = new \Phalcon\Forms\Element\Select('linea_clienteId',
            Cliente::find(array('cliente_habilitado=1', 'order' => 'cliente_nombre DESC')),
            array(
                'using' => array('cliente_id', 'cliente_nombre'),
                'useEmpty' => true,
                'emptyText' => 'SELECCIONE UN CLIENTE',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'required' => ''
            ));
        $select->clear();
        $this->view->cliente =$select;
    }

    /**
     * Edits a linea
     *
     * @param string $linea_id
     */
    public function editAction($linea_id)
    {

        if (!$this->request->isPost()) {

            $linea = Linea::findFirstBylinea_id($linea_id);
            if (!$linea) {
                $this->flash->error("La linea no se encontró");

                return $this->dispatcher->forward(array(
                    "controller" => "linea",
                    "action" => "index"
                ));
            }

            $this->view->linea_id = $linea->linea_id;
            //SELECT2
            $this->importarSelect2();
            $select = new \Phalcon\Forms\Element\Select('linea_clienteId',
                Cliente::find(array('cliente_habilitado=1', 'order' => 'cliente_nombre DESC')),
                array(
                    'using' => array('cliente_id', 'cliente_nombre'),
                    'useEmpty' => true,
                    'emptyText' => 'SELECCIONE UN CLIENTE',
                    'emptyValue' => '',
                    'class' => 'form-control autocompletar',
                    'style' => 'width:100%',
                    'required' => ''
                ));
            $this->view->cliente =$select;
            $this->tag->setDefault("linea_id", $linea->getLineaId());
            $this->tag->setDefault("linea_nombre", $linea->getLineaNombre());
            $this->tag->setDefault("linea_clienteId", $linea->getLineaClienteId());
            $this->tag->setDefault("linea_habilitado", $linea->getLineaHabilitado());
            
        }
    }

    /**
     * Creates a new linea
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea = new Linea();

        $linea->setLineaNombre($this->request->getPost("linea_nombre"));
        $linea->setLineaClienteId($this->request->getPost("linea_clienteId"));
        $linea->setLineaHabilitado(1);
        

        if (!$linea->save()) {
            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "new"
            ));
        }

        $this->flash->success("La linea ha sido creada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));

    }


    /**
     * Saves a linea edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea_id = $this->request->getPost("linea_id");

        $linea = Linea::findFirstBylinea_id($linea_id);
        if (!$linea) {
            $this->flash->error("La linea no existe - ID: " . $linea_id);

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea->setLineaNombre($this->request->getPost("linea_nombre"));
        $linea->setLineaClienteId($this->request->getPost("linea_clienteId"));
        $linea->setLineaHabilitado(1);
        

        if (!$linea->save()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "edit",
                "params" => array($linea->linea_id)
            ));
        }

        $this->flash->success("La linea ha sido actualizada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));

    }

    /**
     * Deletes a linea
     *
     * @param string $linea_id
     */
    public function deleteAction($linea_id)
    {

        $linea = Linea::findFirstBylinea_id($linea_id);
        if (!$linea) {
            $this->flash->error("La linea no se encontró");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        if (!$linea->delete()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "search"
            ));
        }

        $this->flash->success("La linea se ha eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));
    }
    /**
     * Eliminar manera logica.
     *
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $linea = Linea::findFirstByLinea_id($id);
            if (!$linea) {
                $this->flash->error("La Linea no ha sido encontrada");

                return $this->dispatcher->forward(array(
                    "controller" => "linea",
                    "action" => "index"
                ));
            }
            $linea->linea_habilitado = 0;
            if (!$linea->update()) {

                foreach ($linea->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "linea",
                    "action" => "search"
                ));
            }

            $this->flash->success("La Linea ha sido eliminada correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "search"
            ));
        }
    }

    /**
     * Habilitar.
     * @return bool
     */
    public function habilitarAction($id)
    {
        $linea = Linea::findFirstByLinea_id($id);
        $linea->linea_habilitado = 1;
        if (!$linea->update()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "search"
            ));
        }

        $this->flash->success("La Linea ha sido habilitada");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "search"
        ));
    }

    /**
     * Metodo ajax
     */
    public function buscarLineasAction()
    {
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");
                $lista = Linea::find(array(
                    "linea_clienteId = :id: AND linea_habilitado=1",'bind'=>array('id'=>$id)
                ));
                $resData = array();
                foreach ($lista as $item) {
                    $resData[] = array("linea_id" => $item->getLineaId(), "linea_nombre" => $item->getLineaNombre());
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

    /**
     * Creates a new linea
     */
    public function agregarLineaAlClienteAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        $retorno['mensaje'] = " - ";
        if (!$this->request->isAjax()) {
            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "index"
            ));
        }

        $linea = new Linea();

        $linea->setLineaNombre($this->request->getPost("linea_nombre"));
        $linea->setLineaClienteId($this->request->getPost("linea_clienteId"));
        $linea->setLineaHabilitado(1);


        if (!$linea->save()) {
            $mensaje="No se pudo guardar";
            foreach ($linea->getMessages() as $message) {
                $mensaje = $message."<br>";
            }
            $retorno['mensaje']=$mensaje;
            echo json_encode($retorno);
            return;
        }

        $retorno['mensaje']= "La linea ha sido agregada correctamente";
        $retorno['success']=true;
        echo json_encode($retorno);
        return;
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
        $linea_id = $this->request->getPost('linea_id','int');
        $linea = Linea::findFirst(array('linea_id=:linea_id:',
            'bind'=>array('linea_id'=>$linea_id)));
        if(!$linea)
        {
            $retorno['mensaje']="NO SE ENCONTRÓ NINGUNA LINEA CARGADA EN LA BASE DE DATOS";
            echo json_encode($retorno);
            return;
        }
        $centros = Centrocosto::find(array('centroCosto_habilitado=1 AND centroCosto_lineaId=:centroCosto_lineaId:',
            'bind'=>array('centroCosto_lineaId'=>$linea_id)));
        if(!$centros)
        {
            $retorno['mensaje']="LA LINEA SELECCIONADA NO TIENE CENTROS DE COSTOS CARGADOS.";

        }
        else{
            $c = array();
            foreach ($centros as $centro) {
                $item = array();
                $item['valor']=$centro->getCentroCostoId();
                $item['nombre']=$centro->getCentroCostoCodigo();
                $c[]=$item;
            }
            $retorno['centros']=$c;
            $retorno['success']=true;
        }
        echo json_encode($retorno);
        return;
    }
}
