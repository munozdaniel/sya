<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ViajeController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Viaje');
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
     * Searches for viaje
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Viaje", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "viaje_id";

        $viaje = Viaje::find($parameters);
        if (count($viaje) == 0) {
            $this->flash->notice("No se encontraron registros");

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $viaje,
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
     * Edits a viaje
     *
     * @param string $viaje_id
     */
    public function editAction($viaje_id)
    {

        if (!$this->request->isPost()) {

            $viaje = Viaje::findFirstByviaje_id($viaje_id);
            if (!$viaje) {
                $this->flash->error("El viaje no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "viaje",
                    "action" => "index"
                ));
            }

            $this->view->viaje_id = $viaje->viaje_id;

            $this->tag->setDefault("viaje_id", $viaje->getViajeId());
            $this->tag->setDefault("viaje_origen", $viaje->getViajeOrigen());
            $this->tag->setDefault("viaje_concatenado", $viaje->getViajeConcatenado());
            $this->tag->setDefault("viaje_habilitado", $viaje->getViajeHabilitado());
            
        }
    }

    /**
     * Creates a new viaje
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $viaje = new Viaje();

        $viaje->setViajeOrigen($this->request->getPost("viaje_origen"));
        $viaje->setViajeConcatenado($this->request->getPost("viaje_concatenado"));
        $viaje->setViajeHabilitado($this->request->getPost("viaje_habilitado"));
        

        if (!$viaje->save()) {
            foreach ($viaje->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "new"
            ));
        }

        $this->flash->success("El viaje ha sido creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "viaje",
            "action" => "index"
        ));

    }

    /**
     * Saves a viaje edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $viaje_id = $this->request->getPost("viaje_id");

        $viaje = Viaje::findFirstByviaje_id($viaje_id);
        if (!$viaje) {
            $this->flash->error("viaje does not exist " . $viaje_id);

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "index"
            ));
        }

        $viaje->setViajeOrigen($this->request->getPost("viaje_origen"));
        $viaje->setViajeConcatenado($this->request->getPost("viaje_concatenado"));
        $viaje->setViajeHabilitado(1);
        

        if (!$viaje->save()) {

            foreach ($viaje->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "edit",
                "params" => array($viaje->viaje_id)
            ));
        }

        $this->flash->success("El viaje ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "viaje",
            "action" => "index"
        ));

    }
    /**
     * Eliminar un transporte de manera logica.
     *
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $viaje = Viaje::findFirstByViaje_id($id);
            if (!$viaje) {
                $this->flash->error("El viaje no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "viaje",
                    "action" => "index"
                ));
            }
            $viaje->viaje_habilitado = 0;
            if (!$viaje->update()) {

                foreach ($viaje->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "viaje",
                    "action" => "search"
                ));
            }

            $this->flash->success("El viaje ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "search"
            ));
        }
    }

    /**
     * Habilitar un transporte.
     * @return bool
     */
    public function habilitarAction($idviaje)
    {
        $viaje= Viaje::findFirstByViaje_id($idviaje);
        $viaje->viaje_habilitado = 1;
        if (!$viaje->update()) {

            foreach ($viaje->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "viaje",
                "action" => "search"
            ));
        }

        $this->flash->success("El viaje ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "viaje",
            "action" => "search"
        ));
    }


}
