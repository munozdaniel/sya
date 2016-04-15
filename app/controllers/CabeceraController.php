<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CabeceraController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Cabecera');
        $miSesion = $this->session->get('auth');
        if ($miSesion['rol_nombre'] == 'ADMIN')
            $this->view->admin = 1;
        else
            $this->view->admin = 0;
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
     * Searches for cabecera
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Cabecera", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "cabecera_id";

        $cabecera = Cabecera::find($parameters);
        if (count($cabecera) == 0) {
            $this->flash->notice("The search did not find any cabecera");

            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $cabecera,
            "limit" => 10,
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
     * Edits a cabecera
     *
     * @param string $cabecera_id
     */
    public function editAction($cabecera_id)
    {

        if (!$this->request->isPost()) {

            $cabecera = Cabecera::findFirstBycabecera_id($cabecera_id);
            if (!$cabecera) {
                $this->flash->error("cabecera was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "cabecera",
                    "action" => "index"
                ));
            }

            $this->view->cabecera_id = $cabecera->cabecera_id;

            $this->tag->setDefault("cabecera_id", $cabecera->getCabeceraId());
            $this->tag->setDefault("cabecera_nombre", $cabecera->getCabeceraNombre());
            $this->tag->setDefault("cabecera_habilitado", $cabecera->getCabeceraHabilitado());
            $this->tag->setDefault("cabecera_fecha", $cabecera->getCabeceraFecha());

        }
    }

    /**
     * Guarda todas las columnas extras que se agregaron en la interfaz.
     * Si la cabecera ya existe, agrega mas columnas extras.
     * Si la cabecera no existe, la crea y agrega sus columnas
     */
    public function agregarExtraAction()
    {
        $this->view->disable();
        $error = array();      // array to hold validation errors
        $data = array();
        $data['success'] = false;
        $data['mensaje'] = "Ups, ha ocurrido un problema.";
        if ($this->request->isPost()) {
            $this->db->begin();

            //si existe el token del formulario y es correcto(evita csrf)
            //if ($this->security->checkToken('token',$this->request->getPost('token'))) {
            if (!$this->request->hasPost('columna')) {
                $error[] = "No puede guardar columnas vacias.";
            } else {
                //$cabeceraId = Cabecera::guardar($this->request->getPost('planilla_nombreCliente'));
                $cabecera_id = $this->request->getPost('cabecera_id', 'int');
                $cabecera = Cabecera::findFirstByCabecera_id($cabecera_id);
                if (!$cabecera) {
                    $error[] = "Hubo un problema, no se encontro la cabecera.";
                } else {
                    $arregloColumnas = $this->request->getPost('columna');
                    $posicion = 26;
                    foreach ($arregloColumnas AS $columna) {
                        if (!empty($columna)) {
                            $nuevaColumna = new Columna();
                            $nuevaColumna->setColumnaNombre(strtoupper($columna));
                            $nuevaColumna->setColumnaClave('CLAVE_' . strtoupper($columna));
                            $nuevaColumna->setColumnaExtra(1);
                            $nuevaColumna->setColumnaPosicion($posicion++);
                            $nuevaColumna->setColumnaCabeceraId($cabecera->getCabeceraId());
                            $nuevaColumna->setColumnaHabilitado(1);
                            if (!$nuevaColumna->save()) {
                                foreach ($nuevaColumna->getMessages() as $message) {
                                    $error[] = $message . " <br>";
                                }
                            }
                        } else {
                            $error[] = "Debe ingresar el nombre de la columna";
                        }
                    }
                }
            }
            if (empty($error)) {
                $this->db->commit();
                $todasLasColumnas = $this->modelsManager->createBuilder()
                    ->columns('columna_id, columna_nombre')
                    ->from('Columna')
                    ->where('columna_cabeceraId = :cabecera_id:', array('cabecera_id' => $cabecera->getCabeceraId()))
                    ->orderBy('columna_posicion ASC')
                    ->getQuery()
                    ->execute()
                    ->toArray();
                $data['columnas'] = $todasLasColumnas;
                $data['success'] = true;
                $data['mensaje'] = "Operacion Exitosa, las columnas han sido guardadas correctamente";
            } else {
                $this->db->rollback();
                $data['success'] = false;
                $data['mensaje'] = $error;
            }
        }
        echo json_encode($data);
    }


    /**
     * COn el nombre del cliente obtenido del comboBox, recupero todos las planillas con un LIKE %%
     * A partir de todas las planillas obtengo todos las cabeceras_id
     * Busco todas las cabeceras que contengan el nombre del cliente (LIKE % nombreCliente%)
     */
    public function todasLasCabecerasAction()
    {
        $this->view->disable();
        $data = array();
        $data['success'] = false;

        if ($this->request->isPost()) {
            $cabeceras = Cabecera::find(array('cabecera_habilitado=1 AND cabecera_nombre LIKE :cliente_nombre:',
                'bind' => array('cliente_nombre' => "%" . $this->request->getPost('cliente_nombre', 'string') . "%")));
            if (!$cabeceras) {
                $data['mensaje'] = array("No se encontraron cabeceras cargadas en el sistema para el cliente:  " . $this->request->getPost('cliente_nombre'));
            } else {
                $lista = array();
                foreach ($cabeceras as $cabecera) {
                    $item = array();
                    $item['cabecera_id'] = $cabecera->getCabeceraId();
                    $item['nombreCliente'] = $cabecera->getCabeceraNombre();
                    $lista[] = $item;
                }
                $data['success'] = true;
                $data['cabeceras'] = $lista;
            }
            echo json_encode($data);
        } else {
            $data['mensaje'] = array("PROBLEMAS CON LA URL");
            echo json_encode($data);
        }
    }

    /**
     * Guarda la cabecera que se elige en un combobox.
     */
    public function guardarCabeceraPredefinidaAction()
    {
        $this->view->disable();
        $data = array();
        $retorno = "";
        if (!$this->request->isPost()) {
            $data['success'] = false;
            $data['mensaje'] = "Ocurrio un problema, la URL solicitada no existe.";
            return json_encode($data);
        }
        $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('planilla_id', 'int'));
        if (!$planilla) {
            $data['success'] = false;
            $data['mensaje'] = "Ocurrio un problema, la planilla no se encontró.";
            return json_encode($data);
        }
        $planilla->setPlanillaCabeceraid($this->request->getPost('cabecera_id', 'int'));
        $planilla->setPlanillaArmada(1);
        if (!$planilla->update()) {
            $data['success'] = false;
            foreach ($planilla->getMessages() as $mje) {
                $retorno .= $mje . "<br>";
            }
            $data['mensaje'] = $retorno;
            return json_encode($data);
        }
        $data['success'] = true;
        $data['mensaje'] = '<div class="help-block">' .
            '<h4> Operación Exitosa, la planilla se encuentra configurada correctamente.</h4>' .
            ' <br>' .
            ' <ul class="list-unstyled ">Si desea personalizar la cabecera puede: ' .
            '<li>' . $this->tag->linkTo('cabecera/reordenar', 'Reordenar las Columnas') . '</li>' .
            '<li>' . $this->tag->linkTo('cabecera/extra', 'Agregar Columnas Extras') . '</li>' .
            '<li>' . $this->tag->linkTo('cabecera/extra', 'Habilitar/Eliminar Columnas') . '</li>' .
            '</ul>' .
            '<small>* Es necesario tener permisos de administrador.</small></div>';
        echo json_encode($data);
    }

    /**
     * Crea una cabecera con las columnas basicas
     * @param $planilla
     * @return array
     */
    public function crearColumnasBasicasAction()
    {
        $this->view->disable();
        if ($this->request->isPost()) {
            $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('planilla_id', 'int'));
            if (!empty($planilla) && $planilla != null)
                $data = $this->columnasBasicas($planilla);
            else {
                $data['success'] = false;
                $data['mensaje'] = "La planilla no se encuentra disponible.";
            }
            echo json_encode($data);
        } else {
            echo json_encode(array('success' => false, 'mensaje' => 'NO ES POST'));
        }
    }

    private function columnasBasicas($planilla)
    {
        $data = array();
        $data['success'] = true;
        $retorno = array();


        $cabecera = new Cabecera();
        $cabecera->setCabeceraFecha(date('Y-m-d'));
        $cabecera->setCabeceraHabilitado(1);
        $cabecera->setCabeceraNombre($planilla->getCliente()->getClienteNombre() . ' ' . $planilla->getPlanillaFecha());
        if (!$cabecera->save()) {
            foreach ($cabecera->getMessages() as $mensaje) {
                $retorno[] = $mensaje;
            }
            $data['success'] = false;
        } /*====== Crear columnas =======*/
        else {
            /*Creo manualmente las columnas*/
            $data = Columna::guardarColumnasBasica($cabecera->getCabeceraId());
            $data['cabecera_id'] = $cabecera->getCabeceraId();
            /*====== Actualizar Planilla =======*/
            if ($data['success']) {
                $planilla->setPlanillaCabeceraId($cabecera->getCabeceraId());
                $planilla->setPlanillaArmada(1);
                if (!$planilla->update()) {
                    foreach ($planilla->getMessages() as $mensaje) {
                        $retorno[] = $mensaje;
                    }
                    $data['success'] = false;
                }
            }
        }
        if ($data['success'])
            $data['mensaje'] = "OPERACION EXITOSA";
        else
            $data['mensaje'] = $retorno;
        return $data;
    }

    /**
     * Creates a new cabecera
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "index"
            ));
        }

        $cabecera = new Cabecera();

        $cabecera->setCabeceraNombre($this->request->getPost("cabecera_nombre"));
        $cabecera->setCabeceraHabilitado($this->request->getPost("cabecera_habilitado"));
        $cabecera->setCabeceraFecha($this->request->getPost("cabecera_fecha"));


        if (!$cabecera->save()) {
            foreach ($cabecera->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "new"
            ));
        }

        $this->flash->success("cabecera was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "cabecera",
            "action" => "index"
        ));

    }

    /**
     * Saves a cabecera edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "index"
            ));
        }

        $cabecera_id = $this->request->getPost("cabecera_id");

        $cabecera = Cabecera::findFirstBycabecera_id($cabecera_id);
        if (!$cabecera) {
            $this->flash->error("cabecera does not exist " . $cabecera_id);

            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "index"
            ));
        }

        $cabecera->setCabeceraNombre($this->request->getPost("cabecera_nombre"));
        $cabecera->setCabeceraHabilitado($this->request->getPost("cabecera_habilitado"));
        $cabecera->setCabeceraFecha($this->request->getPost("cabecera_fecha"));


        if (!$cabecera->save()) {

            foreach ($cabecera->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "edit",
                "params" => array($cabecera->cabecera_id)
            ));
        }

        $this->flash->success("cabecera was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "cabecera",
            "action" => "index"
        ));

    }

    /**
     * Deletes a cabecera
     *
     * @param string $cabecera_id
     */
    public function deleteAction($cabecera_id)
    {

        $cabecera = Cabecera::findFirstBycabecera_id($cabecera_id);
        if (!$cabecera) {
            $this->flash->error("cabecera was not found");

            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "index"
            ));
        }

        if (!$cabecera->delete()) {

            foreach ($cabecera->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "cabecera",
                "action" => "search"
            ));
        }

        $this->flash->success("cabecera was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "cabecera",
            "action" => "index"
        ));
    }
    /*==========================================================================================*/
    /*========================== REODENAR LAS COLUMNAS DE UNA CABECERA==========================*/
    /*==========================================================================================*/
    /**
     * Permite seleccionar una planilla desde un datalist.
     *
     */

    public function reordenarAction()
    {

        $this->importarSelect2();
        //Assets para reordenar columnas.
        $this->assets->collection('headerJs')
            ->addJs('plugins/jQueryUI/jquery-ui.min.js');
        $this->assets->collection('headerCss')
            ->addCss('plugins/jQueryUI/jquery-ui.css')
            ->addCss('dist/css/planilla.css');
        $this->view->formulario = new \Phalcon\Forms\Element\Select('cabecera_id',
            Cabecera::find(array('cabecera_habilitado=1', 'order' => 'cabecera_id DESC')),
            array(
                'using' => array('cabecera_id', 'cabecera_nombre'),
                'useEmpty' => false,
                'emptyText' => 'SELECCIONAR LA CABECERA',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'required' => ''
            ));
    }

    /**
     * obtiene todas las columnas perteneciente a la planilla seleccionada.
     * Busca la planilla, obtiene la cabecera y recupera todas las columnas por cabecera.
     * [[ AJAX ]]
     */
    public function buscarColumnasPorCabeceraIdAction()
    {
        $this->view->disable();
        $data = array();
        $mensajes = array();
        if (!$this->request->isPost()) {
            $data['success'] = false;
            $mensajes[] = "La URL solicitada no se encuentra disponible.";
        } else {
            if ($this->request->getPost('cabecera_id', 'int') == null) {
                $data['success'] = false;
                $mensajes[] = "Por favor seleccione una Cabecera.";
            } else {
                $cabecera = Cabecera::findFirst(array('cabecera_id = :cabecera_id: AND cabecera_habilitado=1',
                    'bind' => array('cabecera_id' => $this->request->getPost('cabecera_id', 'int'))));
                if (!$cabecera) {
                    $data['success'] = false;
                    foreach ($cabecera->getMessages() as $mje) {
                        $mensajes[] = $mje . " <br>";
                    }
                } else {
                    $columnas = Columna::find(array('columna_cabeceraId = :cabecera_id: AND columna_habilitado=1',
                        'bind' => array('cabecera_id' => $cabecera->getCabeceraId()), 'order' => 'columna_posicion ASC'));
                    if ($columnas) {
                        $retorno = array();
                        foreach ($columnas as $col) {
                            $item = array();
                            $item['columna_id'] = $col->getColumnaId();
                            $item['columna_nombre'] = $col->getColumnaNombre();
                            $retorno[] = $item;
                        }
                        if (count($retorno) == 0) {
                            $data['success'] = false;
                            $mensajes[] = 'La planilla seleccionada no contiene una cabecera con columnas para reordenar.';
                        } else {

                            $data['success'] = true;
                            $mensajes[] = 'Operación Exitosa';
                            $data['columnas'] = $retorno;
                        }
                    } else {
                        $data['success'] = false;
                        $mensajes[] = 'No se encontraron columnas referidas a la planilla seleccionada.';
                    }
                }
            }
        }
        $data['mensaje'] = $mensajes;
        echo json_encode($data);
    }

    /**
     * Segun las columnas reordenadas se iran actualizando las posiciones.
     */
    public function ordenarAction()
    {
        $this->view->disable();
        if ($_GET['listItem'] != null) {
            foreach ($_GET['listItem'] as $position => $item) {
                //echo "Posicion: ".$position." - Item: ".$item ."<br>";
                $columna = Columna::findFirstByColumna_id($item);
                if ($columna) {
                    $columna->setColumnaPosicion($position);
                    if (!$columna->update()) {
                        echo "HUBO UN PROBLEMA AL ACTUALIZAR LAS NUEVAS POSICIONES.";
                        return;
                    }
                } else
                    echo "NO SE HA ENCONTRADO LA COLUMNA <br>";
            }
            echo "OPERACIÓN EXITOSA, LAS COLUMNAS SE HAN REORDENADO.";
        } else {
            echo "DEBE SELECCIONAR UNA PLANILLA CON COLUMNAS";
        }
    }
    /**********************************************************************************/
    /**
     * Remueve la cabecera a una planilla
     */
    public function quitarAction($planilla_id)
    {
        $this->importarSelect2();
        $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_habilitado=1',
            'bind' => array('planilla_id' => $planilla_id)));
        if (!$planilla) {
            $this->flash->error("Ocurrio un Problema: La Planilla no se encontró, o no se encuentra habilitada.");
            return $this->redireccionar('planilla/search');
        }
        if ($planilla->getPlanillaCabeceraId() != null) {
            $planilla->setPlanillaCabeceraId(null);
            $planilla->setPlanillaArmada(0);
            if ($planilla->update()) {
                foreach ($planilla->getMessages() as $mensaje) {
                    $this->flash->error($mensaje);
                }
                return $this->redireccionar('planilla/view/' . $planilla->getPlanillaId());
            }
            $this->flash->warning("Se ha eliminado la cabecera de la planilla");
            return $this->redireccionar('planilla/view/' . $planilla->getPlanillaId());
        }
    }

    /**
     * Metodo llamado desde la administracion de la planilla
     */
    public function asignarCabeceraAction($planilla_id)
    {
        $this->importarSelect2();
        $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_habilitado=1',
            'bind' => array('planilla_id' => $planilla_id)));
        if (!$planilla) {
            $this->flash->error("Ocurrio un Problema: La Planilla no se encontró, o no se encuentra habilitada.");
            return $this->redireccionar('planilla/search');
        }
        if ($planilla->getPlanillaCabeceraId() != null) {
            $this->flash->warning("La Planilla ya tiene asignada una cabecera");
            return $this->redireccionar('planilla/view/' . $planilla->getPlanillaId());
        }
        $this->view->planilla = $planilla;
    }

    /**
     * Metodo llamado desde la administracion de la planilla. Genera una nueva cabecera con columnas basicas
     */
    public function nuevaCabeceraAction($planilla_id)
    {
        $planilla = Planilla::findFirst(array('planilla_id=:planilla_id: AND planilla_habilitado=1',
            'bind' => array('planilla_id' => $planilla_id)));
        if (!$planilla) {
            $this->flash->error("Ocurrio un Problema: La Planilla no se encontró, o no se encuentra habilitada.");
            return $this->redireccionar('planilla/search');
        }
        if ($planilla->getPlanillaCabeceraId() != null) {
            $this->flash->warning("La Planilla ya tiene asignada una cabecera");
            return $this->redireccionar('planilla/view/' . $planilla->getPlanillaId());
        }
        $this->view->planilla = $planilla;

    }
}
