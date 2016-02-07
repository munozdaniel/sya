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
        parent::importarJsTable();

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
        $this->assets->collection('headerJs')
            ->addJs('plugins/jQueryUI/jquery-ui.min.js');
        $this->assets->collection('headerCss')
            ->addCss('plugins/jQueryUI/jquery-ui.css');

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
     * Permite guardar una nueva planilla utilizando ajax. Devuelve un json con los mensajes, y con el id de la planilla creada.
     */
    public function crearAction()
    {
        $this->view->disable();
        $errors         = array();      // array to hold validation errors
        $data           = array();      // array to pass back data
        if (empty($_POST['planilla_nombreCliente']))
            $errors['planilla_nombreCliente'] = 'El Nombre de la Planilla es requerido';
        if ( ! empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        }else {
            $planilla = new Planilla();
            $planilla->setPlanillaNombrecliente(strtoupper($this->request->getPost("planilla_nombreCliente",'string')));
            $planilla->setPlanillaFecha(Date('Y-m-d'));//fecha de creacion de la planilla, current time
            $planilla->setPlanillaArmada(0);
            $planilla->setPlanillaHabilitado(1);

            if (!$planilla->save())
            {
                foreach ($planilla->getMessages() as $message) {
                    $errors[]=$message." <br>";
                }
                $data['success'] = false;
                $data['errors']  = $errors;
            }else{
                $data['success'] = true;
                $data['message'] = 'Operación exitosa';
                $data['planilla_id'] = $planilla->getPlanillaId();
            }
        }// return all our data to an AJAX call
        echo json_encode($data);
    }

    /**
     * Permite editar el nombre de la planilla a traves de json. Recibe el nombre de la planilla y el ID
     */
    public function editarAction()
    {
        $this->view->disable();
        $errors         = array();      // array to hold validation errors
        $data           = array();      // array to pass back data
        if (empty($_POST['planilla_nombreCliente']))
            $errors['planilla_nombreCliente'] = 'El Nombre de la Planilla es requerido';
        if ( ! empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        }else {
            $planilla = Planilla::findFirst($this->request->getPost('planilla_id'));
            $planilla->setPlanillaNombrecliente(strtoupper($this->request->getPost("planilla_nombreCliente",'string')));

            if (!$planilla->update())
            {
                foreach ($planilla->getMessages() as $message) {
                    $errors[]=$message." <br>";
                }
                $data['success'] = false;
                $data['errors']  = $errors;
            }else{
                $data['success'] = true;
                $data['message'] = 'Operación exitosa';
            }
        }// return all our data to an AJAX call
        echo json_encode($data);
    }
    /**
     * Creacion de una nueva planilla. Al usuario se le solicita unicamente el nombre de la planilla.
     *
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "index"
            ));
        }

        $planilla = new Planilla();

        $planilla->setPlanillaNombrecliente(strtoupper($this->request->getPost("planilla_nombreCliente")));
        $planilla->setPlanillaFecha(Date('Y-m-d'));//fecha de creacion de la planilla, current time
        $planilla->setPlanillaArmada(0);
        $planilla->setPlanillaHabilitado(1);

        if (!$planilla->save()) {
            foreach ($planilla->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "planilla",
                "action" => "new"
            ));
        }

        $this->flashSession->success("La Planilla ha sido creada correctamente, por favor agregue las <strong> columnas extras</strong>");
        $this->view->planilla = $planilla;
         $this->response->redirect('planilla/columnas');
        $this->view->disable();
    }

    /**
     * Permite crear las columnas extras que contendrá la planilla, que dependerán del cliente.
     */
    public function columnasAction()
    {

    }

    /**
     * Guarda instancias de columnas extras
     */
    public function createColumnasAction()
    {
        $columnas = $this->request->getPost('columna');
        foreach( $columnas AS $columna) {
            $this->flash->success($columna);
        }
        $this->view->pick('planilla/columnas');
    }
    public function ordenarAction()
    {
        $this->view->disable();
        echo "entra";
        foreach ($_GET['listItem'] as $position => $item)
        {
            echo "Posicion: ".$position." - Item: ".$item ."<br>";
        }
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

        $planilla->setPlanillaNombrecliente(strtoupper($this->request->getPost("planilla_nombreCliente")));


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
