<?php

/**
 * Class IndexController
 * Inicio del sistema, donde se solicitan los datos para ingresar. Se encarga de validar y chequear los permisos.
 * Permite recuperar los datos, en caso que se hayan olvidado, se les envia un correo con dichos datos recuperados desde
 * la base de datos.
 */
class IndexController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

    }

    /**
     * Inicio de Sesion: Solicita usuario y contraseña.
     */
    public function indexAction()
    {
        $this->tag->setTitle('Iniciar Sesión');
        $this->assets->collection('header')->addJs('js/application_blank.js');
    }


    /**
     * Tablero Principal, donde se mostraran las operaciones primordiales del sistema.
     */
    public function dashboardAction()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Tablero Principal');
        $this->assets->collection('header')->addJs('js/application.js');
        parent::initialize();


    }
}

