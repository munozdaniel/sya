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
        $this->importarSelect2();
        $elemento = new \Phalcon\Forms\Element\Select('cliente_id',
            Cliente::find(array('cliente_habilitado=1', 'order' => 'cliente_nombre ASC')),
            array(
                'using' => array('cliente_id', 'cliente_nombre'),
                'useEmpty' => true,
                'emptyText' => 'BUSCAR TODOS LOS CLIENTES',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'height:40px !important;'
            ));
        $this->view->formulario = $elemento;
        $this->persistent->parameters = null;
    }

    /**
     * Searches for cliente
     */
    public function searchAction()
    {
        parent::importarJsTable();

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
            "limit" => 30,
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
        $elemento = new \Phalcon\Forms\Element\Select('cliente_id',
            Cliente::find(array('cliente_habilitado=1', 'order' => 'cliente_nombre ASC')),
            array(
                'using' => array('cliente_id', 'cliente_nombre'),
                'useEmpty' => true,
                'emptyText' => 'BUSCAR TODOS LOS CLIENTES',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'height:40px !important;'
            ));
        $this->view->clienteForm  = new ClienteForm();
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

        }
    }

    /**
     * Crear un nuevo cliente
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

        $this->flash->success("El cliente se ha creado correctamente");

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

        $this->flash->success("El nombre del cliente se ha actualizado.");

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

    /**
     * Eliminar manera logica.
     *
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $cliente = Cliente::findFirstByCliente_id($id);
            if (!$cliente) {
                $this->flash->error("El Cliente no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "cliente",
                    "action" => "index"
                ));
            }
            $cliente->cliente_habilitado = 0;
            if (!$cliente->update()) {

                foreach ($cliente->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "cliente",
                    "action" => "search"
                ));
            }

            $this->flash->success("El Cliente ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
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
        $cliente = Cliente::findFirstByCliente_id($id);
        $cliente->cliente_habilitado = 1;
        if (!$cliente->update()) {

            foreach ($cliente->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cliente",
                "action" => "search"
            ));
        }

        $this->flash->success("El Cliente ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "cliente",
            "action" => "search"
        ));
    }

    /**
     * Muestra un formulario que permite gestionar individualmente cada entidad
     * del sistema.
     * Cliente/Operadora/CentroCosto/Linea/EquipoPozo/Yacimiento/Chofer/Transporte/TipoEquipo/TipoCarga/Viaje
     */
    public function gestionAction()
    {

    }
}
