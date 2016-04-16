<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 24/12/2015
 * Time: 11:30 AM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use \Phalcon\Forms\Element\Hidden;

class EquipoPozoForm extends Form
{

    /**
     * Inicializar Formulario EquipoPozo.
     */
    public function initialize($entity = null, $options = array())
    {

        /*======================== ID =========================*/
        if (!isset($options['edit'])) {
            $equipoPozo_id = new Text("equipoPozo_id");
            $this->add($equipoPozo_id->setLabel("N° de Equipo/Pozo"));
        } else {
            $this->add(new Hidden("equipoPozo_id"));
        }
        /*======================== NOMBRE =========================*/

        $equipoPozo_nombre = new Text("equipoPozo_nombre", array(
            'maxlength' => 50,
            'placeholder' => 'NOMBRE','required'=>'true'
        ));
        $equipoPozo_nombre->setLabel("Nombre Equipo/Pozo");
        $equipoPozo_nombre->setFilters(array('striptags', 'string'));
        $equipoPozo_nombre->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'El Nombre es Requerido'
            ))
        ));
        $this->add($equipoPozo_nombre);

        $operadoras = new \Phalcon\Forms\Element\Select('equipoPozo_yacimientoId',
            Yacimiento::find(array('yacimiento_habilitado=1', 'order' => 'yacimiento_destino')),
            array(
                'using' => array('yacimiento_id', 'yacimiento_destino'),
                'useEmpty' => true,
                'emptyText' => 'SELECCIONE EL YACIMIENTO',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%'
            )
        );        $this->add($operadoras);


    }
}