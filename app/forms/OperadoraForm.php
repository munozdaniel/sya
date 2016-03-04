<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 04/03/2016
 * Time: 05:51 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use \Phalcon\Forms\Element\Hidden;
class OperadoraForm extends Form
{

    /**
     * Inicializar Formulario EquipoPozo.
     */
    public function initialize($entity = null, $options = array())
    {

        /*======================== ID =========================*/
        if (!isset($options['edit'])) {
            $equipoPozo_id = new Text("operadora_id");
            $this->add($equipoPozo_id->setLabel("N° de Operadora"));
        } else {
            $this->add(new Hidden("operadora_id"));
        }
        /*======================== NOMBRE =========================*/

        $elemento = new Text("operadora_nombre", array(
            'maxlength' => 50,
            'placeholder' => 'NOMBRE',
            'required'=>'',
            'class'=>'form-control'
        ));
        $elemento->setLabel("Nombre Operadora");
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'El Nombre es Requerido'
            ))
        ));
        $this->add($elemento);
        /*======================== YACIMIENTO =========================*/
        //yacimiento_id - yacimiento_destino
        $listaYacimiento = new DataListElement('operadora_yacimiento',
            array(array('placeholder' => 'DESTINO', 'maxlength' => 50,'class'=>'form-control'),
                Yacimiento::find(),
                array('yacimiento_id', 'yacimiento_destino'),'operadora_yacimientoId'
            ));
        $listaYacimiento->setLabel('Yacimiento');
        $this->add($listaYacimiento);


    }

}