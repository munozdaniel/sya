<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ContenidoextraController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for contenidoextra
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Contenidoextra", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "contenidoExtra_id";

        $contenidoextra = Contenidoextra::find($parameters);
        if (count($contenidoextra) == 0) {
            $this->flash->notice("The search did not find any contenidoextra");

            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $contenidoextra,
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
     * Edits a contenidoextra
     *
     * @param string $contenidoExtra_id
     */
    public function editAction($contenidoExtra_id)
    {

        if (!$this->request->isPost()) {

            $contenidoextra = Contenidoextra::findFirstBycontenidoExtra_id($contenidoExtra_id);
            if (!$contenidoextra) {
                $this->flash->error("contenidoextra was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "contenidoextra",
                    "action" => "index"
                ));
            }

            $this->view->contenidoExtra_id = $contenidoextra->contenidoExtra_id;

            $this->tag->setDefault("contenidoExtra_id", $contenidoextra->getContenidoextraId());
            $this->tag->setDefault("contenidoExtra_descripcion", $contenidoextra->getContenidoextraDescripcion());
            $this->tag->setDefault("contenidoExtra_habilitado", $contenidoextra->getContenidoextraHabilitado());
            $this->tag->setDefault("contenidoExtra_columnaId", $contenidoextra->getContenidoextraColumnaid());
            
        }
    }

    /**
     * Creates a new contenidoextra
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "index"
            ));
        }

        $contenidoextra = new Contenidoextra();

        $contenidoextra->setContenidoextraDescripcion($this->request->getPost("contenidoExtra_descripcion"));
        $contenidoextra->setContenidoextraHabilitado($this->request->getPost("contenidoExtra_habilitado"));
        $contenidoextra->setContenidoextraColumnaid($this->request->getPost("contenidoExtra_columnaId"));
        

        if (!$contenidoextra->save()) {
            foreach ($contenidoextra->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "new"
            ));
        }

        $this->flash->success("contenidoextra was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "contenidoextra",
            "action" => "index"
        ));

    }

    /**
     * Saves a contenidoextra edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "index"
            ));
        }

        $contenidoExtra_id = $this->request->getPost("contenidoExtra_id");

        $contenidoextra = Contenidoextra::findFirstBycontenidoExtra_id($contenidoExtra_id);
        if (!$contenidoextra) {
            $this->flash->error("contenidoextra does not exist " . $contenidoExtra_id);

            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "index"
            ));
        }

        $contenidoextra->setContenidoextraDescripcion($this->request->getPost("contenidoExtra_descripcion"));
        $contenidoextra->setContenidoextraHabilitado($this->request->getPost("contenidoExtra_habilitado"));
        $contenidoextra->setContenidoextraColumnaid($this->request->getPost("contenidoExtra_columnaId"));
        

        if (!$contenidoextra->save()) {

            foreach ($contenidoextra->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "edit",
                "params" => array($contenidoextra->contenidoExtra_id)
            ));
        }

        $this->flash->success("contenidoextra was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "contenidoextra",
            "action" => "index"
        ));

    }

    /**
     * Deletes a contenidoextra
     *
     * @param string $contenidoExtra_id
     */
    public function deleteAction($contenidoExtra_id)
    {

        $contenidoextra = Contenidoextra::findFirstBycontenidoExtra_id($contenidoExtra_id);
        if (!$contenidoextra) {
            $this->flash->error("contenidoextra was not found");

            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "index"
            ));
        }

        if (!$contenidoextra->delete()) {

            foreach ($contenidoextra->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "contenidoextra",
                "action" => "search"
            ));
        }

        $this->flash->success("contenidoextra was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "contenidoextra",
            "action" => "index"
        ));
    }

}
