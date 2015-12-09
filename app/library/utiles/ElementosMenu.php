<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 27/11/2015
 * Time: 01:55 PM
 * Class ElementosMenu
 * Encargado de armar los diferentes menu de manera dinamica, segun los estados en el que se encuentre el usuario.
 */

class ElementosMenu extends \Phalcon\Mvc\User\Component
{
    private $_menuUsuario = array(
        'usuario'=>array(
            'imagen'=>'http://placehold.it/500',
            'nombre'=>'ANONIMO'
        ),
        'submenu'=>array(
            'perfil'=>array(
                'icono'=>'fa fa-user',
                'leyenda'=>'Perfil',
                'url'=>'usuarios/index'
            ),
            'config'=>array(
                'icono'=>'fa fa-cog',
                'leyenda'=>'Configurar',
                'url'=>'sesion/configurar'
            ),
            'sesion'=>array(
                'icono'=>'fa fa-mail-forward',
                'leyenda'=>'Salir',
                'url'=>'sesion/cerrar'
            ),
        )
    );
    private $_menuNotificaciones = array();
    private $_menuLateral = array();

    public function getUsuario()
    {

        $auth = $this->session->get('auth');
        echo '<ul class="nav navbar-nav navbar-left-custom">';
                echo '<li class="user dropdown">';
                    echo '<a class="dropdown-toggle" data-toggle="dropdown">';
        $img = ($this->session->get('auth')['usuario_imagen']==null)?'http://placehold.it/500':$this->session->get('auth')['usuario_imagen'];
                       echo ''. $this->tag->image($img);
                        echo '<span>'.$this->session->get('auth')['usuario_nick'].'</span>';
                        echo '<i class="caret"></i>';
                    echo '</a>';
                    echo '<ul class="dropdown-menu">';
                        foreach($this->_menuUsuario['submenu'] as $clave => $item){
                            echo '<li>';
                            echo $this->tag->linkTo($item['url'], '<i class="'.$item['icono'].'"></i>'. $item['leyenda']);
                            echo '</li>';

                        }
                    echo '</ul>';
                echo '</li>';
                echo '<li><a class="nav-icon sidebar-toggle"><i class="fa fa-bars"></i> Ver/Ocultar </a></li>';
        echo '</ul>';
    }
}