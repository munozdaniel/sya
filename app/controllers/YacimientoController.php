<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class YacimientoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Yacimiento');
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
     * Searches for yacimiento
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Yacimiento", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "yacimiento_id";

        $yacimiento = Yacimiento::find($parameters);
        if (count($yacimiento) == 0) {
            $this->flash->notice("No se encontraron resultados");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $yacimiento,
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
     * Edits a yacimiento
     *
     * @param string $yacimiento_id
     */
    public function editAction($yacimiento_id)
    {

        if (!$this->request->isPost()) {

            $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
            if (!$yacimiento) {
                $this->flash->error("El yacimiento no se encontro");

                return $this->dispatcher->forward(array(
                    "controller" => "yacimiento",
                    "action" => "index"
                ));
            }

            $this->view->yacimiento_id = $yacimiento->yacimiento_id;

            $this->tag->setDefault("yacimiento_id", $yacimiento->getYacimientoId());
            $this->tag->setDefault("yacimiento_destino", $yacimiento->getYacimientoDestino());
            $this->tag->setDefault("yacimiento_habilitado", $yacimiento->getYacimientoHabilitado());
            
        }
    }

    /**
     * Creates a new yacimiento
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento = new Yacimiento();

        $yacimiento->setYacimientoDestino($this->request->getPost("yacimiento_destino"));
        $yacimiento->setYacimientoHabilitado(1);
        

        if (!$yacimiento->save()) {
            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "new"
            ));
        }

        $this->flash->success("El yacimiento fue creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));

    }

    /**
     * Saves a yacimiento edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento_id = $this->request->getPost("yacimiento_id");

        $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
        if (!$yacimiento) {
            $this->flash->error("El Yacimiento no existe ID: " . $yacimiento_id);

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $yacimiento->setYacimientoDestino($this->request->getPost("yacimiento_destino"));
        $yacimiento->setYacimientoHabilitado($this->request->getPost("yacimiento_habilitado"));
        

        if (!$yacimiento->save()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "edit",
                "params" => array($yacimiento->yacimiento_id)
            ));
        }

        $this->flash->success("El yacimiento ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));

    }

    /**
     * Deletes a yacimiento
     *
     * @param string $yacimiento_id
     */
    public function deleteAction($yacimiento_id)
    {

        $yacimiento = Yacimiento::findFirstByyacimiento_id($yacimiento_id);
        if (!$yacimiento) {
            $this->flash->error("El Yacimiento no se encuentra");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        if (!$yacimiento->delete()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "search"
            ));
        }

        $this->flash->success("El Yacimiento se ha eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "index"
        ));
    }
    /**
     * Eliminar un yacimiento de manera logica.
     *
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $yacimiento = Yacimiento::findFirstByYacimiento_id($id);
            if (!$yacimiento) {
                $this->flash->error("El yacimiento no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "yacimiento",
                    "action" => "index"
                ));
            }
            $yacimiento->yacimiento_habilitado = 0;
            if (!$yacimiento->update()) {

                foreach ($yacimiento->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "yacimiento",
                    "action" => "search"
                ));
            }

            $this->flash->success("El yacimiento ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "search"
            ));
        }
    }

    /**
     * Habilitar un yacimiento.
     * @param $idTransporte
     * @return bool
     */
    public function habilitarAction($idTransporte)
    {
        $yacimiento = Yacimiento::findFirstByYacimiento_id($idTransporte);
        $yacimiento->yacimiento_habilitado = 1;
        if (!$yacimiento->update()) {

            foreach ($yacimiento->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "search"
            ));
        }

        $this->flash->success("El yacimiento ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "yacimiento",
            "action" => "search"
        ));
    }

}
