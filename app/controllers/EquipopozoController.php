<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class EquipopozoController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for equipopozo
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Equipopozo", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "equipoPozo_id";

        $equipopozo = Equipopozo::find($parameters);
        if (count($equipopozo) == 0) {
            $this->flash->notice("The search did not find any equipopozo");

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $equipopozo,
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
     * Edits a equipopozo
     *
     * @param string $equipoPozo_id
     */
    public function editAction($equipoPozo_id)
    {

        if (!$this->request->isPost()) {

            $equipopozo = Equipopozo::findFirstByequipoPozo_id($equipoPozo_id);
            if (!$equipopozo) {
                $this->flash->error("equipopozo was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "equipopozo",
                    "action" => "index"
                ));
            }

            $this->view->equipoPozo_id = $equipopozo->equipoPozo_id;

            $this->tag->setDefault("equipoPozo_id", $equipopozo->getEquipopozoId());
            $this->tag->setDefault("equipoPozo_nombre", $equipopozo->getEquipopozoNombre());
            
        }
    }

    /**
     * Creates a new equipopozo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $equipopozo = new Equipopozo();

        $equipopozo->setEquipopozoNombre($this->request->getPost("equipoPozo_nombre"));
        

        if (!$equipopozo->save()) {
            foreach ($equipopozo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "new"
            ));
        }

        $this->flash->success("equipopozo was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "equipopozo",
            "action" => "index"
        ));

    }

    /**
     * Saves a equipopozo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $equipoPozo_id = $this->request->getPost("equipoPozo_id");

        $equipopozo = Equipopozo::findFirstByequipoPozo_id($equipoPozo_id);
        if (!$equipopozo) {
            $this->flash->error("equipopozo does not exist " . $equipoPozo_id);

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $equipopozo->setEquipopozoNombre($this->request->getPost("equipoPozo_nombre"));
        

        if (!$equipopozo->save()) {

            foreach ($equipopozo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "edit",
                "params" => array($equipopozo->equipoPozo_id)
            ));
        }

        $this->flash->success("equipopozo was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "equipopozo",
            "action" => "index"
        ));

    }

    /**
     * Deletes a equipopozo
     *
     * @param string $equipoPozo_id
     */
    public function deleteAction($equipoPozo_id)
    {

        $equipopozo = Equipopozo::findFirstByequipoPozo_id($equipoPozo_id);
        if (!$equipopozo) {
            $this->flash->error("equipopozo was not found");

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        if (!$equipopozo->delete()) {

            foreach ($equipopozo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "search"
            ));
        }

        $this->flash->success("equipopozo was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "equipopozo",
            "action" => "index"
        ));
    }

}
