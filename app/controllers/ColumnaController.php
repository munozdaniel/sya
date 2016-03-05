<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ColumnaController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Columnas');
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
     * Searches for columna
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Columna", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "columna_id";

        $columna = Columna::find($parameters);
        if (count($columna) == 0) {
            $this->flash->notice("The search did not find any columna");

            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $columna,
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
     * Edits a columna
     *
     * @param string $columna_id
     */
    public function editAction($columna_id)
    {

        if (!$this->request->isPost()) {

            $columna = Columna::findFirstBycolumna_id($columna_id);
            if (!$columna) {
                $this->flash->error("columna was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "columna",
                    "action" => "index"
                ));
            }

            $this->view->columna_id = $columna->columna_id;

            $this->tag->setDefault("columna_id", $columna->getColumnaId());
            $this->tag->setDefault("columna_nombre", $columna->getColumnaNombre());
            $this->tag->setDefault("columna_clave", $columna->getColumnaClave());
            $this->tag->setDefault("columna_posicion", $columna->getColumnaPosicion());
            $this->tag->setDefault("columna_extra", $columna->getColumnaExtra());
            $this->tag->setDefault("columna_cabeceraId", $columna->getColumnaCabeceraid());
            $this->tag->setDefault("columna_habilitado", $columna->getColumnaHabilitado());

        }
    }

    /**
     * Creates a new columna
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "index"
            ));
        }

        $columna = new Columna();

        $columna->setColumnaNombre($this->request->getPost("columna_nombre"));
        $columna->setColumnaClave($this->request->getPost("columna_clave"));
        $columna->setColumnaPosicion($this->request->getPost("columna_posicion"));
        $columna->setColumnaExtra($this->request->getPost("columna_extra"));
        $columna->setColumnaCabeceraid($this->request->getPost("columna_cabeceraId"));
        $columna->setColumnaHabilitado($this->request->getPost("columna_habilitado"));


        if (!$columna->save()) {
            foreach ($columna->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "new"
            ));
        }

        $this->flash->success("columna was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "columna",
            "action" => "index"
        ));

    }

    /**
     * Saves a columna edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "index"
            ));
        }

        $columna_id = $this->request->getPost("columna_id");

        $columna = Columna::findFirstBycolumna_id($columna_id);
        if (!$columna) {
            $this->flash->error("columna does not exist " . $columna_id);

            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "index"
            ));
        }

        $columna->setColumnaNombre($this->request->getPost("columna_nombre"));
        $columna->setColumnaClave($this->request->getPost("columna_clave"));
        $columna->setColumnaPosicion($this->request->getPost("columna_posicion"));
        $columna->setColumnaExtra($this->request->getPost("columna_extra"));
        $columna->setColumnaCabeceraid($this->request->getPost("columna_cabeceraId"));
        $columna->setColumnaHabilitado($this->request->getPost("columna_habilitado"));


        if (!$columna->save()) {

            foreach ($columna->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "edit",
                "params" => array($columna->columna_id)
            ));
        }

        $this->flash->success("columna was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "columna",
            "action" => "index"
        ));

    }

    /**
     * Deletes a columna
     *
     * @param string $columna_id
     */
    public function deleteAction($columna_id)
    {

        $columna = Columna::findFirstBycolumna_id($columna_id);
        if (!$columna) {
            $this->flash->error("columna was not found");

            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "index"
            ));
        }

        if (!$columna->delete()) {

            foreach ($columna->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "columna",
                "action" => "search"
            ));
        }

        $this->flash->success("columna was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "columna",
            "action" => "index"
        ));
    }
    /**************************************************************************************************/
    /**************************************************************************************************/
    public function obtenerColumnasAction()
    {
        $data['success'] = false;
        $this->view->disable();
        if ($this->request->getPost('planilla_id') != null) {
            $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('planilla_id'));
            if ($planilla && $planilla->getPlanillaCabeceraid() != null) {
                $columnas = $this->modelsManager
                    ->createBuilder()
                    ->columns('columna_nombre,columna_posicion')
                    ->from('Columna')
                    ->where('columna_cabeceraId=:columna_cabeceraId: AND columna_habilitado=1', array('columna_cabeceraId' => $planilla->getPlanillaCabeceraid()))
                    ->orderBy('columna_posicion ASC')
                    ->getQuery()
                    ->execute()->toArray();

                if ($columnas) {
                    $data['success'] = true;
                    $retorno = array();
                    $claves = array();
                    $i=0;
                    foreach ($columnas as $col) {
                        $retorno[] = $i;
                        $claves[] = array("data" => $col['columna_nombre']);
                        $i++;
                    }
                    $data['columnas'] = $retorno;
                    $data['claves'] = $claves;

                } else {
                    $data['success'] = false;
                }
            } else {
                $data['error'] = "La planilla no se encontró, o no contiene una cabecera apropiada.";
            }
        } else {
            $data['error'] = "Es necesario que seleccione una planilla ";
        }
        echo json_encode($data);
    }

    /***************************************************************************************************/
    public function obtenerIdColumnasAction()
    {
        $data['success'] = false;
        $this->view->disable();
        if ($this->request->getPost('planilla_id') != null) {
            $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('planilla_id'));
            if ($planilla && $planilla->getPlanillaCabeceraid() != null) {
                $columnas = $this->modelsManager
                    ->createBuilder()
                    ->columns('columna_nombre,columna_id')
                    ->from('Columna')
                    ->where('columna_cabeceraId=:columna_cabeceraId: AND columna_habilitado=1', array('columna_cabeceraId' => $planilla->getPlanillaCabeceraid()))
                    ->orderBy('columna_posicion ASC')
                    ->getQuery()
                    ->execute()->toArray();

                if ($columnas) {
                    $data['success'] = true;
                    $retorno = array();
                    foreach ($columnas as $col) {
                        $item = array();
                        $item['columna_id'] =  $col['columna_id'];
                        $item['columna_nombre'] = $col['columna_nombre'];
                        $retorno[] = $item;
                    }
                    $data['columnas'] = $retorno;

                } else {
                    $data['success'] = false;
                }
            } else {
                $data['error'] = "La planilla no se encontró, o no contiene una cabecera apropiada.";
            }
        } else {
            $data['error'] = "Es necesario que seleccione una planilla ";
        }
        echo json_encode($data);
    }
    /***************************************************************************************************/
    public function eliminarAction()
    {
        $this->assets->collection("headerCss")
            ->addCss('plugins/iCheck/all.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/iCheck/icheck.min.js');

        //SELECT2
        $this->importarSelect2();
        //Select Autocomplete Planilla
        $this->view->formulario = new \Phalcon\Forms\Element\Select('planilla_id',
            Planilla::find(array('planilla_habilitado=1 AND planilla_armada=1', 'order' => 'planilla_nombreCliente DESC')),
            array(
                'using' => array('planilla_id', 'planilla_nombreCliente'),
                'useEmpty' => true,
                'emptyText' => 'SELECCIONAR PLANILLA',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'required' => '',
                'onchange' => 'cargarColumnas()'
            ));
    }
    public function eliminarSeleccionadosAction()
    {
        $band=true;
        if(!$this->request->isPost()){
            return $this->redireccionar('columna/eliminar');
        }
        $columnas = $this->request->getPost('columnas');
        if($columnas==null)
        {
            $this->flash->error("Seleccione por lo menos una columna");
            return $this->redireccionar('columna/eliminar');
        }
        foreach ($columnas as $col) {
            $unaColumna = Columna::findFirst(array('columna_id = :id: AND columna_habilitado=1 ',
                'bind'=>array('id'=>$col)));
            if($unaColumna){
                $unaColumna->setColumnaHabilitado(0);
                if(!$unaColumna->update())
                {
                    $band=false;
                    $this->flash->error("La columna > $col < no se pudo eliminar");
                }
            }
            else
            {
                $band=false;
                $this->flash->error("No se pudo encontrar la columna > $col <");
            }

        }
        if($band)
            $this->flash->success("Operación exitosa: Las columnas se eliminaron.");
        return $this->redireccionar('columna/eliminar');
    }
}
