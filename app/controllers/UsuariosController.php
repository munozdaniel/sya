<?php

/**
 * Class UsuariosController
 * Encargado de gestionar los usuarios que van a utilizar el sistema.
 */
class UsuariosController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Perfil del Usuario');
        $this->assets->collection('header')->addJs('js/application_blank.js');
        parent::initialize();

    }
    /**
     * Muestra el perfil del usuario logueado.
     */
    public function indexAction()
    {

    }


}

