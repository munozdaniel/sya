<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OrdenController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for orden
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Orden", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "orden_id";

        $orden = Orden::find($parameters);
        if (count($orden) == 0) {
            $this->flash->notice("The search did not find any orden");

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $orden,
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
     * Edits a orden
     *
     * @param string $orden_id
     */
    public function editAction($orden_id)
    {

        if (!$this->request->isPost()) {

            $orden = Orden::findFirstByorden_id($orden_id);
            if (!$orden) {
                $this->flash->error("orden was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "orden",
                    "action" => "index"
                ));
            }

            $this->view->orden_id = $orden->orden_id;

            $this->tag->setDefault("orden_id", $orden->getOrdenId());
            $this->tag->setDefault("orden_planilla", $orden->getOrdenPlanilla());
            $this->tag->setDefault("orden_periodo", $orden->getOrdenPeriodo());
            $this->tag->setDefault("orden_transporte", $orden->getOrdenTransporte());
            $this->tag->setDefault("orden_tipoEquipo", $orden->getOrdenTipoequipo());
            $this->tag->setDefault("orden_tipoCarga", $orden->getOrdenTipocarga());
            $this->tag->setDefault("orden_chofer", $orden->getOrdenChofer());
            $this->tag->setDefault("orden_cliente", $orden->getOrdenCliente());
            $this->tag->setDefault("orden_viaje", $orden->getOrdenViaje());
            $this->tag->setDefault("orden_tarifa", $orden->getOrdenTarifa());
            $this->tag->setDefault("orden_columnaExtra", $orden->getOrdenColumnaextra());
            $this->tag->setDefault("orden_observacion", $orden->getOrdenObservacion());
            $this->tag->setDefault("orden_fecha", $orden->getOrdenFecha());
            $this->tag->setDefault("orden_fechaCreacion", $orden->getOrdenFechacreacion());
            $this->tag->setDefault("orden_conformidad", $orden->getOrdenConformidad());
            $this->tag->setDefault("orden_noConformidad", $orden->getOrdenNoconformidad());
            $this->tag->setDefault("orden_creadoPor", $orden->getOrdenCreadopor());
            
        }
    }

    /**
     * Creates a new orden
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "index"
            ));
        }

        $orden = new Orden();

        $orden->setOrdenPlanilla($this->request->getPost("orden_planilla"));
        $orden->setOrdenPeriodo($this->request->getPost("orden_periodo"));
        $orden->setOrdenTransporte($this->request->getPost("orden_transporte"));
        $orden->setOrdenTipoequipo($this->request->getPost("orden_tipoEquipo"));
        $orden->setOrdenTipocarga($this->request->getPost("orden_tipoCarga"));
        $orden->setOrdenChofer($this->request->getPost("orden_chofer"));
        $orden->setOrdenCliente($this->request->getPost("orden_cliente"));
        $orden->setOrdenViaje($this->request->getPost("orden_viaje"));
        $orden->setOrdenTarifa($this->request->getPost("orden_tarifa"));
        $orden->setOrdenColumnaextra($this->request->getPost("orden_columnaExtra"));
        $orden->setOrdenObservacion($this->request->getPost("orden_observacion"));
        $orden->setOrdenFecha($this->request->getPost("orden_fecha"));
        $orden->setOrdenFechacreacion($this->request->getPost("orden_fechaCreacion"));
        $orden->setOrdenConformidad($this->request->getPost("orden_conformidad"));
        $orden->setOrdenNoconformidad($this->request->getPost("orden_noConformidad"));
        $orden->setOrdenCreadopor($this->request->getPost("orden_creadoPor"));
        

        if (!$orden->save()) {
            foreach ($orden->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "new"
            ));
        }

        $this->flash->success("orden was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "orden",
            "action" => "index"
        ));

    }

    /**
     * Saves a orden edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "index"
            ));
        }

        $orden_id = $this->request->getPost("orden_id");

        $orden = Orden::findFirstByorden_id($orden_id);
        if (!$orden) {
            $this->flash->error("orden does not exist " . $orden_id);

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "index"
            ));
        }

        $orden->setOrdenPlanilla($this->request->getPost("orden_planilla"));
        $orden->setOrdenPeriodo($this->request->getPost("orden_periodo"));
        $orden->setOrdenTransporte($this->request->getPost("orden_transporte"));
        $orden->setOrdenTipoequipo($this->request->getPost("orden_tipoEquipo"));
        $orden->setOrdenTipocarga($this->request->getPost("orden_tipoCarga"));
        $orden->setOrdenChofer($this->request->getPost("orden_chofer"));
        $orden->setOrdenCliente($this->request->getPost("orden_cliente"));
        $orden->setOrdenViaje($this->request->getPost("orden_viaje"));
        $orden->setOrdenTarifa($this->request->getPost("orden_tarifa"));
        $orden->setOrdenColumnaextra($this->request->getPost("orden_columnaExtra"));
        $orden->setOrdenObservacion($this->request->getPost("orden_observacion"));
        $orden->setOrdenFecha($this->request->getPost("orden_fecha"));
        $orden->setOrdenFechacreacion($this->request->getPost("orden_fechaCreacion"));
        $orden->setOrdenConformidad($this->request->getPost("orden_conformidad"));
        $orden->setOrdenNoconformidad($this->request->getPost("orden_noConformidad"));
        $orden->setOrdenCreadopor($this->request->getPost("orden_creadoPor"));
        

        if (!$orden->save()) {

            foreach ($orden->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "edit",
                "params" => array($orden->orden_id)
            ));
        }

        $this->flash->success("orden was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "orden",
            "action" => "index"
        ));

    }

    /**
     * Deletes a orden
     *
     * @param string $orden_id
     */
    public function deleteAction($orden_id)
    {

        $orden = Orden::findFirstByorden_id($orden_id);
        if (!$orden) {
            $this->flash->error("orden was not found");

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "index"
            ));
        }

        if (!$orden->delete()) {

            foreach ($orden->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "search"
            ));
        }

        $this->flash->success("orden was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "orden",
            "action" => "index"
        ));
    }

}
