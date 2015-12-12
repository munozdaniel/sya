<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TipocargaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tipocarga
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Tipocarga", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "tipoCarga_id";

        $tipocarga = Tipocarga::find($parameters);
        if (count($tipocarga) == 0) {
            $this->flash->notice("The search did not find any tipocarga");

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tipocarga,
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
     * Edits a tipocarga
     *
     * @param string $tipoCarga_id
     */
    public function editAction($tipoCarga_id)
    {

        if (!$this->request->isPost()) {

            $tipocarga = Tipocarga::findFirstBytipoCarga_id($tipoCarga_id);
            if (!$tipocarga) {
                $this->flash->error("tipocarga was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "tipocarga",
                    "action" => "index"
                ));
            }

            $this->view->tipoCarga_id = $tipocarga->tipoCarga_id;

            $this->tag->setDefault("tipoCarga_id", $tipocarga->getTipocargaId());
            $this->tag->setDefault("tipoCarga_nombre", $tipocarga->getTipocargaNombre());
            
        }
    }

    /**
     * Creates a new tipocarga
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $tipocarga = new Tipocarga();

        $tipocarga->setTipocargaNombre($this->request->getPost("tipoCarga_nombre"));
        

        if (!$tipocarga->save()) {
            foreach ($tipocarga->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "new"
            ));
        }

        $this->flash->success("tipocarga was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipocarga",
            "action" => "index"
        ));

    }

    /**
     * Saves a tipocarga edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $tipoCarga_id = $this->request->getPost("tipoCarga_id");

        $tipocarga = Tipocarga::findFirstBytipoCarga_id($tipoCarga_id);
        if (!$tipocarga) {
            $this->flash->error("tipocarga does not exist " . $tipoCarga_id);

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        $tipocarga->setTipocargaNombre($this->request->getPost("tipoCarga_nombre"));
        

        if (!$tipocarga->save()) {

            foreach ($tipocarga->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "edit",
                "params" => array($tipocarga->tipoCarga_id)
            ));
        }

        $this->flash->success("tipocarga was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipocarga",
            "action" => "index"
        ));

    }

    /**
     * Deletes a tipocarga
     *
     * @param string $tipoCarga_id
     */
    public function deleteAction($tipoCarga_id)
    {

        $tipocarga = Tipocarga::findFirstBytipoCarga_id($tipoCarga_id);
        if (!$tipocarga) {
            $this->flash->error("tipocarga was not found");

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "index"
            ));
        }

        if (!$tipocarga->delete()) {

            foreach ($tipocarga->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tipocarga",
                "action" => "search"
            ));
        }

        $this->flash->success("tipocarga was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tipocarga",
            "action" => "index"
        ));
    }

}
