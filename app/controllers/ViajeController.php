<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ViajeController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for viaje
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Viaje", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "viaje_id";

        $viaje = Viaje::find($parameters);
        if (count($viaje) == 0) {
            $this->flash->notice("The search did not find any viaje");

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $viaje,
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
     * Edits a viaje
     *
     * @param string $viaje_id
     */
    public function editAction($viaje_id)
    {

        if (!$this->request->isPost()) {

            $viaje = Viaje::findFirstByviaje_id($viaje_id);
            if (!$viaje) {
                $this->flash->error("viaje was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "viaje",
                    "action" => "index"
                ));
            }

            $this->view->viaje_id = $viaje->viaje_id;

            $this->tag->setDefault("viaje_id", $viaje->getViajeId());
            $this->tag->setDefault("viaje_origen", $viaje->getViajeOrigen());
            $this->tag->setDefault("viaje_concatenado", $viaje->getViajeConcatenado());
            
        }
    }

    /**
     * Creates a new viaje
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $viaje = new Viaje();

        $viaje->setViajeOrigen($this->request->getPost("viaje_origen"));
        $viaje->setViajeConcatenado($this->request->getPost("viaje_concatenado"));
        

        if (!$viaje->save()) {
            foreach ($viaje->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "new"
            ));
        }

        $this->flash->success("viaje was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "viaje",
            "action" => "index"
        ));

    }

    /**
     * Saves a viaje edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $viaje_id = $this->request->getPost("viaje_id");

        $viaje = Viaje::findFirstByviaje_id($viaje_id);
        if (!$viaje) {
            $this->flash->error("viaje does not exist " . $viaje_id);

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $viaje->setViajeOrigen($this->request->getPost("viaje_origen"));
        $viaje->setViajeConcatenado($this->request->getPost("viaje_concatenado"));
        

        if (!$viaje->save()) {

            foreach ($viaje->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "edit",
                "params" => array($viaje->viaje_id)
            ));
        }

        $this->flash->success("viaje was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "viaje",
            "action" => "index"
        ));

    }

    /**
     * Deletes a viaje
     *
     * @param string $viaje_id
     */
    public function deleteAction($viaje_id)
    {

        $viaje = Viaje::findFirstByviaje_id($viaje_id);
        if (!$viaje) {
            $this->flash->error("viaje was not found");

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        if (!$viaje->delete()) {

            foreach ($viaje->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "search"
            ));
        }

        $this->flash->success("viaje was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "viaje",
            "action" => "index"
        ));
    }

}
