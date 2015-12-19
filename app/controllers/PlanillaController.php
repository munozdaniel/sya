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
        $miSesion = $this->session->get('auth');
        if($miSesion['rol_nombre']=='ADMIN')
            $this->view->admin = 1;
        else
            $this->view->admin = 0;
    }

    /**
     * Buscando las planillas.
     * SI el usuario tiene rol de administrador podra ver todas las planillas.
     * Sino se veran las Habilitadas unicamente
     */
    public function searchAction()
    {
        parent::importarJsSearch();

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
            $this->flash->notice("No se encontraron resultados");

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $planilla,
            "limit" => 10000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
        $miSesion = $this->session->get('auth');
        if($miSesion['rol_nombre']=='ADMIN')
            $this->view->admin = 1;
        else
            $this->view->admin = 0;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Arma el formulario con datos a partir del id que viene por POST
     *
     * @param string $planilla_id
     */
    public function editAction($planilla_id)
    {

        if (!$this->request->isPost()) {
            $planilla = Planilla::findFirstByplanilla_id($planilla_id);

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
     * Guarda los datos que se editaron.
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
            $this->flash->error("La planilla N° " . $planilla_id. " no existe");

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        $planilla->setPlanillaNombrecliente($this->request->getPost("planilla_nombreCliente"));


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

        $this->flash->success("La planilla ha sido actualizada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "planilla",
            "action" => "index"
        ));

    }

    /**
     * Eliminacion Logica
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $instancia = Planilla::findFirstByPlanilla_id($id);
            if (!$instancia) {
                $this->flash->error("La planilla no ha sido encontrada");

                return $this->dispatcher->forward(array(
                    "controller" => "planilla",
                    "action" => "index"
                ));
            }
            $instancia->planilla_habilitado = 0;
            if (!$instancia->update()) {

                foreach ($instancia->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "planilla",
                    "action" => "search"
                ));
            }

            $this->flash->success("La planilla ha sido eliminada correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "search"
            ));
        }
    }
    /**
     * Habilitacion logica.
     * @param $id
     * @return bool
     */
    public function habilitarAction($id)
    {
        $planilla = Planilla::findFirstByPlanilla_id($id);

        if (!$planilla) {
            $this->flash->error("La planilla no ha sido encontrada");

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }
        $planilla->planilla_habilitado = 1;
        if (!$planilla->update()) {

            foreach ($planilla->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "search"
            ));
        }

        $this->flash->success("La planilla ha sido habilitada");

        return $this->dispatcher->forward(array(
            "controller" => "planilla",
            "action" => "search"
        ));
    }
    /**
     * NO SE USA!
     * Eliminar una planilla de manera LOGICA.
     * Al Eliminar una planilla se eliminan todas las ordenes relacionadas (Eliminacion Logica).
     *
     * @param string $planilla_id
     * @return null
     */
    public function deleteAction($planilla_id)
    {

        $planilla = Planilla::findFirstByplanilla_id($planilla_id);
        if (!$planilla) {
            $this->flash->error("La planilla no ha sido encontrada");

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }
        try{
            $this->db->begin();
            $eliminados = Orden::eliminarByPlanilla_id($planilla_id);
            if(!$eliminados){
                $this->flash->error("Hubo un problema al eliminar las ordenes relacionadas a la planilla N° $planilla_id");
                $this->db->rollback();
                return $this->dispatcher->forward(array(
                    "controller" => "planilla",
                    "action" => "index"
                ));
            }
            $planilla->planilla_habilitado =0 ;
            if (!$planilla->update()) {

                foreach ($planilla->getMessages() as $message) {
                    $this->flash->error($message);
                }
                $this->db->rollback();
                return $this->dispatcher->forward(array(
                    "controller" => "planilla",
                    "action" => "search"
                ));
            }
            $this->db->commit();
            $this->flash->success("La planilla ha sido eliminada correctamente");
        }
        catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
            $this->flash->error('Transaccion Fallida: ', $e->getMessage());
        }

        return $this->dispatcher->forward(array(
            "controller" => "planilla",
            "action" => "index"
        ));
    }

}
