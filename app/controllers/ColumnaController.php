<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ColumnaController extends ControllerBase
{

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
        $this->view->disable();
        $planilla = Planilla::findFirstByPlanilla_id($this->request->getPost('planilla_id'));
        $columnas = $this->modelsManager
            ->createBuilder()
            ->columns('columna_posicion')
            ->from('Columna')
            ->where('columna_cabeceraId=:columna_cabeceraId: ',array('columna_cabeceraId'=>$planilla->getPlanillaCabeceraid()))
            ->orderBy('columna_id ASC')
            ->getQuery()
            ->execute()->toArray();
        $data['holo']=$this->request->getPost('planilla_id');
        if($columnas)
        {
            $data['success']=true;
            $data['columnas']=$columnas;

        }
        else
        {
            $data['success']=false;
        }
        echo json_encode($data);
    }

}
