<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CentrocostoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Centro Costo');
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
        $this->view->centroCostoForm = new CentroCostoForm();

    }

    /**
     * Searches for centrocosto
     */
    public function searchAction()
    {
        parent::importarJsTable();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Centrocosto", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "centroCosto_id";

        $centrocosto = Centrocosto::find($parameters);
        if (count($centrocosto) == 0) {
            $this->flash->notice("No se encontraron resultados en la búsqueda");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $centrocosto,
            "limit"=> 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    /**
     * Searches for centrocosto
     */
    public function buscarCCPorLineaAction($centroCosto_id)
    {
        parent::importarJsSearch();

        $numberPage = 1;
        $numberPage = $this->request->getQuery("page", "int");

        $centrocosto = Centrocosto::find(array("centroCosto_lineaId=:linea_id: AND centroCosto_habilitado=1",
            'bind'=>array('linea_id'=>$centroCosto_id)));
        if (count($centrocosto) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $centrocosto,
            "limit"=> 10000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $this->view->pick('centrocosto/search');
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->centroCostoForm = new CentroCostoForm(null, array('edit' => true));

    }

    /**
     * Edits a centrocosto
     *
     * @param string $centroCosto_id
     */
    public function editAction($centroCosto_id)
    {

        if (!$this->request->isPost()) {

            $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
            if (!$centrocosto) {
                $this->flash->error("Centro Costo no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "index"
                ));
            }
            $this->view->centroCostoForm = new CentroCostoForm($centrocosto, array('edit' => true));

            $this->view->centroCosto_id = $centrocosto->centroCosto_id;

            $this->tag->setDefault("centroCosto_id", $centrocosto->getCentrocostoId());
            $this->tag->setDefault("centroCosto_codigo", $centrocosto->getCentrocostoCodigo());
            $this->tag->setDefault("centroCosto_habilitado", $centrocosto->getCentrocostoHabilitado());
            //Asignado valor por defecto al datalist centroCosto_linea
            $centroCosto = Linea::findFirstByLinea_id($centrocosto->centroCosto_lineaId);
            if($centroCosto){
                $nombre = $centroCosto->linea_nombre;
                $this->assets->collection('footerInline')->addInlineJs("
                                            function cargarCombo() {
                                                document.getElementById('centroCosto_linea').value='$nombre';
                                            }
                                            window.onload = cargarCombo;
                                        ");
            }
        }
    }

    /**
     * Creates a new centrocosto
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centrocosto = new Centrocosto();
        if ($this->request->getPost("nuevaLinea") == 1)//Checkbox: Nueva Linea? 1:SI
        {
            $centroCosto = new Linea();
            $centroCosto->assign(array('linea_nombre'=>$this->request->getPost('linea_nombre'),
                'linea_habilitado'=>1));//el input linea_nombre es para crear una nueva linea
            if(!$centroCosto->save()){
                foreach ($centroCosto->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "new"
                ));
            }

            $centrocosto->setCentroCostoLineaId($centroCosto->getLineaId());
        } else {

            if($this->request->getPost("centroCosto_lineaId")!=NULL)
                $centrocosto->setCentroCostoLineaId($this->request->getPost("centroCosto_lineaId"));//Se utiliza una linea existente
            else{
                $this->flash->error("SELECCIONE LA LINEA");
                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "new"
                ));
            }
        }
        $centrocosto->setCentrocostoCodigo($this->request->getPost("centroCosto_codigo"));
        $centrocosto->setCentrocostoHabilitado(1);
        

        if (!$centrocosto->save()) {
            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "new"
            ));
        }

        $this->flash->success("Centro Costo ha sido creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));

    }

    /**
     * Saves a centrocosto edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centroCosto_id = $this->request->getPost("centroCosto_id");

        $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
        if (!$centrocosto) {
            $this->flash->error("Centro Costo no existe - ID: " . $centroCosto_id);

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        if ($this->request->getPost("nuevaLinea") == 1)//Checkbox: Nueva Linea? 1:SI
        {
            $centroCosto = new Linea();
            $centroCosto->assign(array('linea_nombre'=>$this->request->getPost('linea_nombre'),
                'linea_habilitado'=>1));//el input linea_nombre es para crear una nueva linea
            if(!$centroCosto->save()){
                foreach ($centroCosto->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "edit",
                    "params" => array($centrocosto->centroCosto_id)
                ));
            }

            $centrocosto->setCentroCostoLineaId($centroCosto->getLineaId());
        } else {
            if($this->request->getPost("centroCosto_lineaId")!=NULL)
                $centrocosto->setCentroCostoLineaId($this->request->getPost("centroCosto_lineaId"));//Se utiliza una linea existente
            else{
                $this->flash->error("SELECCIONE LA LINEA");
                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "edit",
                    "params" => array($centrocosto->centroCosto_id)
                ));
            }
        }
        $centrocosto->setCentrocostoCodigo($this->request->getPost("centroCosto_codigo"));
        $centrocosto->setCentrocostoHabilitado(1);
        

        if (!$centrocosto->save()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "edit",
                "params" => array($centrocosto->centroCosto_id)
            ));
        }

        $this->flash->success("Centro Costo ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));

    }

    /**
     * Deletes a centrocosto
     *
     * @param string $centroCosto_id
     */
    public function deleteAction($centroCosto_id)
    {

        $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
        if (!$centrocosto) {
            $this->flash->error("Centro Costo no ha sido encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        if (!$centrocosto->delete()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "search"
            ));
        }

        $this->flash->success("Centro Costo ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
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
            $centrocosto = centrocosto::findFirstByCentroCosto_id($id);
            if (!$centrocosto) {
                $this->flash->error("El Centro Costo  no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "index"
                ));
            }
            $centrocosto->centroCosto_habilitado = 0;
            if (!$centrocosto->update()) {

                foreach ($centrocosto->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "search"
                ));
            }

            $this->flash->success("El Centro Costo ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
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
        $centrocosto = Centrocosto::findFirstByCentroCosto_id($id);
        $centrocosto->centroCosto_habilitado = 1;
        if (!$centrocosto->update()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "search"
            ));
        }

        $this->flash->success("El Centro Costo ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "search"
        ));
    }
    public function buscarCentroCostoAction()
    {
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");
                $lista = Centrocosto::find(array(
                    "	centroCosto_lineaId = :id: AND centroCosto_habilitado=1",'bind'=>array('id'=>$id)
                ));
                $resData = array();
                foreach ($lista as $item) {
                    $resData[] = array("centroCosto_id" => $item->getCentroCostoId(), "centroCosto_codigo" => $item->getCentroCostoCodigo());
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
     * Guarda los datos enviados desde el search de linea
     */
    public function agregarCCALineaAction()
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

        $centroCosto = new Centrocosto();

        $centroCosto->setCentroCostoCodigo($this->request->getPost("centroCosto_codigo"));
        $centroCosto->setCentroCostoLineaId($this->request->getPost("centroCosto_lineaId"));
        $centroCosto->setCentroCostoHabilitado(1);


        if (!$centroCosto->save()) {
            $mensaje="No se pudo guardar";
            foreach ($centroCosto->getMessages() as $message) {
                $mensaje = $message."<br>";
            }
            $retorno['mensaje']=$mensaje;
            echo json_encode($retorno);
            return;
        }

        $retorno['mensaje']= "El Centro de Costo ha sido agregada correctamente";
        $retorno['success']=true;
        echo json_encode($retorno);
        return;
    }
}
