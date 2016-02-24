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
    public function agregarExtraAction()
    {
        $this->view->disable();
        $error = array();      // array to hold validation errors
        $data = array();
        $data['success'] = false;
        $data['mensaje'] = "Ops, ha ocurrido un problema.";
        if ($this->request->isPost()) {
            $this->db->begin();

            //si existe el token del formulario y es correcto(evita csrf)
            //if ($this->security->checkToken('token',$this->request->getPost('token'))) {
            if (!$this->request->hasPost('columna')) {
                $error = "No puede guardar columnas vacias.";
            } else {
                //$cabeceraId = Cabecera::guardar($this->request->getPost('planilla_nombreCliente'));
                $cabecera_id = $this->request->getPost('cabecera_id', 'int');
                $cabecera = Cabecera::findFirstByCabecera_id($cabecera_id);
                if (!$cabecera) {
                    $error = "Hubo un problema, no se encontro la cabecera.";
                } else {
                    $arregloColumnas = $this->request->getPost('columna');
                    foreach ($arregloColumnas AS $columna) {
                        if (!empty($columna)) {
                            $nuevaColumna = new Columna();
                            $nuevaColumna->setColumnaNombre(strtoupper($columna));
                            $nuevaColumna->setColumnaClave('CLAVE_' . strtoupper($columna));
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
     * COn el nombre del cliente obtenido del comboBox, recupero todos las planillas con un LIKE %%
     * A partir de todas las planillas obtengo todos las cabeceras_id
     */
    public function todasLasCabecerasAction()
    {
        $this->view->disable();
        $data=array();
        $data['success']=false;

        if($this->request->isPost()){
            $planillas = Planilla::find(
                array('conditions'=>"planilla_habilitado =1  AND planilla_nombreCliente LIKE :nombreCliente:",
                    'bind'=>array('nombreCliente'=>"%".$this->request->getPost('cliente_nombre','string')."%")));
            $data['planilla'] = count($planillas);
            if(!$planillas)
            {
                $data['mensaje'] = array("NO SE ENCONTRARON CABECERAS CARGADAS " );
            }
            $retorno = array();
            foreach($planillas as $planilla)
            {
                if($planilla->getPlanillaCabeceraId()!=null){
                    $item = array();
                    $item['cabecera_id']=$planilla->getPlanillaCabeceraId();
                    $item['nombreCliente']=$planilla->getPlanillaNombreCliente();
                    $retorno[]=$item;
                }
            }
            if(count($retorno)>0)
            {
                $data['success']=true;
                $data['cabeceras']=$retorno;
            }else{
                $data['mensaje'] = array("HUBO UN PROBLEMA, NO SE ENCONTRARON CABECERAS CARGADAS - ".$this->request->getPost('cliente_nombre'));
            }

            echo json_encode($data);
        }else{
            $data['mensaje']=array("PROBLEMAS CON LA URL");
        echo json_encode($data);
        }
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
            $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('planilla_id','int'));
            if(!empty($planilla) && $planilla!=null)
                $data = $this->columnasBasicas($planilla);
            else{
                $data['success']=false;
                $data['mensaje']="La planilla no se encuentra disponible.";
            }
            echo json_encode($data);
        }else{
            echo json_encode(array('success'=>false,'mensaje'=>'NO ES POST'));
        }
    }
    private function columnasBasicas($planilla)
    {
        $data = array();
        $data['success']=true;
        $retorno=array();


            $cabecera = new Cabecera();
            $cabecera->setCabeceraFecha(date('Y-m-d'));
            $cabecera->setCabeceraHabilitado(1);
            $cabecera->setCabeceraNombre($planilla->getPlanillaNombrecliente());
            if (!$cabecera->save()) {
                foreach ($cabecera->getMessages() as $mensaje) {
                    $retorno[] = $mensaje;
                }
                $data['success'] = false;
            }
            /*====== Crear columnas =======*/
            else{
                /*Creo manualmente las columnas*/
                $data = Columna::guardarColumnasBasica($cabecera->getCabeceraId());
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
        if($data['success'])
            $data['mensaje']="OPERACION EXITOSA";
        else
            $data['mensaje']=$retorno;
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

}
