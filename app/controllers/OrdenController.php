<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OrdenController extends ControllerBase
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
     * Searches for orden
     */
    public function searchAction()
    {
        parent::importarJsSearch();

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
            $this->flash->notice("No se han encontrado resultados.");

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "index"
            ));
        }
        $tabla = array();
        foreach ($orden as $unaOrden) {

        }
        $paginator = new Paginator(array(
            "data" => $orden,
            "limit" => 100000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->newOrdenForm = new NewOrdenForm();
        $this->view->clienteForm = new ClienteForm();
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
                $this->flash->error("La orden no se encontró");

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
            $this->tag->setDefault("orden_habilitado", $orden->getOrdenHabilitado());

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
        //Buscar la ultima orden habilitada de la planilla
        $ultimaOrden = Orden::findFirst(array(
            "orden_ultima = 1 AND orden_habilitado=1 AND orden_planillaId = :orden_planillaId:",
            'bind'=>array('orden_planillaId'=>$this->request->getPost("orden_planillaId"))
        ));
        if (!$ultimaOrden) {
            $orden->setOrdenNro(1);
            $orden->setOrdenUltima(1);
        }
        else {
            $orden->setOrdenNro($ultimaOrden->getOrdenNro() + 1);
            $orden->setOrdenUltima(1);
            $ultimaOrden->setOrdenUltima(0);
            $ultimaOrden->update();
        }
        $orden->setOrdenPlanillaId($this->request->getPost("orden_planillaId"));
        $orden->setOrdenPeriodo($this->request->getPost("orden_periodo"));
        $orden->setOrdenFecha($this->request->getPost("orden_fecha"));

        $orden->setOrdenTransporteId($this->request->getPost("orden_transporteId"));
        $orden->setOrdenTipoEquipoId($this->request->getPost("orden_tipoEquipoId"));
        $orden->setOrdenTipoCargaId($this->request->getPost("orden_tipoCargaId"));
        $orden->setOrdenChoferId($this->request->getPost("orden_choferId"));
        /*Busco los nombre de los clientes, */

        $orden->setOrdenClienteId($this->request->getPost("cliente_id"));
        $orden->setOrdenFrsId($this->request->getPost("frs_id"));
        $orden->setOrdenCentroCostoId($this->request->getPost("centroCosto_id"));
        $orden->setOrdenEquipoPozoId($this->request->getPost("equipoPozo_id"));


        $orden->setOrdenViajeId($this->request->getPost("orden_viajeId"));
        $orden->setOrdenConcatenadoId($this->request->getPost("orden_concatenadoId"));

        $tarifa = new Tarifa();
        $tarifa->setTarifaHoraInicial($this->request->getPost("tarifa_horaInicial"));
        $tarifa->setTarifaHoraFinal($this->request->getPost("tarifa_horaFinal"));
        $tarifa->setTarifaHsServicio($this->request->getPost("tarifa_hsServicio"));
        $tarifa->setTarifaHsHidro($this->request->getPost("tarifa_hsHidro"));
        $tarifa->setTarifaHsMalacate($this->request->getPost("tarifa_hsMalacate"));
        $tarifa->setTarifaHsStand($this->request->getPost("tarifa_hsStand"));
        $tarifa->setTarifaKm($this->request->getPost("tarifa_km"));
        if (!$tarifa->save()) {
            foreach ($tarifa->getMessages() as $mensaje) {
                $this->flash->error($mensaje);
            }
            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "index"
            ));
        }
        $orden->setOrdenTarifaId($tarifa->getTarifaId());

        $orden->setOrdenObservacion($this->request->getPost("orden_observacion"));
        $orden->setOrdenConformidad($this->request->getPost("orden_conformidad"));
        $orden->setOrdenNoconformidad($this->request->getPost("orden_noConformidad"));

        $orden->setOrdenFechacreacion(date('Y-m-d'));
        $orden->setOrdenCreadoPor($this->session->get('auth')['usuario_nick']);
        $orden->setOrdenHabilitado(1);

            if (!$orden->save()) {
            //FIXME: ROLLBACK!! para que ultimaOrden vuelva a estar como antes.
                foreach ($orden->getMessages() as $message) {
                    $this->flash->error('HUBO UN PROBLEMA AL GENERAR LA ORDEN. <br> <ins>Detalles:</ins><br>' . $message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "orden",
                    "action" => "new"
                ));
            }

        $this->flash->success("La orden se creó correctamente");

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
            $this->flash->error("La orden no existe ID: " . $orden_id);

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
        $orden->setOrdenHabilitado($this->request->getPost("orden_habilitado"));


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

        $this->flash->success("La orden se actualizó correctamente");

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
            $this->flash->error("La orden no se encontró");

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

        $this->flash->success("La orden se eliminó correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "orden",
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
            $orden = Orden::findFirstByOrden_id($id);
            if (!$orden) {
                $this->flash->error("La Orden no ha sido encontrada");

                return $this->dispatcher->forward(array(
                    "controller" => "orden",
                    "action" => "index"
                ));
            }
            $orden->orden_habilitado = 0;
            if (!$orden->update()) {

                foreach ($orden->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "orden",
                    "action" => "search"
                ));
            }

            $this->flash->success("La Orden ha sido eliminada correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "orden",
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
        $orden = Orden::findFirstByOrden_id($id);
        $orden->orden_habilitado = 1;
        if (!$orden->update()) {

            foreach ($orden->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "orden",
                "action" => "search"
            ));
        }

        $this->flash->success("La Orden ha sido habilitada");

        return $this->dispatcher->forward(array(
            "controller" => "orden",
            "action" => "search"
        ));
    }
}
