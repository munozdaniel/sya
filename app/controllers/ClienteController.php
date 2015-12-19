<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ClienteController extends ControllerBase
{

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
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $cliente,
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
            $this->tag->setDefault("cliente_linea", $cliente->getClienteLinea());
            $this->tag->setDefault("cliente_yacimiento", $cliente->getClienteYacimiento());
            $this->tag->setDefault("cliente_habilitado", $cliente->getClienteHabilitado());
            
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
        $cliente->setClienteLinea($this->request->getPost("cliente_linea"));
        $cliente->setClienteYacimiento($this->request->getPost("cliente_yacimiento"));
        $cliente->setClienteHabilitado($this->request->getPost("cliente_habilitado"));
        

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
        $cliente->setClienteLinea($this->request->getPost("cliente_linea"));
        $cliente->setClienteYacimiento($this->request->getPost("cliente_yacimiento"));
        $cliente->setClienteHabilitado($this->request->getPost("cliente_habilitado"));
        

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
