<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ChoferController extends ControllerBase
{

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
            $this->flash->notice("The search did not find any chofer");

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $chofer,
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
     * Edits a chofer
     *
     * @param string $chofer_id
     */
    public function editAction($chofer_id)
    {

        if (!$this->request->isPost()) {

            $chofer = Chofer::findFirstBychofer_id($chofer_id);
            if (!$chofer) {
                $this->flash->error("chofer was not found");

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
        

        if (!$chofer->save()) {
            foreach ($chofer->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "new"
            ));
        }

        $this->flash->success("chofer was created successfully");

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
            $this->flash->error("chofer does not exist " . $chofer_id);

            return $this->dispatcher->forward(array(
                "controller" => "chofer",
                "action" => "index"
            ));
        }

        $chofer->setChoferNombrecompleto($this->request->getPost("chofer_nombreCompleto"));
        $chofer->setChoferDni($this->request->getPost("chofer_dni"));
        $chofer->setChoferEsfletero($this->request->getPost("chofer_esFletero"));
        

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

        $this->flash->success("chofer was updated successfully");

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
            $this->flash->error("chofer was not found");

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

        $this->flash->success("chofer was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "chofer",
            "action" => "index"
        ));
    }

}
