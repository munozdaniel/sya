<?php

/**
 * Class DashboardController Muestra el tablero principal en donde se visualizarán las tareas principales del sistema
 */
class DashboardController  extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Tablero Principal');
        $this->assets->collection('header')->addJs('js/application.js');
        parent::initialize();

    }
    public function indexAction()
    {

    }

}

