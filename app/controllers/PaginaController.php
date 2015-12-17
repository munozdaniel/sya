<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PaginaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for pagina
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Pagina", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "pagina_id";

        $pagina = Pagina::find($parameters);
        if (count($pagina) == 0) {
            $this->flash->notice("The search did not find any pagina");

            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $pagina,
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
     * Edits a pagina
     *
     * @param string $pagina_id
     */
    public function editAction($pagina_id)
    {

        if (!$this->request->isPost()) {

            $pagina = Pagina::findFirstBypagina_id($pagina_id);
            if (!$pagina) {
                $this->flash->error("pagina was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "pagina",
                    "action" => "index"
                ));
            }

            $this->view->pagina_id = $pagina->pagina_id;

            $this->tag->setDefault("pagina_id", $pagina->getPaginaId());
            $this->tag->setDefault("pagina_nombreControlador", $pagina->getPaginaNombrecontrolador());
            $this->tag->setDefault("pagina_nombreAccion", $pagina->getPaginaNombreaccion());
            
        }
    }

    /**
     * Creates a new pagina
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "index"
            ));
        }

        $pagina = new Pagina();

        $pagina->setPaginaNombrecontrolador($this->request->getPost("pagina_nombreControlador"));
        $pagina->setPaginaNombreaccion($this->request->getPost("pagina_nombreAccion"));
        

        if (!$pagina->save()) {
            foreach ($pagina->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "new"
            ));
        }

        $this->flash->success("pagina was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "pagina",
            "action" => "index"
        ));

    }

    /**
     * Saves a pagina edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "index"
            ));
        }

        $pagina_id = $this->request->getPost("pagina_id");

        $pagina = Pagina::findFirstBypagina_id($pagina_id);
        if (!$pagina) {
            $this->flash->error("pagina does not exist " . $pagina_id);

            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "index"
            ));
        }

        $pagina->setPaginaNombrecontrolador($this->request->getPost("pagina_nombreControlador"));
        $pagina->setPaginaNombreaccion($this->request->getPost("pagina_nombreAccion"));
        

        if (!$pagina->save()) {

            foreach ($pagina->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "edit",
                "params" => array($pagina->pagina_id)
            ));
        }

        $this->flash->success("pagina was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "pagina",
            "action" => "index"
        ));

    }

    /**
     * Deletes a pagina
     *
     * @param string $pagina_id
     */
    public function deleteAction($pagina_id)
    {

        $pagina = Pagina::findFirstBypagina_id($pagina_id);
        if (!$pagina) {
            $this->flash->error("pagina was not found");

            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "index"
            ));
        }

        if (!$pagina->delete()) {

            foreach ($pagina->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "pagina",
                "action" => "search"
            ));
        }

        $this->flash->success("pagina was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "pagina",
            "action" => "index"
        ));
    }

}
