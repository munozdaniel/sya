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
            'placeholder' => 'NOMBRE',
        ));
        $equipoPozo_nombre->setLabel("Nombre Equipo/Pozo");
        $equipoPozo_nombre->setFilters(array('striptags', 'string'));
        $equipoPozo_nombre->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'El Nombre es Requerido'
            ))
        ));
        $this->add($equipoPozo_nombre);
        /*======================== YACIMIENTO =========================*/
        //yacimiento_id - yacimiento_destino
        $listaYacimiento = new DataListElement('equipoPozo_yacimiento',
            array(array('placeholder' => 'DESTINO', 'maxlength' => 50),
                Yacimiento::find(),
                array('yacimiento_id', 'yacimiento_destino'),'equipoPozo_yacimientoId'
            ));
        $listaYacimiento->setLabel('Yacimiento');
        $this->add($listaYacimiento);


    }
}