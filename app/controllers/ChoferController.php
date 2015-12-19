<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ChoferController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Chofer');
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
     * Searches for chofer
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;

        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Chofer", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "chofer_id";

        $chofer = Chofer::find($parameters);
        if (count($chofer) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $chofer,
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
     * Edits a chofer
     *
     * @param string $chofer_id
     */
    public function editAction($chofer_id)
    {

        if (!$this->request->isPost()) {

            $chofer = Chofer::findFirstBychofer_id($chofer_id);
            if (!$chofer) {
                $this->flash->error("El chofer no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "chofer",
                    "action" => "index"
                ));
            }

            $this->view->chofer_id = $chofer->chofer_id;

            $this->tag->setDefault("chofer_id", $chofer->getChoferId());
            $this->tag->setDefault("chofer_nombreCompleto", $chofer->getChoferNombrecompleto());
            $this->tag->setDefault("chofer_dni", $chofer->getChoferDni());
            $this->tag->setDefault("chofer_esFletero", $chofer->getChoferEsfletero());
            $this->tag->setDefault("chofer_habilitado", $chofer->getChoferHabilitado());
            
        }
    }

    /**
     * Creates a new chofer
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "index"
            ));
        }

        $chofer = new Chofer();

        $chofer->setChoferNombrecompleto($this->request->getPost("chofer_nombreCompleto"));
        $chofer->setChoferDni($this->request->getPost("chofer_dni"));
        $chofer->setChoferEsfletero($this->request->getPost("chofer_esFletero"));
        $chofer->setChoferHabilitado($this->request->getPost("chofer_habilitado"));
        

        if (!$chofer->save()) {
            foreach ($chofer->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "new"
            ));
        }

        $this->flash->success("El chofer has sido creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "chofer",
            "action" => "index"
        ));

    }

    /**
     * Saves a chofer edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "index"
            ));
        }

        $chofer_id = $this->request->getPost("chofer_id");

        $chofer = Chofer::findFirstBychofer_id($chofer_id);
        if (!$chofer) {
            $this->flash->error("El Chofer con el ID: " . $chofer_id." no existe");

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "index"
            ));
        }

        $chofer->setChoferNombrecompleto($this->request->getPost("chofer_nombreCompleto"));
        $chofer->setChoferDni($this->request->getPost("chofer_dni"));
        $chofer->setChoferEsfletero($this->request->getPost('chofer_esFletero'));
        $chofer->setChoferHabilitado(1);
        

        if (!$chofer->save()) {

            foreach ($chofer->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "edit",
                "params" => array($chofer->chofer_id)
            ));
        }

        $this->flash->success("El chofer ha sido actulizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "chofer",
            "action" => "index"
        ));

    }

    /**
     * Deletes a chofer
     *
     * @param string $chofer_id
     */
    public function deleteAction($chofer_id)
    {

        $chofer = Chofer::findFirstBychofer_id($chofer_id);
        if (!$chofer) {
            $this->flash->error("El chofer no se ha encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "index"
            ));
        }

        if (!$chofer->delete()) {

            foreach ($chofer->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "search"
            ));
        }

        $this->flash->success("El chofer ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "chofer",
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
            $chofer = chofer::findFirstByChofer_id($id);
            if (!$chofer) {
                $this->flash->error("El Chofer no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "chofer",
                    "action" => "index"
                ));
            }
            $chofer->chofer_habilitado = 0;
            if (!$chofer->update()) {

                foreach ($chofer->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "chofer",
                    "action" => "search"
                ));
            }

            $this->flash->success("El Chofer ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
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
        $chofer = Chofer::findFirstByChofer_id($id);
        $chofer->chofer_habilitado = 1;
        if (!$chofer->update()) {

            foreach ($chofer->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "search"
            ));
        }

        $this->flash->success("El Chofer ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "chofer",
            "action" => "search"
        ));
    }
}
