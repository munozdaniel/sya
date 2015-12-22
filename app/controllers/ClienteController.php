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
        $this->view->formCliente= new ClienteForm();
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
                $this->flash->error("El cliente no ha sido encontrado");

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
        $cliente->setClienteHabilitado(1);
        

        if (!$cliente->save()) {
            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "new"
            ));
        }

        $this->flash->success("El Cliente se ha creado correctamente");

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
            $this->flash->error("El Cliente con el ID: " . $cliente_id." no existe");

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

        $this->flash->success("El cliente se ha actualizado correctamente");

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
            $this->flash->error("El cliente no se ha encontrado");

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

        $this->flash->success("El cliente ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "cliente",
            "action" => "index"
        ));
    }

}
