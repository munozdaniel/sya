<?php
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;

/**
 * Created by PhpStorm.
 * User: dmunioz
 * Date: 14/04/2016
 * Time: 14:32
 */
class YacimientoForm extends \Phalcon\Forms\Form
{
    public function initialize($entity = null, $options = array())
    {
        /*Si el form es de creacion, los campos seran required. Viceversa.*/
        $required['clave'] = "";
        $required['valor'] = "";

        if (isset($options['required'])) {
            $required['clave'] = "required";
            $required['valor'] = "true";
        }
        /*=========================== ID =====================================*/
        if (!isset($options['edit'])) {
            $element = new Text("yacimiento_id");
            $this->add($element->setLabel("ID"));
        } else {
            $this->add(new Hidden("yacimiento_id"));
        }
        /*=========================== Destino =====================================*/
        $elemento = new Text('yacimiento_destino',array('maxlength'=>60,'class'=>'form-control',$required['clave']=>$required['valor']));
        $elemento->setLabel('Destino');
        $elemento->setFilters(array('striptags', 'string'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El destino es requerido'
            ))
        ));
        $this->add($elemento);
        /*=========================== Operadoras =====================================*/
        $elemento = new Select('operadora_yacimientoId',
            Operadora::find(array('operadora_habilitado=1 AND operadora_yacimientoId=NULL','order'=>'operadora_nombre')),
            array(
                'using' => array('operadora_id', 'operadora_nombre'),
                'useEmpty' => true,
                'emptyText' => 'SELECCIONE LAS OPERADORAS',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'multiple' => 'multiple',
                $required['clave']=>$required['valor']
            )
        );
        $elemento->setLabel('Operadoras');
        $this->add($elemento);
        /*=========================== EquipoPozo =====================================*/
        $elemento = new Select('equipoPozo_yacimientoId',
            Equipopozo::find(array('equipoPozo_habilitado=1 AND equipoPozo_yacimientoId=NULL','order'=>'equipoPozo_nombre')),
            array(
                'using' => array('equipoPozo_id', 'equipoPozo_nombre'),
                'useEmpty' => true,
                'emptyText' => 'SELECCIONE LOS EQUIPOS/POZOS',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                'multiple' => 'multiple',
                $required['clave']=>$required['valor']
            )
        );
        $elemento->setLabel('Equipos/Pozos');
        $this->add($elemento);
    }

}