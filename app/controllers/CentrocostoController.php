<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CentrocostoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Centro Costo');
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
     * Searches for centrocosto
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Centrocosto", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "centroCosto_id";

        $centrocosto = Centrocosto::find($parameters);
        if (count($centrocosto) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $centrocosto,
            "limit"=> 10000,
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
     * Edits a centrocosto
     *
     * @param string $centroCosto_id
     */
    public function editAction($centroCosto_id)
    {

        if (!$this->request->isPost()) {

            $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
            if (!$centrocosto) {
                $this->flash->error("Centro Costo no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "index"
                ));
            }

            $this->view->centroCosto_id = $centrocosto->centroCosto_id;

            $this->tag->setDefault("centroCosto_id", $centrocosto->getCentrocostoId());
            $this->tag->setDefault("centroCosto_codigo", $centrocosto->getCentrocostoCodigo());
            $this->tag->setDefault("centroCosto_habilitado", $centrocosto->getCentrocostoHabilitado());
            
        }
    }

    /**
     * Creates a new centrocosto
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centrocosto = new Centrocosto();

        $centrocosto->setCentrocostoCodigo($this->request->getPost("centroCosto_codigo"));
        $centrocosto->setCentrocostoHabilitado(1);
        

        if (!$centrocosto->save()) {
            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "new"
            ));
        }

        $this->flash->success("Centro Costo ha sido creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));

    }

    /**
     * Saves a centrocosto edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centroCosto_id = $this->request->getPost("centroCosto_id");

        $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
        if (!$centrocosto) {
            $this->flash->error("Centro Costo no existe - ID: " . $centroCosto_id);

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        $centrocosto->setCentrocostoCodigo($this->request->getPost("centroCosto_codigo"));
        $centrocosto->setCentrocostoHabilitado($this->request->getPost("centroCosto_habilitado"));
        

        if (!$centrocosto->save()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "edit",
                "params" => array($centrocosto->centroCosto_id)
            ));
        }

        $this->flash->success("Centro Costo ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));

    }

    /**
     * Deletes a centrocosto
     *
     * @param string $centroCosto_id
     */
    public function deleteAction($centroCosto_id)
    {

        $centrocosto = Centrocosto::findFirstBycentroCosto_id($centroCosto_id);
        if (!$centrocosto) {
            $this->flash->error("Centro Costo no ha sido encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "index"
            ));
        }

        if (!$centrocosto->delete()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "search"
            ));
        }

        $this->flash->success("Centro Costo ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "index"
        ));
    }
    /**
     * Eliminar manera logica.
     *
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $centrocosto = centrocosto::findFirstByCentroCosto_id($id);
            if (!$centrocosto) {
                $this->flash->error("El Centro Costo  no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "index"
                ));
            }
            $centrocosto->centroCosto_habilitado = 0;
            if (!$centrocosto->update()) {

                foreach ($centrocosto->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "centrocosto",
                    "action" => "search"
                ));
            }

            $this->flash->success("El Centro Costo ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "search"
            ));
        }
    }

    /**
     * Habilitar.
     * @return bool
     */
    public function habilitarAction($id)
    {
        $centrocosto = Centrocosto::findFirstByCentroCosto_id($id);
        $centrocosto->centroCosto_habilitado = 1;
        if (!$centrocosto->update()) {

            foreach ($centrocosto->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "centrocosto",
                "action" => "search"
            ));
        }

        $this->flash->success("El Centro Costo ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "centrocosto",
            "action" => "search"
        ));
    }
}
