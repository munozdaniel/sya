<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TarifaController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tarifa
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Tarifa", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "tarifa_id";

        $tarifa = Tarifa::find($parameters);
        if (count($tarifa) == 0) {
            $this->flash->notice("The search did not find any tarifa");

            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tarifa,
            "limit"=> 10000,
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
     * Edits a tarifa
     *
     * @param string $tarifa_id
     */
    public function editAction($tarifa_id)
    {

        if (!$this->request->isPost()) {

            $tarifa = Tarifa::findFirstBytarifa_id($tarifa_id);
            if (!$tarifa) {
                $this->flash->error("tarifa was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "tarifa",
                    "action" => "index"
                ));
            }

            $this->view->tarifa_id = $tarifa->tarifa_id;

            $this->tag->setDefault("tarifa_id", $tarifa->getTarifaId());
            $this->tag->setDefault("tarifa_horaInicial", $tarifa->getTarifaHorainicial());
            $this->tag->setDefault("tarifa_horaFinal", $tarifa->getTarifaHorafinal());
            $this->tag->setDefault("tarifa_hsServicio", $tarifa->getTarifaHsservicio());
            $this->tag->setDefault("tarifa_hsHidro", $tarifa->getTarifaHshidro());
            $this->tag->setDefault("tarifa_hsMalacate", $tarifa->getTarifaHsmalacate());
            $this->tag->setDefault("tarifa_hsStand", $tarifa->getTarifaHsstand());
            $this->tag->setDefault("tarifa_km", $tarifa->getTarifaKm());
            
        }
    }

    /**
     * Creates a new tarifa
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "index"
            ));
        }

        $tarifa = new Tarifa();

        $tarifa->setTarifaHorainicial($this->request->getPost("tarifa_horaInicial"));
        $tarifa->setTarifaHorafinal($this->request->getPost("tarifa_horaFinal"));
        $tarifa->setTarifaHsservicio($this->request->getPost("tarifa_hsServicio"));
        $tarifa->setTarifaHshidro($this->request->getPost("tarifa_hsHidro"));
        $tarifa->setTarifaHsmalacate($this->request->getPost("tarifa_hsMalacate"));
        $tarifa->setTarifaHsstand($this->request->getPost("tarifa_hsStand"));
        $tarifa->setTarifaKm($this->request->getPost("tarifa_km"));
        

        if (!$tarifa->save()) {
            foreach ($tarifa->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "new"
            ));
        }

        $this->flash->success("tarifa was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tarifa",
            "action" => "index"
        ));

    }

    /**
     * Saves a tarifa edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "index"
            ));
        }

        $tarifa_id = $this->request->getPost("tarifa_id");

        $tarifa = Tarifa::findFirstBytarifa_id($tarifa_id);
        if (!$tarifa) {
            $this->flash->error("tarifa does not exist " . $tarifa_id);

            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "index"
            ));
        }

        $tarifa->setTarifaHorainicial($this->request->getPost("tarifa_horaInicial"));
        $tarifa->setTarifaHorafinal($this->request->getPost("tarifa_horaFinal"));
        $tarifa->setTarifaHsservicio($this->request->getPost("tarifa_hsServicio"));
        $tarifa->setTarifaHshidro($this->request->getPost("tarifa_hsHidro"));
        $tarifa->setTarifaHsmalacate($this->request->getPost("tarifa_hsMalacate"));
        $tarifa->setTarifaHsstand($this->request->getPost("tarifa_hsStand"));
        $tarifa->setTarifaKm($this->request->getPost("tarifa_km"));
        

        if (!$tarifa->save()) {

            foreach ($tarifa->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "edit",
                "params" => array($tarifa->tarifa_id)
            ));
        }

        $this->flash->success("tarifa was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tarifa",
            "action" => "index"
        ));

    }

    /**
     * Deletes a tarifa
     *
     * @param string $tarifa_id
     */
    public function deleteAction($tarifa_id)
    {

        $tarifa = Tarifa::findFirstBytarifa_id($tarifa_id);
        if (!$tarifa) {
            $this->flash->error("tarifa was not found");

            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "index"
            ));
        }

        if (!$tarifa->delete()) {

            foreach ($tarifa->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tarifa",
                "action" => "search"
            ));
        }

        $this->flash->success("tarifa was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tarifa",
            "action" => "index"
        ));
    }

}
