<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TipoequipoController extends ControllerBase
{

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
            $this->flash->notice("The search did not find any tipoEquipo");

            return $this->dispatcher->forward(array(
                "controller" => "tipoEquipo",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tipoEquipo,
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
     * Edits a tipoEquipo
     *
     * @param string $tipoEquipo_id
     */
    public function editAction($tipoEquipo_id)
    {

        if (!$this->request->isPost()) {

            $tipoEquipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
            if (!$tipoEquipo) {
                $this->flash->error("tipoEquipo was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "tipoEquipo",
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
                "controller" => "tipoEquipo",
                "action" => "index"
            ));
        }

        $tipoEquipo = new Tipoequipo();

        $tipoEquipo->setTipoequipoNombre($this->request->getPost("tipoEquipo_nombre"));
        $tipoEquipo->setTipoequipoHabilitado($this->request->getPost("tipoEquipo_habilitado"));
        

        if (!$tipoEquipo->save()) {
            foreach ($tipoEquipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoEquipo",
                "action" => "new"
            ));
        }

        $this->flash->success("tipoEquipo was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipoEquipo",
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
                "controller" => "tipoEquipo",
                "action" => "index"
            ));
        }

        $tipoEquipo_id = $this->request->getPost("tipoEquipo_id");

        $tipoEquipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
        if (!$tipoEquipo) {
            $this->flash->error("tipoEquipo does not exist " . $tipoEquipo_id);

            return $this->dispatcher->forward(array(
                "controller" => "tipoEquipo",
                "action" => "index"
            ));
        }

        $tipoEquipo->setTipoequipoNombre($this->request->getPost("tipoEquipo_nombre"));
        $tipoEquipo->setTipoequipoHabilitado($this->request->getPost("tipoEquipo_habilitado"));
        

        if (!$tipoEquipo->save()) {

            foreach ($tipoEquipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoEquipo",
                "action" => "edit",
                "params" => array($tipoEquipo->tipoEquipo_id)
            ));
        }

        $this->flash->success("tipoEquipo was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipoEquipo",
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
            $this->flash->error("tipoEquipo was not found");

            return $this->dispatcher->forward(array(
                "controller" => "tipoEquipo",
                "action" => "index"
            ));
        }

        if (!$tipoEquipo->delete()) {

            foreach ($tipoEquipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoEquipo",
                "action" => "search"
            ));
        }

        $this->flash->success("tipoEquipo was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipoEquipo",
            "action" => "index"
        ));
    }

}
