<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class YacimientoController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for yacimiento
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Yacimiento", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "yacimiento_id";

        $yacimiento = Yacimiento::find($parameters);
        if (count($yacimiento) == 0) {
            $this->flash->notice("The search did not find any yacimiento");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $yacimiento,
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
     * Edits a yacimiento
     *
     * @param string $yacimiento_id
     */
    public function editAction($yacimiento_id)
    {

        if (!$this->request->isPost()) {

            $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
            if (!$yacimiento) {
                $this->flash->error("yacimiento was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "yacimiento",
                    "action" => "index"
                ));
            }

            $this->view->yacimiento_id = $yacimiento->yacimiento_id;

            $this->tag->setDefault("yacimiento_id", $yacimiento->getYacimientoId());
            $this->tag->setDefault("yacimiento_destino", $yacimiento->getYacimientoDestino());
            $this->tag->setDefault("yacimiento_equipoPozo", $yacimiento->getYacimientoEquipopozo());
            $this->tag->setDefault("yacimiento_habilitado", $yacimiento->getYacimientoHabilitado());
            
        }
    }

    /**
     * Creates a new yacimiento
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento = new Yacimiento();

        $yacimiento->setYacimientoDestino($this->request->getPost("yacimiento_destino"));
        $yacimiento->setYacimientoEquipopozo($this->request->getPost("yacimiento_equipoPozo"));
        $yacimiento->setYacimientoHabilitado($this->request->getPost("yacimiento_habilitado"));
        

        if (!$yacimiento->save()) {
            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "new"
            ));
        }

        $this->flash->success("yacimiento was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));

    }

    /**
     * Saves a yacimiento edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento_id = $this->request->getPost("yacimiento_id");

        $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
        if (!$yacimiento) {
            $this->flash->error("yacimiento does not exist " . $yacimiento_id);

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento->setYacimientoDestino($this->request->getPost("yacimiento_destino"));
        $yacimiento->setYacimientoEquipopozo($this->request->getPost("yacimiento_equipoPozo"));
        $yacimiento->setYacimientoHabilitado($this->request->getPost("yacimiento_habilitado"));
        

        if (!$yacimiento->save()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "edit",
                "params" => array($yacimiento->yacimiento_id)
            ));
        }

        $this->flash->success("yacimiento was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));

    }

    /**
     * Deletes a yacimiento
     *
     * @param string $yacimiento_id
     */
    public function deleteAction($yacimiento_id)
    {

        $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
        if (!$yacimiento) {
            $this->flash->error("yacimiento was not found");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        if (!$yacimiento->delete()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "search"
            ));
        }

        $this->flash->success("yacimiento was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));
    }

}
