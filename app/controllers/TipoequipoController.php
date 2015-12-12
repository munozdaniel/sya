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
     * Searches for tipoequipo
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

        $tipoequipo = Tipoequipo::find($parameters);
        if (count($tipoequipo) == 0) {
            $this->flash->notice("The search did not find any tipoequipo");

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tipoequipo,
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
     * Edits a tipoequipo
     *
     * @param string $tipoEquipo_id
     */
    public function editAction($tipoEquipo_id)
    {

        if (!$this->request->isPost()) {

            $tipoequipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
            if (!$tipoequipo) {
                $this->flash->error("tipoequipo was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "tipoequipo",
                    "action" => "index"
                ));
            }

            $this->view->tipoEquipo_id = $tipoequipo->tipoEquipo_id;

            $this->tag->setDefault("tipoEquipo_id", $tipoequipo->getTipoequipoId());
            $this->tag->setDefault("tipoEquipo_nombre", $tipoequipo->getTipoequipoNombre());
            
        }
    }

    /**
     * Creates a new tipoequipo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        $tipoequipo = new Tipoequipo();

        $tipoequipo->setTipoequipoNombre($this->request->getPost("tipoEquipo_nombre"));
        

        if (!$tipoequipo->save()) {
            foreach ($tipoequipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "new"
            ));
        }

        $this->flash->success("tipoequipo was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipoequipo",
            "action" => "index"
        ));

    }

    /**
     * Saves a tipoequipo edited
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

        $tipoequipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
        if (!$tipoequipo) {
            $this->flash->error("tipoequipo does not exist " . $tipoEquipo_id);

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        $tipoequipo->setTipoequipoNombre($this->request->getPost("tipoEquipo_nombre"));
        

        if (!$tipoequipo->save()) {

            foreach ($tipoequipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "edit",
                "params" => array($tipoequipo->tipoEquipo_id)
            ));
        }

        $this->flash->success("tipoequipo was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipoequipo",
            "action" => "index"
        ));

    }

    /**
     * Deletes a tipoequipo
     *
     * @param string $tipoEquipo_id
     */
    public function deleteAction($tipoEquipo_id)
    {

        $tipoequipo = Tipoequipo::findFirstBytipoEquipo_id($tipoEquipo_id);
        if (!$tipoequipo) {
            $this->flash->error("tipoequipo was not found");

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "index"
            ));
        }

        if (!$tipoequipo->delete()) {

            foreach ($tipoequipo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipoequipo",
                "action" => "search"
            ));
        }

        $this->flash->success("tipoequipo was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipoequipo",
            "action" => "index"
        ));
    }

}
