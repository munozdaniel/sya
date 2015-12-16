<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TransporteController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Transporte');
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
     * Searches for transporte
     */
    public function searchAction()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/dataTables.bootstrap.css');
        $this->assets->collection('footer')
            ->addJs('plugins/datatables/jquery.dataTables.min.js')
            ->addJs('plugins/datatables/dataTables.bootstrap.min.js');
        $this->assets->collection('footerInline')
            ->addInlineJs('
            $(function () {
            $("#tabla_id").DataTable();
            });')
            ->addInlineJs('
            $(document).on("click", ".enviar-dato", function () {
                var id = $(this).data("id");
                $("#cuerpo #id").val( id );
            });
        ');
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Transporte", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "transporte_id";

        $transporte = Transporte::find($parameters);
        if (count($transporte) == 0) {
            $this->flash->notice("No se encontraron resultados");

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $transporte,
            "limit" => 10,
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
     * Edits a transporte
     * @param string $transporte_id
     * @return bool
     */
    public function editAction($transporte_id)
    {

        if (!$this->request->isPost()) {

            $transporte = Transporte::findFirstBytransporte_id($transporte_id);
            if (!$transporte) {
                $this->flash->error("El transporte no fue encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "transporte",
                    "action" => "index"
                ));
            }

            $this->view->transporte_id = $transporte->transporte_id;

            $this->tag->setDefault("transporte_id", $transporte->getTransporteId());
            $this->tag->setDefault("transporte_dominio", $transporte->getTransporteDominio());
            $this->tag->setDefault("transporte_nroInterno", $transporte->getTransporteNrointerno());
            $this->tag->setDefault("transporte_habilitado", $transporte->getTransporteHabilitado());

        }
    }

    /**
     * Creates a new transporte
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $transporte = new Transporte();

        $transporte->setTransporteDominio($this->request->getPost("transporte_dominio"));
        $transporte->setTransporteNrointerno($this->request->getPost("transporte_nroInterno"));
        $transporte->setTransporteHabilitado($this->request->getPost("transporte_habilitado"));


        if (!$transporte->save()) {
            foreach ($transporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "new"
            ));
        }

        $this->flash->success("El transporte ha sido creado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "transporte",
            "action" => "index"
        ));

    }

    /**
     * Saves a transporte edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $transporte_id = $this->request->getPost("transporte_id");

        $transporte = Transporte::findFirstBytransporte_id($transporte_id);
        if (!$transporte) {
            $this->flash->error("El Transporte N° " . $transporte_id . "no existe");

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "index"
            ));
        }

        $transporte->setTransporteDominio($this->request->getPost("transporte_dominio"));
        $transporte->setTransporteNrointerno($this->request->getPost("transporte_nroInterno"));
        $transporte->setTransporteHabilitado(1);


        if (!$transporte->save()) {

            foreach ($transporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "edit",
                "params" => array($transporte->transporte_id)
            ));
        }

        $this->flash->success("El transporte ha sido actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "transporte",
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
            $transporte = Transporte::findFirstBytransporte_id($id);
            if (!$transporte) {
                $this->flash->error("El transporte no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "transporte",
                    "action" => "index"
                ));
            }
            $transporte->transporte_habilitado = 0;
            if (!$transporte->update()) {

                foreach ($transporte->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "transporte",
                    "action" => "search"
                ));
            }

            $this->flash->success("El transporte ha sido eliminado correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "search"
            ));
        }
    }

    /**
     * Habilitar un transporte.
     * @param $idTransporte
     * @return bool
     */
    public function habilitarAction($idTransporte)
    {
        $transporte = Transporte::findFirstByTransporte_id($idTransporte);
        $transporte->transporte_habilitado = 1;
        if (!$transporte->update()) {

            foreach ($transporte->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "transporte",
                "action" => "search"
            ));
        }

        $this->flash->success("El transporte ha sido habilitado");

        return $this->dispatcher->forward(array(
            "controller" => "transporte",
            "action" => "search"
        ));
    }

}
