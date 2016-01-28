<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OperadoraController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Operadora');
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

    /**
     * Searches for operadora
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Operadora", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "operadora_id";

        $operadora = Operadora::find($parameters);
        if (count($operadora) == 0) {
            $this->flash->notice("No se han encontrado resultados");

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $operadora,
            "limit"=> 100000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $nombre= new DataListElement('cliente_nombre',
            array(
                array('placeholder' => 'SELECCIONE EL CLIENTE','required'=>'', 'class'=>'form-control', 'maxlength' => 60),
                Cliente::find(array('cliente_habilitado=1','order'=>'cliente_nombre')),
                array('cliente_id', 'cliente_nombre'),
                'cliente_id'
            ));
        $this->view->cliente_nombre = $nombre;

    }

    /**
     * Edits a operadora
     *
     * @param string $operadora_id
     */
    public function editAction($operadora_id)
    {

        if (!$this->request->isPost()) {

            $operadora = Operadora::findFirstByoperadora_id($operadora_id);
            if (!$operadora) {
                $this->flash->error("La Operadora no se encontró");

                return $this->dispatcher->forward(array(
                    "controller" => "operadora",
                    "action" => "index"
                ));
            }

            $this->view->operadora_id = $operadora->operadora_id;

            $this->tag->setDefault("operadora_id", $operadora->getOperadoraId());
            $this->tag->setDefault("operadora_nombre", $operadora->getOperadoraNombre());
            $this->tag->setDefault("operadora_habilitado", $operadora->getOperadoraHabilitado());
            
        }
    }

    /**
     * Creates a new operadora
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $operadora = new Operadora();

        $operadora->setOperadoraNombre($this->request->getPost("operadora_nombre"));
        $operadora->setOperadoraClienteId($this->request->getPost("cliente_id"));
        $operadora->setOperadoraHabilitado(1);
        

        if (!$operadora->save()) {
            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "new"
            ));
        }

        $this->flash->success("La Operadora ha sido creada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
            "action" => "index"
        ));

    }
    /**
     * Agregar una nueva operadora
     */
    public function agregarAction()
    {


        $this->view->disable();
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $operadora = new Operadora();

                $operadora->setOperadoraNombre($this->request->getPost("operadora_nombreNew"));
                $operadora->setOperadoraHabilitado(1);
                if (!$operadora->save()) {
                    $mensaje ="";
                    foreach ($operadora->getMessages() as $message) {
                        $mensaje .= $message ." <br>";
                    }
                    $this->response->setStatusCode(500, "<div class='alert alert-danger' ><i class='fa fa-fw fa-warning'></i> <br>".$mensaje."</div>");
                }
                else{
 /*                   $lista = Operadora::find();
                    $resData = array();

                    foreach ($lista as $item) {
                        $resData[] = array("operadora_id" => $item->operadora_id, "operadora_nombre" => $item->operadora_nombre);
                    }
                    $this->response->setJsonContent(array("lista" => $resData));*/
                    $this->response->setStatusCode(200, "<div class='alert alert-success' >"." OPERACIÓN EXITOSA <br> Si desea puede continuar agregando "."</div>");
                }
                $this->response->send();
            }
        }


    }

    /**
     * Saves a operadora edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $operadora_id = $this->request->getPost("operadora_id");

        $operadora = Operadora::findFirstByoperadora_id($operadora_id);
        if (!$operadora) {
            $this->flash->error("La operadora NO existe " );

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $operadora->setOperadoraNombre($this->request->getPost("operadora_nombre"));
        $operadora->setOperadoraHabilitado($this->request->getPost("operadora_habilitado"));
        

        if (!$operadora->save()) {

            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "edit",
                "params" => array($operadora->operadora_id)
            ));
        }

        $this->flash->success("La Operadora se ha actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
            "action" => "index"
        ));

    }

    /**
     * Deletes a operadora
     *
     * @param string $operadora_id
     */
    public function deleteAction($operadora_id)
    {

        $operadora = Operadora::findFirstByoperadora_id($operadora_id);
        if (!$operadora) {
            $this->flash->error("La Operadora no se encontró");

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        if (!$operadora->delete()) {

            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "search"
            ));
        }

        $this->flash->success("La Operadora ha sido eliminada correctamente.");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
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
            $operadora = Operadora::findFirstByOperadora_id($id);
            if (!$operadora) {
                $this->flash->error("La Operadora no ha sido encontrada");

                return $this->dispatcher->forward(array(
                    "controller" => "operadora",
                    "action" => "index"
                ));
            }
            $operadora->operadora_habilitado = 0;
            if (!$operadora->update()) {

                foreach ($operadora->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "operadora",
                    "action" => "search"
                ));
            }

            $this->flash->success("La Operadora ha sido eliminada correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
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
        $operadora = Operadora::findFirstByOperadora_id($id);
        $operadora->operadora_habilitado = 1;
        if (!$operadora->update()) {

            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "search"
            ));
        }

        $this->flash->success("La Operadora ha sido habilitada");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
            "action" => "search"
        ));
    }
    public function buscarOperadorasAction()
    {
        $this->view->disable();
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");

                $lista = Operadora::find(array(
                    "operadora_clienteId = :id: AND operadora_habilitado=1",'bind'=>array('id'=>$id)
                ));
                $resData = array();

                foreach ($lista as $item) {
                    $resData[] = array("operadora_id" => $item->getOperadoraId(), "operadora_nombre" => $item->getOperadoraNombre());
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
}
