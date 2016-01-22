<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class LineaController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Linea');
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
     * Searches for linea
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Linea", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "linea_id";

        $linea = Linea::find($parameters);
        if (count($linea) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $linea,
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
     * Edits a linea
     *
     * @param string $linea_id
     */
    public function editAction($linea_id)
    {

        if (!$this->request->isPost()) {

            $linea = Linea::findFirstBylinea_id($linea_id);
            if (!$linea) {
                $this->flash->error("La linea no se encontró");

                return $this->dispatcher->forward(array(
                    "controller" => "linea",
                    "action" => "index"
                ));
            }

            $this->view->linea_id = $linea->linea_id;

            $this->tag->setDefault("linea_id", $linea->getLineaId());
            $this->tag->setDefault("linea_nombre", $linea->getLineaNombre());
            $this->tag->setDefault("linea_habilitado", $linea->getLineaHabilitado());
            
        }
    }

    /**
     * Creates a new linea
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea = new Linea();

        $linea->setLineaNombre($this->request->getPost("linea_nombre"));
        $linea->setLineaHabilitado(1);
        

        if (!$linea->save()) {
            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "new"
            ));
        }

        $this->flash->success("La linea ha sido creada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));

    }

    /**
     * Saves a linea edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea_id = $this->request->getPost("linea_id");

        $linea = Linea::findFirstBylinea_id($linea_id);
        if (!$linea) {
            $this->flash->error("La linea no existe - ID: " . $linea_id);

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        $linea->setLineaNombre($this->request->getPost("linea_nombre"));
        $linea->setLineaHabilitado(1);
        

        if (!$linea->save()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "edit",
                "params" => array($linea->linea_id)
            ));
        }

        $this->flash->success("La linea ha sido actualizada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "index"
        ));

    }

    /**
     * Deletes a linea
     *
     * @param string $linea_id
     */
    public function deleteAction($linea_id)
    {

        $linea = Linea::findFirstBylinea_id($linea_id);
        if (!$linea) {
            $this->flash->error("La linea no se encontró");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "index"
            ));
        }

        if (!$linea->delete()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "search"
            ));
        }

        $this->flash->success("La linea se ha eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
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
            $linea = Linea::findFirstByLinea_id($id);
            if (!$linea) {
                $this->flash->error("La Linea no ha sido encontrada");

                return $this->dispatcher->forward(array(
                    "controller" => "linea",
                    "action" => "index"
                ));
            }
            $linea->linea_habilitado = 0;
            if (!$linea->update()) {

                foreach ($linea->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "linea",
                    "action" => "search"
                ));
            }

            $this->flash->success("La Linea ha sido eliminada correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "linea",
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
        $linea = Linea::findFirstByLinea_id($id);
        $linea->linea_habilitado = 1;
        if (!$linea->update()) {

            foreach ($linea->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "linea",
                "action" => "search"
            ));
        }

        $this->flash->success("La Linea ha sido habilitada");

        return $this->dispatcher->forward(array(
            "controller" => "linea",
            "action" => "search"
        ));
    }
    public function buscarLineasAction()
    {
        $this->view->disable();

        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");
                $lista = Linea::find(array(
                    "linea_clienteId = :id: AND linea_habilitado=1",'bind'=>array('id'=>$id)
                ));
                $resData = array();
                foreach ($lista as $item) {
                    $resData[] = array("linea_id" => $item->getLineaId(), "linea_nombre" => $item->getLineaNombre());
                }

                if (count($lista) > 0) {
                    $this->response->setJsonContent(array("lista" => $resData));
                    $this->response->setStatusCode(200, "OK");
                }else{
                    $this->response->setJsonContent(array("lista" => null));
                }
                $this->response->send();
            }
        }

    }
}
