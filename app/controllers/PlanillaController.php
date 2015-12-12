<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PlanillaController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Planilla');
        parent::initialize();

    }
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for planilla
     */
    public function searchAction()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/dataTables.bootstrap.css');
        $this->assets->collection('footer')
            ->addJs('plugins/datatables/jquery.dataTables.min.js')
            ->addJs('plugins/datatables/dataTables.bootstrap.min.js');
        $this->assets->collection('footerInline')->addInlineJs('
        $(function () {
        $("#id_planilla").DataTable();

});')
        ;

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Planilla", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "planilla_id";

        $planilla = Planilla::find($parameters);
        if (count($planilla) == 0) {
            $this->flash->notice("The search did not find any planilla");

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $planilla,
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
     * Edits a planilla
     *
     * @param string $planilla_id
     */
    public function editAction($planilla_id)
    {

        if (!$this->request->isPost()) {
            $this->flash->error($planilla_id);
            $planilla = Planilla::findFirstByplanilla_id($planilla_id);
            $this->flash->error($planilla->planilla_nombreCliente);

            if (!$planilla) {
                $this->flash->error("La planilla no fue encontrada");

                return $this->dispatcher->forward(array(
                    "controller" => "planilla",
                    "action" => "index"
                ));
            }

            $this->view->planilla_id = $planilla->planilla_id;

            $this->tag->setDefault("planilla_id", $planilla->getPlanillaId());
            $this->tag->setDefault("planilla_nombreCliente", $planilla->getPlanillaNombrecliente());
            $this->tag->setDefault("planilla_fecha", $planilla->getPlanillaFecha());
            
        }
    }

    /**
     * Creacion de una nueva planilla. Al usuario se le solicita unicamente el nombre de la planilla.
     *
     */
    public function createAction()
    {
        $this->view->pick('planilla/new');
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        $planilla = new Planilla();

        $planilla->setPlanillaNombrecliente($this->request->getPost("planilla_nombreCliente"));
        $planilla->setPlanillaFecha(Date('Y-m-d'));//fecha de creacion de la planilla, current time
        

        if (!$planilla->save()) {
            foreach ($planilla->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "new"
            ));
        }

        $this->flash->success("La PLANILLA ha sido creada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "planilla",
            "action" => "index"
        ));

    }

    /**
     * Saves a planilla edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        $planilla_id = $this->request->getPost("planilla_id");

        $planilla = Planilla::findFirstByplanilla_id($planilla_id);
        if (!$planilla) {
            $this->flash->error("planilla does not exist " . $planilla_id);

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        $planilla->setPlanillaNombrecliente($this->request->getPost("planilla_nombreCliente"));
        $planilla->setPlanillaFecha($this->request->getPost("planilla_fecha"));
        

        if (!$planilla->save()) {

            foreach ($planilla->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "edit",
                "params" => array($planilla->planilla_id)
            ));
        }

        $this->flash->success("planilla was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "planilla",
            "action" => "index"
        ));

    }

    /**
     * Deletes a planilla
     *
     * @param string $planilla_id
     */
    public function deleteAction($planilla_id)
    {

        $planilla = Planilla::findFirstByplanilla_id($planilla_id);
        if (!$planilla) {
            $this->flash->error("planilla was not found");

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        if (!$planilla->delete()) {

            foreach ($planilla->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "search"
            ));
        }

        $this->flash->success("planilla was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "planilla",
            "action" => "index"
        ));
    }

}
