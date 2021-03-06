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
        if ($miSesion['rol_nombre'] == 'ADMIN')
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
        $parameters["order"] = "planilla_id DESC";

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
        if ($miSesion['rol_nombre'] == 'ADMIN')
            $this->view->admin = 1;
        else
            $this->view->admin = 0;
    }

    /**
     * Muestra un formulario para crear una planilla.
     */
    public function newAction()
    {
        $this->importarSelect2();
        $this->assets->collection('headerJs')
            ->addJs('plugins/jQueryUI/jquery-ui.min.js');
        $this->assets->collection('headerCss')
            ->addCss('plugins/jQueryUI/jquery-ui.css')
            ->addCss('dist/css/planilla.css');
        $this->view->fechaActual = date('m/Y');
        $elemento = new DataListElement('cliente_nombre',
            array(
                array('placeholder' => 'SELECCIONAR CLIENTE', 'required' => '', 'class' => 'form-control', 'maxlength' => 60),
                Cliente::find(array('cliente_habilitado=1', 'order' => 'cliente_nombre')),
                array('cliente_id', 'cliente_nombre'),
                'cliente_id'
            ));
        $elemento->setLabel('Nombre del Cliente');

        $this->view->selectCliente = $elemento;
    }

    /**
     * PASO 1_
     * Permite guardar una nueva planilla utilizando ajax. [PLANILLA TIPO CLIENTE FECHA]
     * Devuelve un json con los mensajes, y con el id de la planilla creada.
     * Carga el combobox con las cabeceras predefinidas
     */
    public function crearAction()
    {
        $this->view->disable();
        $errors = array();      // array to hold validation errors
        $data = array();      // array to pass back data
        if (empty($_POST['fechaActual']))
            $errors['fechaActual'] = 'La fecha actual es requerida';
        if (empty($_POST['tipo_planilla']))
            $errors['tipo_planilla'] = 'El tipo de planilla es requerido';
        if (empty($_POST['cliente_nombre']))
            $errors['cliente_nombre'] = 'El nombre del cliente es requerido';
        if (!empty($errors)) {
            $data['success'] = false;
            $data['mensaje'] = $errors;
        } else {
            $this->db->begin();
            $planilla = new Planilla();
            date_default_timezone_set('America/Argentina/Mendoza');
            $tipo = $this->request->getPost('tipo_planilla')[0];
            $planilla->setPlanillaTipo($tipo);
            if($tipo==0)
                $tipoPlanilla = "REGISTRO";
            else{
                if($tipo==1)
                    $tipoPlanilla="1ERA QUINCENA ON CALL";
                else
                    $tipoPlanilla="2DA QUINCENA ON CALL";
            }
            $planilla->setPlanillaNombrecliente("PLANILLA " . $tipoPlanilla . " " . strtoupper($this->request->getPost("cliente_nombre", 'string')) . " " . $this->request->getPost('fechaActual'));
            $planilla->setPlanillaFecha(Date('Y-m-d'));//fecha de creacion de la planilla, current time
            $planilla->setPlanillaArmada(0);
            $planilla->setPlanillaHabilitado(1);
            $planilla->setPlanillaFinalizada(0);
            $planilla->setPlanillaClienteId($this->request->getPost('cliente_id','int'));

            if (!$planilla->save()) {
                foreach ($planilla->getMessages() as $message) {
                    $errors[] = $message . " <br>";
                }
                $data['success'] = false;
                $data['mensaje'] = $errors;
                $this->db->rollback();
            } else {
                $data['planilla_id'] = $planilla->getPlanillaId();
                $data['success'] = true;
                $this->db->commit();
            }
        }// return all our data to an AJAX call
        echo json_encode($data);
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
     * Permite editar el nombre de la planilla a traves de json. Recibe el nombre de la planilla y el ID
     */
    public function editarAction()
    {
        $this->view->disable();
        $errors = array();      // array to hold validation errors
        $data = array();      // array to pass back data
        if (empty($_POST['planilla_nombreCliente']))
            $errors['planilla_nombreCliente'] = 'El Nombre de la Planilla es requerido';
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {
            $planilla = Planilla::findFirst($this->request->getPost('planilla_id'));
            $planilla->setPlanillaNombrecliente(strtoupper($this->request->getPost("planilla_nombreCliente", 'string')));

            if (!$planilla->update()) {
                foreach ($planilla->getMessages() as $message) {
                    $errors[] = $message . " <br>";
                }
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {
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
     * HAY QUE FINALIZARLO. DEBERIA IR En COLUMNASCONTroLLER
     */
    public function ordenarAction()
    {
        $this->view->disable();
        foreach ($_GET['listItem'] as $position => $item) {
            //echo "Posicion: ".$position." - Item: ".$item ."<br>";
            $columna = Columna::findFirstByColumna_id($item);
            if ($columna) {
                $columna->setColumnaPosicion($position);
                if (!$columna->update()) {
                    echo "Hubo un problema al cargar el nuevo orden.";
                    return;
                }
            } else
                echo "NO SE HA ENCONTRADO LA COLUMNA <br>";
        }
        echo "Reordenamiento exitoso!";
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
            $this->flash->error("La planilla N° " . $planilla_id . " no existe");

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
     * Permite ver un menu personalizado para cada planilla.
     */
    public function viewAction($planilla_id){
        //Para el modal de eliminacion
        $this->assets->collection('footerInline')
            ->addInlineJs('
            $(document).on("click", ".enviar-dato", function () {
                var id = $(this).data("id");
                $("#cuerpo #id").val( id );
            });
        ');

        $planilla = Planilla::findFirst(array('planilla_id=:planilla:','bind'=>array('planilla'=>$planilla_id)));
        if(!$planilla){
            $this->flash->error("NO EXISTE LA PLANILLA QUE ESTÁ INTENTANDO ACCEDER");
            return $this->redireccionar('planilla/search');
        }
        if($planilla->getCabecera()!=null) {
            $columnas = Columna::find(array('columna_cabeceraId=:cabecera: AND columna_habilitado=1',
                'bind' => array('cabecera' => $planilla->getCabecera()->getCabeceraId())));
            if ($columnas)
                $this->view->columnas = $columnas;
        }
        //$cliente = Cliente::findFirst(array('cliente_nombre LIKE :nombre:','bind'=>array('nombre'=>$pla)))
        $this->view->planilla = $planilla;

    }

}
