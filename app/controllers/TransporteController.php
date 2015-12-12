<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TransporteController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for transporte
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Transporte", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "transporte_id";

        $transporte = Transporte::find($parameters);
        if (count($transporte) == 0) {
            $this->flash->notice("The search did not find any transporte");

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $transporte,
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
     * Edits a transporte
     *
     * @param string $transporte_id
     */
    public function editAction($transporte_id)
    {

        if (!$this->request->isPost()) {

            $transporte = Transporte::findFirstBytransporte_id($transporte_id);
            if (!$transporte) {
                $this->flash->error("transporte was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "transporte",
                    "action" => "index"
                ));
            }

            $this->view->transporte_id = $transporte->transporte_id;

            $this->tag->setDefault("transporte_id", $transporte->getTransporteId());
            $this->tag->setDefault("transporte_dominio", $transporte->getTransporteDominio());
            $this->tag->setDefault("transporte_nroInterno", $transporte->getTransporteNrointerno());
            
        }
    }

    /**
     * Creates a new transporte
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $transporte = new Transporte();

        $transporte->setTransporteDominio($this->request->getPost("transporte_dominio"));
        $transporte->setTransporteNrointerno($this->request->getPost("transporte_nroInterno"));
        

        if (!$transporte->save()) {
            foreach ($transporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "new"
            ));
        }

        $this->flash->success("transporte was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "transporte",
            "action" => "index"
        ));

    }

    /**
     * Saves a transporte edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $transporte_id = $this->request->getPost("transporte_id");

        $transporte = Transporte::findFirstBytransporte_id($transporte_id);
        if (!$transporte) {
            $this->flash->error("transporte does not exist " . $transporte_id);

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $transporte->setTransporteDominio($this->request->getPost("transporte_dominio"));
        $transporte->setTransporteNrointerno($this->request->getPost("transporte_nroInterno"));
        

        if (!$transporte->save()) {

            foreach ($transporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "edit",
                "params" => array($transporte->transporte_id)
            ));
        }

        $this->flash->success("transporte was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "transporte",
            "action" => "index"
        ));

    }

    /**
     * Deletes a transporte
     *
     * @param string $transporte_id
     */
    public function deleteAction($transporte_id)
    {

        $transporte = Transporte::findFirstBytransporte_id($transporte_id);
        if (!$transporte) {
            $this->flash->error("transporte was not found");

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        if (!$transporte->delete()) {

            foreach ($transporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "search"
            ));
        }

        $this->flash->success("transporte was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "transporte",
            "action" => "index"
        ));
    }

}
