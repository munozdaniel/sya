<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TipoequipoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Tipo de Equipo');
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
     * Searches for tipoEquipo
     */
    public function searchAction()
    {
        parent::importarJsTable();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Tipoequipo", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "tipoEquipo_id";

        $tipoEquipo = Tipoequipo::find($parameters);
        if (count($tipoEquipo) == 0) {
            $this->flash->notice("No se encontraron registros");

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tipoEquipo,
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
     * Edits a tipoEquipo
     *
     * @param string $tipoEquipo_id
     */
    public function editAction($tipoEquipo_id)
    {

        if (!$this->request->isPost()) {

            $tipoEquipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
            if (!$tipoEquipo) {
                $this->flash->error("El tipo de Equipo no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "tipoequipo",
                    "action" => "index"
                ));
            }

            $this->view->tipoEquipo_id = $tipoEquipo->tipoEquipo_id;

            $this->tag->setDefault("tipoEquipo_id", $tipoEquipo->getTipoequipoId());
            $this->tag->setDefault("tipoEquipo_nombre", $tipoEquipo->getTipoequipoNombre());
            $this->tag->setDefault("tipoEquipo_habilitado", $tipoEquipo->getTipoequipoHabilitado());

        }
    }

    /**
     * Creates a new tipoEquipo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        $tipoEquipo = new Tipoequipo();

        $tipoEquipo->setTipoequipoNombre($this->request->getPost("tipoEquipo_nombre"));
        $tipoEquipo->setTipoequipoHabilitado(1);
        

        if (!$tipoEquipo->save()) {
            foreach ($tipoEquipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "new"
            ));
        }

        $this->flash->success("El tipo de equipo ha sido creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "tipoequipo",
            "action" => "index"
        ));

    }

    /**
     * Saves a tipoEquipo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        $tipoEquipo_id = $this->request->getPost("tipoEquipo_id");

        $tipoEquipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
        if (!$tipoEquipo) {
            $this->flash->error("El tipo de Equipo con el ID: " . $tipoEquipo_id." no se ha encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        $tipoEquipo->setTipoequipoNombre($this->request->getPost("tipoEquipo_nombre"));


        if (!$tipoEquipo->save()) {

            foreach ($tipoEquipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "edit",
                "params" => array($tipoEquipo->tipoEquipo_id)
            ));
        }

        $this->flash->success("El tipo de equipo ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "tipoequipo",
            "action" => "index"
        ));

    }

    /**
     * Deletes a tipoEquipo
     *
     * @param string $tipoEquipo_id
     */
    public function deleteAction($tipoEquipo_id)
    {

        $tipoEquipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
        if (!$tipoEquipo) {
            $this->flash->error("El tipo de equipo no ha sido encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        if (!$tipoEquipo->delete()) {

            foreach ($tipoEquipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "search"
            ));
        }

        $this->flash->success("el tipo de equipo ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "tipoequipo",
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
            $tipoEquipo = Tipoequipo::findFirstByTipoEquipo_id($id);
            if (!$tipoEquipo) {
                $this->flash->error("El Tipo de Equipo no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "tipoequipo",
                    "action" => "index"
                ));
            }
            $tipoEquipo->tipoEquipo_habilitado = 0;
            if (!$tipoEquipo->update()) {

                foreach ($tipoEquipo->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "tipoequipo",
                    "action" => "search"
                ));
            }

            $this->flash->success("El Tipo de Equipo ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
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
        $tipoEquipo= Tipoequipo::findFirstByTipoEquipo_id($id);
        $tipoEquipo->tipoEquipo_habilitado = 1;
        if (!$tipoEquipo->update()) {

            foreach ($tipoEquipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "search"
            ));
        }

        $this->flash->success("El Tipo de Equipo ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "tipoequipo",
            "action" => "search"
        ));
    }
}
