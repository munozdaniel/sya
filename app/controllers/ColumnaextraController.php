<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ColumnaextraController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for columnaextra
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Columnaextra", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "columnaExtra_id";

        $columnaextra = Columnaextra::find($parameters);
        if (count($columnaextra) == 0) {
            $this->flash->notice("The search did not find any columnaextra");

            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $columnaextra,
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
     * Edits a columnaextra
     *
     * @param string $columnaExtra_id
     */
    public function editAction($columnaExtra_id)
    {

        if (!$this->request->isPost()) {

            $columnaextra = Columnaextra::findFirstBycolumnaExtra_id($columnaExtra_id);
            if (!$columnaextra) {
                $this->flash->error("columnaextra was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "columnaextra",
                    "action" => "index"
                ));
            }

            $this->view->columnaExtra_id = $columnaextra->columnaExtra_id;

            $this->tag->setDefault("columnaExtra_id", $columnaextra->getColumnaextraId());
            $this->tag->setDefault("columnaExtra_nombre", $columnaextra->getColumnaextraNombre());
            $this->tag->setDefault("columnaExtra_descripcion", $columnaextra->getColumnaextraDescripcion());
            
        }
    }

    /**
     * Creates a new columnaextra
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "index"
            ));
        }

        $columnaextra = new Columnaextra();

        $columnaextra->setColumnaextraNombre($this->request->getPost("columnaExtra_nombre"));
        $columnaextra->setColumnaextraDescripcion($this->request->getPost("columnaExtra_descripcion"));
        

        if (!$columnaextra->save()) {
            foreach ($columnaextra->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "new"
            ));
        }

        $this->flash->success("columnaextra was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "columnaextra",
            "action" => "index"
        ));

    }

    /**
     * Saves a columnaextra edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "index"
            ));
        }

        $columnaExtra_id = $this->request->getPost("columnaExtra_id");

        $columnaextra = Columnaextra::findFirstBycolumnaExtra_id($columnaExtra_id);
        if (!$columnaextra) {
            $this->flash->error("columnaextra does not exist " . $columnaExtra_id);

            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "index"
            ));
        }

        $columnaextra->setColumnaextraNombre($this->request->getPost("columnaExtra_nombre"));
        $columnaextra->setColumnaextraDescripcion($this->request->getPost("columnaExtra_descripcion"));
        

        if (!$columnaextra->save()) {

            foreach ($columnaextra->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "edit",
                "params" => array($columnaextra->columnaExtra_id)
            ));
        }

        $this->flash->success("columnaextra was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "columnaextra",
            "action" => "index"
        ));

    }

    /**
     * Deletes a columnaextra
     *
     * @param string $columnaExtra_id
     */
    public function deleteAction($columnaExtra_id)
    {

        $columnaextra = Columnaextra::findFirstBycolumnaExtra_id($columnaExtra_id);
        if (!$columnaextra) {
            $this->flash->error("columnaextra was not found");

            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "index"
            ));
        }

        if (!$columnaextra->delete()) {

            foreach ($columnaextra->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "columnaextra",
                "action" => "search"
            ));
        }

        $this->flash->success("columnaextra was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "columnaextra",
            "action" => "index"
        ));
    }

}
