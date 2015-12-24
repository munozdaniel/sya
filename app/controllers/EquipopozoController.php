<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class EquipopozoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Equipo/Pozo');
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
        $this->view->equipoPozoForm = new EquipoPozoForm();
    }

    /**
     * Searches for equipopozo
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            //$query = parent::fromInput($this->di, 'Equipopozo', $this->request->getPost());
            $query = Criteria::fromInput($this->di, "Equipopozo", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "equipoPozo_id";

        $equipopozo = Equipopozo::find($parameters);
        if (count($equipopozo) == 0) {
            $this->flash->notice("No se encontraron resultados en la busqueda");

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $equipopozo,
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
        $this->view->equipoPozoForm = new EquipoPozoForm(null, array('edit' => true));
    }

    /**
     * Edits a equipopozo
     *
     * @param string $equipoPozo_id
     */
    public function editAction($equipoPozo_id)
    {

        if (!$this->request->isPost()) {

            $equipopozo = Equipopozo::findFirstByequipoPozo_id($equipoPozo_id);
            if (!$equipopozo) {
                $this->flash->error("El Equipo/Pozo no se encontró");

                return $this->dispatcher->forward(array(
                    "controller" => "equipopozo",
                    "action" => "index"
                ));
            }

            $this->view->equipoPozo_id = $equipopozo->equipoPozo_id;

            $this->tag->setDefault("equipoPozo_id", $equipopozo->getEquipopozoId());
            $this->tag->setDefault("equipoPozo_nombre", $equipopozo->getEquipopozoNombre());
            $this->tag->setDefault("equipoPozo_habilitado", $equipopozo->getEquipopozoHabilitado());
            
        }
    }

    /**
     * Creates a new equipopozo
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $equipopozo = new Equipopozo();
        if($this->request->getPost("nuevoYacimiento")==1)//Nuevo Yacimiento? 1:SI
        {
            $yacimiento = new Yacimiento();
            $yacimiento->assign(array(
                'yacimiento_destino' => $this->request->getPost('yacimiento_destino'),
                'yacimiento_habilitado' => 1,
            ));
            if(!$yacimiento->save())
            {
                foreach ($yacimiento->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
            $equipopozo->setEquipoPozoYacimientoId($yacimiento->getYacimientoId());
        }
        else{
            $equipopozo->setEquipoPozoYacimientoId($this->request->getPost("equipoPozo_yacimientoId"));
        }
        $equipopozo->setEquipopozoNombre($this->request->getPost("equipoPozo_nombre"));
        $equipopozo->setEquipopozoHabilitado(1);

        if (!$equipopozo->save()) {
            foreach ($equipopozo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "new"
            ));
        }

        $this->flash->success("El Equipo/Pozo se ha actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "equipopozo",
            "action" => "index"
        ));

    }

    /**
     * Saves a equipopozo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $equipoPozo_id = $this->request->getPost("equipoPozo_id");

        $equipopozo = Equipopozo::findFirstByequipoPozo_id($equipoPozo_id);
        if (!$equipopozo) {
            $this->flash->error("El Equipo/Pozo no existe - ID: " . $equipoPozo_id);

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        $equipopozo->setEquipopozoNombre($this->request->getPost("equipoPozo_nombre"));
        $equipopozo->setEquipopozoHabilitado(1);
        

        if (!$equipopozo->save()) {

            foreach ($equipopozo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "edit",
                "params" => array($equipopozo->equipoPozo_id)
            ));
        }

        $this->flash->success("El Equipo/Pozo se ha creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "equipopozo",
            "action" => "index"
        ));

    }

    /**
     * Deletes a equipopozo
     *
     * @param string $equipoPozo_id
     */
    public function deleteAction($equipoPozo_id)
    {

        $equipopozo = Equipopozo::findFirstByequipoPozo_id($equipoPozo_id);
        if (!$equipopozo) {
            $this->flash->error("El Equipo/Pozo no se encontró");

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "index"
            ));
        }

        if (!$equipopozo->delete()) {

            foreach ($equipopozo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "search"
            ));
        }

        $this->flash->success("El Equipo/Pozo ha sido eliminado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "equipopozo",
            "action" => "index"
        ));
    }
    /**
     * Eliminar un equipopozo de manera logica.
     *
     * @return bool
     */
    public function eliminarAction()
    {
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $equipopozo = Equipopozo::findFirstByEquipopozo_id($id);
            if (!$equipopozo) {
                $this->flash->error("El Equipo/Pozo no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "equipopozo",
                    "action" => "index"
                ));
            }
            $equipopozo->equipoPozo_habilitado = 0;
            if (!$equipopozo->update()) {

                foreach ($equipopozo->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "equipopozo",
                    "action" => "search"
                ));
            }

            $this->flash->success("El Equipo/Pozo ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "search"
            ));
        }
    }

    /**
     * Habilitar un equipopozo.
     * @param $idTransporte
     * @return bool
     */
    public function habilitarAction($idTransporte)
    {
        $equipopozo = Equipopozo::findFirstByEquipopozo_id($idTransporte);
        $equipopozo->equipoPozo_habilitado = 1;
        if (!$equipopozo->update()) {

            foreach ($equipopozo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "equipopozo",
                "action" => "search"
            ));
        }

        $this->flash->success("El Equipo/Pozo ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "equipopozo",
            "action" => "search"
        ));
    }
}
