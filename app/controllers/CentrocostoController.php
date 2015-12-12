<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CentrocostoController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for centrocosto
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Centrocosto", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "centroCosto_id";

        $centrocosto = Centrocosto::find($parameters);
        if (count($centrocosto) == 0) {
            $this->flash->notice("The search did not find any centrocosto");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $centrocosto,
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
     * Edits a centrocosto
     *
     * @param string $centroCosto_id
     */
    public function editAction($centroCosto_id)
    {

        if (!$this->request->isPost()) {

            $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
            if (!$centrocosto) {
                $this->flash->error("centrocosto was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "index"
                ));
            }

            $this->view->centroCosto_id = $centrocosto->centroCosto_id;

            $this->tag->setDefault("centroCosto_id", $centrocosto->getCentrocostoId());
            $this->tag->setDefault("centroCosto_codigo", $centrocosto->getCentrocostoCodigo());
            
        }
    }

    /**
     * Creates a new centrocosto
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centrocosto = new Centrocosto();

        $centrocosto->setCentrocostoCodigo($this->request->getPost("centroCosto_codigo"));
        

        if (!$centrocosto->save()) {
            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "new"
            ));
        }

        $this->flash->success("centrocosto was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));

    }

    /**
     * Saves a centrocosto edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centroCosto_id = $this->request->getPost("centroCosto_id");

        $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
        if (!$centrocosto) {
            $this->flash->error("centrocosto does not exist " . $centroCosto_id);

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centrocosto->setCentrocostoCodigo($this->request->getPost("centroCosto_codigo"));
        

        if (!$centrocosto->save()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "edit",
                "params" => array($centrocosto->centroCosto_id)
            ));
        }

        $this->flash->success("centrocosto was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));

    }

    /**
     * Deletes a centrocosto
     *
     * @param string $centroCosto_id
     */
    public function deleteAction($centroCosto_id)
    {

        $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
        if (!$centrocosto) {
            $this->flash->error("centrocosto was not found");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        if (!$centrocosto->delete()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "search"
            ));
        }

        $this->flash->success("centrocosto was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));
    }

}
