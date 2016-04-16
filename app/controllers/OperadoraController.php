<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class OperadoraController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Operadora');
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
        parent::importarSelect2();
        /*=========================== Operadoras =====================================*/
        $this->view->operadoras = new \Phalcon\Forms\Element\Select('operadora_yacimientoId',
            Yacimiento::find(array('yacimiento_habilitado=1', 'order' => 'yacimiento_destino')),
            array(
                'using' => array('yacimiento_id', 'yacimiento_destino'),
                'useEmpty' => true,
                'emptyText' => 'SELECCIONE LAS OPERADORAS',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
            )
        );
    }

    /**
     * Searches for operadora
     */
    public function searchAction($yacimientoId = null)
    {
        parent::importarJsTable();

        $numberPage = 1;
        if ($yacimientoId != null) {
            $operadora = Operadora::find(array('operadora_yacimientoId=:yacimiento_id:', 'bind' => array('yacimiento_id' => $yacimientoId)));
        } else {
            if ($this->request->isPost()) {
                $query = Criteria::fromInput($this->di, "Operadora", $_POST);
                $this->persistent->parameters = $query->getParams();
            } else {
                $numberPage = $this->request->getQuery("page", "int");
            }

            $parameters = $this->persistent->parameters;
            if (!is_array($parameters)) {
                $parameters = array();
            }
            $parameters["order"] = "operadora_id";
            $operadora = Operadora::find($parameters);
        }

        if (count($operadora) == 0) {
            $this->flash->notice("No se han encontrado resultados");

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $operadora,
            "limit" => 25,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

        $this->view->operadoraForm = new OperadoraForm(null, array('edit' => true));


    }

    /**
     * Edits a operadora
     *
     * @param string $operadora_id
     */
    public function editAction($operadora_id)
    {

        if (!$this->request->isPost()) {

            $operadora = Operadora::findFirstByoperadora_id($operadora_id);
            if (!$operadora) {
                $this->flash->error("La Operadora no se encontró");

                return $this->dispatcher->forward(array(
                    "controller" => "operadora",
                    "action" => "index"
                ));
            }

            $this->view->operadora_id = $operadora->operadora_id;

            $this->tag->setDefault("operadora_id", $operadora->getOperadoraId());
            $this->tag->setDefault("operadora_nombre", $operadora->getOperadoraNombre());
            $this->view->operadoraForm = new OperadoraForm($operadora, array('edit' => true));
            $this->view->operadora_id = $operadora->getOperadoraId();

            //Default Yacimiento
            $yacimiento = Yacimiento::findFirstByYacimiento_id($operadora->getOperadoraYacimientoId());
            if ($yacimiento) {
                $destino = $yacimiento->yacimiento_destino;
                $this->assets->collection('footerInline')->addInlineJs("
                                            function cargarCombo() {
                                                document.getElementById('operadora_yacimiento').value='$destino';
                                            }
                                            window.onload = cargarCombo;
                                        ");
            }

        }
    }

    /**
     * Creates a new operadora
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $operadora = new Operadora();

        $operadora->setOperadoraNombre($this->request->getPost("operadora_nombre"));
        $operadora->setOperadoraYacimientoId($this->request->getPost('operadora_yacimientoId'));
        $operadora->setOperadoraHabilitado(1);


        if (!$operadora->save()) {
            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "new"
            ));
        }

        $this->flash->success("La Operadora ha sido creada correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
            "action" => "index"
        ));

    }


    public function agregarOperadoraAlYacimientoAction()
    {
        $this->view->disable();
        $retorno = array();
        $retorno['success'] = false;
        $retorno['mensaje'] = " - ";
        if (!$this->request->isAjax()) {
            return $this->dispatcher->forward(array(
                "controller" => "yacimiento",
                "action" => "index"
            ));
        }

        $operadora = new Operadora();

        $operadora->setOperadoraNombre($this->request->getPost("operadora_nombre"));
        $operadora->setOperadoraYacimientoId($this->request->getPost("operadora_yacimientoId"));
        $operadora->setOperadoraHabilitado(1);


        if (!$operadora->save()) {
            $mensaje = "No se pudo guardar";
            foreach ($operadora->getMessages() as $message) {
                $mensaje = $message . "<br>";
            }
            $retorno['mensaje'] = $mensaje;
            echo json_encode($retorno);
            return;
        }

        $retorno['mensaje'] = "La operadora ha sido agregada correctamente";
        $retorno['success'] = true;
        echo json_encode($retorno);
        return;
    }

    /**
     * Saves a operadora edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $operadora_id = $this->request->getPost("operadora_id");

        $operadora = Operadora::findFirstByoperadora_id($operadora_id);
        if (!$operadora) {
            $this->flash->error("La operadora NO existe ");

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        $operadora->setOperadoraNombre($this->request->getPost("operadora_nombre"));
        $operadora->setOperadoraYacimientoId($this->request->getPost("operadora_yacimientoId"));


        if (!$operadora->save()) {

            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "edit",
                "params" => array($operadora->operadora_id)
            ));
        }

        $this->flash->success("La Operadora se ha actualizado correctamente");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
            "action" => "index"
        ));

    }

    /**
     * Deletes a operadora
     *
     * @param string $operadora_id
     */
    public function deleteAction($operadora_id)
    {

        $operadora = Operadora::findFirstByoperadora_id($operadora_id);
        if (!$operadora) {
            $this->flash->error("La Operadora no se encontró");

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "index"
            ));
        }

        if (!$operadora->delete()) {

            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "search"
            ));
        }

        $this->flash->success("La Operadora ha sido eliminada correctamente.");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
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
            $operadora = Operadora::findFirstByOperadora_id($id);
            if (!$operadora) {
                $this->flash->error("La Operadora no ha sido encontrada");

                return $this->dispatcher->forward(array(
                    "controller" => "operadora",
                    "action" => "index"
                ));
            }
            $operadora->operadora_habilitado = 0;
            if (!$operadora->update()) {

                foreach ($operadora->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "operadora",
                    "action" => "search"
                ));
            }

            $this->flash->success("La Operadora ha sido eliminada correctamente");

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
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
        $operadora = Operadora::findFirstByOperadora_id($id);
        $operadora->operadora_habilitado = 1;
        if (!$operadora->update()) {

            foreach ($operadora->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "operadora",
                "action" => "search"
            ));
        }

        $this->flash->success("La Operadora ha sido habilitada");

        return $this->dispatcher->forward(array(
            "controller" => "operadora",
            "action" => "search"
        ));
    }

    public function buscarOperadorasAction()
    {
        $this->view->disable();
        if ($this->request->isPost()) {
            if ($this->request->isAjax()) {
                $id = $this->request->getPost("id", "int");

                $lista = Operadora::find(array(
                    "operadora_yacimientoId = :id: AND operadora_habilitado=1", 'bind' => array('id' => $id)
                ));
                $resData = array();

                foreach ($lista as $item) {
                    $resData[] = array("operadora_id" => $item->getOperadoraId(), "operadora_nombre" => $item->getOperadoraNombre());
                }
                if (count($lista) > 0) {
                    $this->response->setJsonContent(array("lista" => $resData));
                    $this->response->setStatusCode(200, "OK");
                } else {
                    $this->response->setJsonContent(array("lista" => null));

                }
                $this->response->send();
            }
        }
    }
}
