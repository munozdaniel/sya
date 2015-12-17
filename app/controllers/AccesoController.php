<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class AccesoController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for acceso
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Acceso", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "acceso_id";

        $acceso = Acceso::find($parameters);
        if (count($acceso) == 0) {
            $this->flash->notice("The search did not find any acceso");

            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $acceso,
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
     * Edits a acceso
     *
     * @param string $acceso_id
     */
    public function editAction($acceso_id)
    {

        if (!$this->request->isPost()) {

            $acceso = Acceso::findFirstByacceso_id($acceso_id);
            if (!$acceso) {
                $this->flash->error("acceso was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "acceso",
                    "action" => "index"
                ));
            }

            $this->view->acceso_id = $acceso->acceso_id;

            $this->tag->setDefault("acceso_id", $acceso->getAccesoId());
            $this->tag->setDefault("rol_id", $acceso->getRolId());
            $this->tag->setDefault("pagina_id", $acceso->getPaginaId());
            
        }
    }

    /**
     * Creates a new acceso
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "index"
            ));
        }

        $acceso = new Acceso();

        $acceso->setRolId($this->request->getPost("rol_id"));
        $acceso->setPaginaId($this->request->getPost("pagina_id"));
        

        if (!$acceso->save()) {
            foreach ($acceso->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "new"
            ));
        }

        $this->flash->success("acceso was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "acceso",
            "action" => "index"
        ));

    }

    /**
     * Saves a acceso edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "index"
            ));
        }

        $acceso_id = $this->request->getPost("acceso_id");

        $acceso = Acceso::findFirstByacceso_id($acceso_id);
        if (!$acceso) {
            $this->flash->error("acceso does not exist " . $acceso_id);

            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "index"
            ));
        }

        $acceso->setRolId($this->request->getPost("rol_id"));
        $acceso->setPaginaId($this->request->getPost("pagina_id"));
        

        if (!$acceso->save()) {

            foreach ($acceso->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "edit",
                "params" => array($acceso->acceso_id)
            ));
        }

        $this->flash->success("acceso was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "acceso",
            "action" => "index"
        ));

    }

    /**
     * Deletes a acceso
     *
     * @param string $acceso_id
     */
    public function deleteAction($acceso_id)
    {

        $acceso = Acceso::findFirstByacceso_id($acceso_id);
        if (!$acceso) {
            $this->flash->error("acceso was not found");

            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "index"
            ));
        }

        if (!$acceso->delete()) {

            foreach ($acceso->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "acceso",
                "action" => "search"
            ));
        }

        $this->flash->success("acceso was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "acceso",
            "action" => "index"
        ));
    }

}
