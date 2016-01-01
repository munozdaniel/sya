<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class FrsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('FRS');
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
     * Searches for frs
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Frs", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "frs_id";

        $frs = Frs::find($parameters);
        if (count($frs) == 0) {
            $this->flash->notice("No se han encontrado resultados");

            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $frs,
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
     * Edits a fr
     *
     * @param string $frs_id
     */
    public function editAction($frs_id)
    {

        if (!$this->request->isPost()) {

            $fr = Frs::findFirstByfrs_id($frs_id);
            if (!$fr) {
                $this->flash->error("No se encontró el FRS");

                return $this->dispatcher->forward(array(
                    "controller" => "frs",
                    "action" => "index"
                ));
            }

            $this->view->frs_id = $fr->frs_id;

            $this->tag->setDefault("frs_id", $fr->getFrsId());
            $this->tag->setDefault("frs_codigo", $fr->getFrsCodigo());
            $this->tag->setDefault("frs_habilitado", $fr->getFrsHabilitado());
            
        }
    }

    /**
     * Creates a new fr
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "index"
            ));
        }

        $fr = new Frs();

        $fr->setFrsCodigo($this->request->getPost("frs_codigo"));
        $fr->setFrsHabilitado(1);
        

        if (!$fr->save()) {
            foreach ($fr->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "new"
            ));
        }

        $this->flash->success("EL FRS ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "frs",
            "action" => "index"
        ));

    }

    /**
     * Saves a fr edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "index"
            ));
        }

        $frs_id = $this->request->getPost("frs_id");

        $fr = Frs::findFirstByfrs_id($frs_id);
        if (!$fr) {
            $this->flash->error("El FRS no existe ID:" . $frs_id);

            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "index"
            ));
        }

        $fr->setFrsCodigo($this->request->getPost("frs_codigo"));
        $fr->setFrsHabilitado(1);
        

        if (!$fr->save()) {

            foreach ($fr->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "edit",
                "params" => array($fr->frs_id)
            ));
        }

        $this->flash->success("El FRS ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "frs",
            "action" => "index"
        ));

    }

    /**
     * Deletes a fr
     *
     * @param string $frs_id
     */
    public function deleteAction($frs_id)
    {

        $fr = Frs::findFirstByfrs_id($frs_id);
        if (!$fr) {
            $this->flash->error("No se encontró el FRS");

            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "index"
            ));
        }

        if (!$fr->delete()) {

            foreach ($fr->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "frs",
                "action" => "search"
            ));
        }

        $this->flash->success("El FRS ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "frs",
            "action" => "index"
        ));
    }

}
