<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ConcatenadoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Concatenado');
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
     * Searches for concatenado
     */
    public function searchAction()
    {

        parent::importarJsTable();
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Concatenado", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "concatenado_id";

        $concatenado = Concatenado::find($parameters);
        if (count($concatenado) == 0) {
            $this->flash->notice("La búsqueda no encontró ningún resultado");

            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $concatenado,
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
     * Edits a concatenado
     *
     * @param string $concatenado_id
     */
    public function editAction($concatenado_id)
    {

        if (!$this->request->isPost()) {

            $concatenado = Concatenado::findFirstByconcatenado_id($concatenado_id);
            if (!$concatenado) {
                $this->flash->error("El concatenado no se encontró");

                return $this->dispatcher->forward(array(
                    "controller" => "concatenado",
                    "action" => "index"
                ));
            }

            $this->view->concatenado_id = $concatenado->concatenado_id;

            $this->tag->setDefault("concatenado_id", $concatenado->getConcatenadoId());
            $this->tag->setDefault("concatenado_nombre", $concatenado->getConcatenadoNombre());
            $this->tag->setDefault("concatenado_habilitado", $concatenado->getConcatenadoHabilitado());
            
        }
    }

    /**
     * Creates a new concatenado
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "index"
            ));
        }

        $concatenado = new Concatenado();

        $concatenado->setConcatenadoNombre($this->request->getPost("concatenado_nombre"));
        $concatenado->setConcatenadoHabilitado(1);
        

        if (!$concatenado->save()) {
            foreach ($concatenado->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "new"
            ));
        }

        $this->flash->success("El concatenado fue creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "concatenado",
            "action" => "index"
        ));

    }

    /**
     * Saves a concatenado edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "index"
            ));
        }

        $concatenado_id = $this->request->getPost("concatenado_id");

        $concatenado = Concatenado::findFirstByconcatenado_id($concatenado_id);
        if (!$concatenado) {
            $this->flash->error("El concatenado no existe " . $concatenado_id);

            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "index"
            ));
        }

        $concatenado->setConcatenadoNombre($this->request->getPost("concatenado_nombre"));
        $concatenado->setConcatenadoHabilitado($this->request->getPost("concatenado_habilitado"));
        

        if (!$concatenado->save()) {

            foreach ($concatenado->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "edit",
                "params" => array($concatenado->concatenado_id)
            ));
        }

        $this->flash->success("El concatenado fue actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "concatenado",
            "action" => "index"
        ));

    }

    /**
     * Deletes a concatenado
     *
     * @param string $concatenado_id
     */
    public function deleteAction($concatenado_id)
    {

        $concatenado = Concatenado::findFirstByconcatenado_id($concatenado_id);
        if (!$concatenado) {
            $this->flash->error("concatenado was not found");

            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "index"
            ));
        }

        if (!$concatenado->delete()) {

            foreach ($concatenado->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "concatenado",
                "action" => "search"
            ));
        }

        $this->flash->success("El concatenado fue borrado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "concatenado",
            "action" => "index"
        ));
    }

}
