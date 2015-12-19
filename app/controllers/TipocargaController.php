<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TipocargaController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Tipo Carga');
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
     * Searches for tipocarga
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Tipocarga", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "tipoCarga_id";

        $tipocarga = Tipocarga::find($parameters);
        if (count($tipocarga) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tipocarga,
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

    }

    /**
     * Edits a tipocarga
     *
     * @param string $tipoCarga_id
     */
    public function editAction($tipoCarga_id)
    {

        if (!$this->request->isPost()) {

            $tipocarga = Tipocarga::findFirstBytipoCarga_id($tipoCarga_id);
            if (!$tipocarga) {
                $this->flash->error("El Tipo de Carga no se ha encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "tipocarga",
                    "action" => "index"
                ));
            }

            $this->view->tipoCarga_id = $tipocarga->tipoCarga_id;

            $this->tag->setDefault("tipoCarga_id", $tipocarga->getTipocargaId());
            $this->tag->setDefault("tipoCarga_nombre", $tipocarga->getTipocargaNombre());
            $this->tag->setDefault("tipoCarga_habilitado", $tipocarga->getTipocargaHabilitado());
            
        }
    }

    /**
     * Creates a new tipocarga
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $tipocarga = new Tipocarga();

        $tipocarga->setTipocargaNombre($this->request->getPost("tipoCarga_nombre"));
        $tipocarga->setTipocargaHabilitado(1);
        

        if (!$tipocarga->save()) {
            foreach ($tipocarga->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "new"
            ));
        }

        $this->flash->success("El tipo de Carga ha sido creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "tipocarga",
            "action" => "index"
        ));

    }

    /**
     * Saves a tipocarga edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $tipoCarga_id = $this->request->getPost("tipoCarga_id");

        $tipocarga = Tipocarga::findFirstBytipoCarga_id($tipoCarga_id);
        if (!$tipocarga) {
            $this->flash->error("El tipo de Carga con el ID: " . $tipoCarga_id." no se ha encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $tipocarga->setTipocargaNombre($this->request->getPost("tipoCarga_nombre"));
        $tipocarga->setTipocargaHabilitado($this->request->getPost("tipoCarga_habilitado"));
        

        if (!$tipocarga->save()) {

            foreach ($tipocarga->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "edit",
                "params" => array($tipocarga->tipoCarga_id)
            ));
        }

        $this->flash->success("El tipo de Carga ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "tipocarga",
            "action" => "index"
        ));

    }

    /**
     * Deletes a tipocarga
     *
     * @param string $tipoCarga_id
     */
    public function deleteAction($tipoCarga_id)
    {

        $tipocarga = Tipocarga::findFirstBytipoCarga_id($tipoCarga_id);
        if (!$tipocarga) {
            $this->flash->error("El tipo de carga no ha sido encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        if (!$tipocarga->delete()) {

            foreach ($tipocarga->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "search"
            ));
        }

        $this->flash->success("El tipo de carga ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "tipocarga",
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
            $tipoCarga = Tipocarga::findFirstByTipoCarga_id($id);
            if (!$tipoCarga) {
                $this->flash->error("El Tipo de Carga no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "tipocarga",
                    "action" => "index"
                ));
            }
            $tipoCarga->tipoCarga_habilitado = 0;
            if (!$tipoCarga->update()) {

                foreach ($tipoCarga->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "tipocarga",
                    "action" => "search"
                ));
            }

            $this->flash->success("El Tipo de Carga ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
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
        $tipoCarga = Tipocarga::findFirstByTipoCarga_id($id);
        $tipoCarga->tipoCarga_habilitado = 1;
        if (!$tipoCarga->update()) {

            foreach ($tipoCarga->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "search"
            ));
        }

        $this->flash->success("El Tipo de Carga ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "tipocarga",
            "action" => "search"
        ));
    }
}
