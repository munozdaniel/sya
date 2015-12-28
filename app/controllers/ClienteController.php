<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ClienteController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Cliente');
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
     * Searches for cliente
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Cliente", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "cliente_id";

        $cliente = Cliente::find($parameters);
        if (count($cliente) == 0) {
            $this->flash->notice("The search did not find any cliente");

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $cliente,
            "limit" => 100000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->clienteForm = new ClienteForm(null, array('edit' => true));
    }

    public function buscarCentroCostoAction()
    {
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");
                $lista = Centrocosto::findByCentroCosto_lineaId($id);
                $resData = array();

                foreach ($lista as $item) {
                    $resData[] = array("centroCosto_id" => $item->centroCosto_id, "centroCosto_codigo" => $item->centroCosto_codigo);
                }


                if (count($lista) > 0) {
                    $this->response->setJsonContent(array("lista" => $resData));
                    $this->response->setStatusCode(200, "OK");
                }
                $this->response->send();
            }
        }

    }
    public function buscarEquipoPozoAction()
    {
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");
                $lista = Equipopozo::findByEquipoPozo_yacimientoId($id);
                $resData = array();

                foreach ($lista as $item) {
                    $resData[] = array("equipoPozo_id" => $item->equipoPozo_id, "equipoPozo_nombre" => $item->equipoPozo_nombre);
                }


                if (count($lista) > 0) {
                    $this->response->setJsonContent(array("lista" => $resData));
                    $this->response->setStatusCode(200, "OK");
                }
                $this->response->send();
            }
        }

    }

    /**
     * Edits a cliente
     *
     * @param string $cliente_id
     */
    public function editAction($cliente_id)
    {

        if (!$this->request->isPost()) {

            $cliente = Cliente::findFirstBycliente_id($cliente_id);
            if (!$cliente) {
                $this->flash->error("cliente was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "cliente",
                    "action" => "index"
                ));
            }

            $this->view->cliente_id = $cliente->cliente_id;

            $this->tag->setDefault("cliente_id", $cliente->getClienteId());
            $this->tag->setDefault("cliente_nombre", $cliente->getClienteNombre());
            $this->tag->setDefault("cliente_operadora", $cliente->getClienteOperadora());
            $this->tag->setDefault("cliente_frs", $cliente->getClienteFrs());
            $this->tag->setDefault("cliente_habilitado", $cliente->getClienteHabilitado());
            $this->tag->setDefault("cliente_equipoPozoId", $cliente->getClienteEquipopozoid());
            $this->tag->setDefault("cliente_centroCostoId", $cliente->getClienteCentrocostoid());

        }
    }

    /**
     * Creates a new cliente
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "index"
            ));
        }

        $cliente = new Cliente();

        $cliente->setClienteNombre($this->request->getPost("cliente_nombre"));
        $cliente->setClienteOperadora($this->request->getPost("cliente_operadora"));
        $cliente->setClienteFrs($this->request->getPost("cliente_frs"));
        $cliente->setClienteHabilitado($this->request->getPost("cliente_habilitado"));
        $cliente->setClienteEquipopozoid($this->request->getPost("cliente_equipoPozoId"));
        $cliente->setClienteCentrocostoid($this->request->getPost("cliente_centroCostoId"));


        if (!$cliente->save()) {
            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "new"
            ));
        }

        $this->flash->success("cliente was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "cliente",
            "action" => "index"
        ));

    }

    /**
     * Saves a cliente edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "index"
            ));
        }

        $cliente_id = $this->request->getPost("cliente_id");

        $cliente = Cliente::findFirstBycliente_id($cliente_id);
        if (!$cliente) {
            $this->flash->error("cliente does not exist " . $cliente_id);

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "index"
            ));
        }

        $cliente->setClienteNombre($this->request->getPost("cliente_nombre"));
        $cliente->setClienteOperadora($this->request->getPost("cliente_operadora"));
        $cliente->setClienteFrs($this->request->getPost("cliente_frs"));
        $cliente->setClienteHabilitado($this->request->getPost("cliente_habilitado"));
        $cliente->setClienteEquipopozoid($this->request->getPost("cliente_equipoPozoId"));
        $cliente->setClienteCentrocostoid($this->request->getPost("cliente_centroCostoId"));


        if (!$cliente->save()) {

            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "edit",
                "params" => array($cliente->cliente_id)
            ));
        }

        $this->flash->success("cliente was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "cliente",
            "action" => "index"
        ));

    }

    /**
     * Deletes a cliente
     *
     * @param string $cliente_id
     */
    public function deleteAction($cliente_id)
    {

        $cliente = Cliente::findFirstBycliente_id($cliente_id);
        if (!$cliente) {
            $this->flash->error("cliente was not found");

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "index"
            ));
        }

        if (!$cliente->delete()) {

            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "search"
            ));
        }

        $this->flash->success("cliente was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "cliente",
            "action" => "index"
        ));
    }

}
