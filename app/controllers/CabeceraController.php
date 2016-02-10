<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CabeceraController extends ControllerBase
{

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
    public function crearAction()
    {
        $this->view->disable();
        $error = array();      // array to hold validation errors
        $data = array();
        $data['success'] = false;
        if ($this->request->isPost()) {
            $this->db->begin();

            //si existe el token del formulario y es correcto(evita csrf)
            //if ($this->security->checkToken('token',$this->request->getPost('token'))) {
            if (!$this->request->hasPost('columna')) {
                $error = "No puede guardar columnas vacias.";
            } else {
                //$cabeceraId = Cabecera::guardar($this->request->getPost('planilla_nombreCliente'));
                $nombreCabecera = $this->request->getPost('planilla_nombreCliente');//Unique
                $cabecera = Cabecera::findFirstByCabecera_nombre($nombreCabecera.' / '.date('d-m-Y'));
                if($cabecera==null){
                    $cabecera = new Cabecera();
                    $cabecera->setCabeceraNombre($nombreCabecera.' / '.date('d-m-Y'));//Nombre recuperado del paso 1
                    $cabecera->setCabeceraHabilitado(1);
                    if (!$cabecera->save()) {
                        foreach ($cabecera->getMessages() as $message) {
                            $error[] = $message . " <br>";
                        }
                    }
                }
                if(!Columna::guardarColumnasBasica($cabecera->getCabeceraId()))
                    $error = "Hubo un error al generar las columnas básicas";

                $arregloColumnas = $this->request->getPost('columna');
                foreach ($arregloColumnas AS $columna) {
                    if (!empty($columna)) {
                        $nuevaColumna = new Columna();
                        $nuevaColumna->setColumnaNombre(strtoupper($columna));
                        $nuevaColumna->setColumnaClave('clave_' . strtoupper($columna));
                        $nuevaColumna->setColumnaExtra(1);
                        $nuevaColumna->setColumnaCabeceraId($cabecera->getCabeceraId());
                        $nuevaColumna->setColumnaHabilitado(1);
                        if (!$nuevaColumna->save()) {
                            foreach ($nuevaColumna->getMessages() as $message) {
                                $error[] = $message . " <br>";
                            }
                        }
                    } else {
                        $error = "Debe ingresar el nombre de la columna";
                    }
                }
            }
            if (empty($error)) {
                $this->db->commit();
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
     * Carga el combobox con todas las cabeceres disponibles.
     */
    public function cargarCabeceraAction()
    {
        $this->view->disable();
        if ($this->request->isPost()) {
            $data['success']=true;
            $data['mensaje']= Cabecera::findAllCabecera();
            echo json_encode($data);
        }
    }

    public function buscarColumnasAction()
    {
        $this->view->disable();
        $retorno= array();
        if ($this->request->isPost()) {
            $columnas = Columna::find(array(
                'conditions'=>'columna_cabeceraId = :cabecera_id:',
                'bind' => array(
                    'cabecera_id'=>$this->request->getPost('cabecera_id')
                ),
                'order'=>'columna_posicion ASC'
            ));
            if(empty($columnas))
            {
                $data['success']=false;
                $data['mensaje']="No hay columnas cargadas.";
            }else{
                foreach($columnas as $col){
                    $item = array();
                    $item['nombre']=$col->getColumnaNombre();
                    $item['id']=$col->getColumnaId();
                    $retorno[]=$item;
                }
            }
        }
        $data['success']=true;
        $data['mensaje']=$retorno;
        echo json_encode($data);
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

}
