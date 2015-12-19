<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class LineaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for linea
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Linea", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "linea_id";

        $linea = Linea::find($parameters);
        if (count($linea) == 0) {
            $this->flash->notice("The search did not find any linea");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $linea,
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
     * Edits a linea
     *
     * @param string $linea_id
     */
    public function editAction($linea_id)
    {

        if (!$this->request->isPost()) {

            $linea = Linea::findFirstBylinea_id($linea_id);
            if (!$linea) {
                $this->flash->error("linea was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "linea",
                    "action" => "index"
                ));
            }

            $this->view->linea_id = $linea->linea_id;

            $this->tag->setDefault("linea_id", $linea->getLineaId());
            $this->tag->setDefault("linea_nombre", $linea->getLineaNombre());
            $this->tag->setDefault("linea_centroCosto", $linea->getLineaCentrocosto());
            $this->tag->setDefault("linea_habilitado", $linea->getLineaHabilitado());
            
        }
    }

    /**
     * Creates a new linea
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea = new Linea();

        $linea->setLineaNombre($this->request->getPost("linea_nombre"));
        $linea->setLineaCentrocosto($this->request->getPost("linea_centroCosto"));
        $linea->setLineaHabilitado($this->request->getPost("linea_habilitado"));
        

        if (!$linea->save()) {
            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "new"
            ));
        }

        $this->flash->success("linea was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));

    }

    /**
     * Saves a linea edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea_id = $this->request->getPost("linea_id");

        $linea = Linea::findFirstBylinea_id($linea_id);
        if (!$linea) {
            $this->flash->error("linea does not exist " . $linea_id);

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea->setLineaNombre($this->request->getPost("linea_nombre"));
        $linea->setLineaCentrocosto($this->request->getPost("linea_centroCosto"));
        $linea->setLineaHabilitado($this->request->getPost("linea_habilitado"));
        

        if (!$linea->save()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "edit",
                "params" => array($linea->linea_id)
            ));
        }

        $this->flash->success("linea was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));

    }

    /**
     * Deletes a linea
     *
     * @param string $linea_id
     */
    public function deleteAction($linea_id)
    {

        $linea = Linea::findFirstBylinea_id($linea_id);
        if (!$linea) {
            $this->flash->error("linea was not found");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        if (!$linea->delete()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "search"
            ));
        }

        $this->flash->success("linea was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));
    }

}
