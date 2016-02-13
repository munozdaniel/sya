<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 24/01/2016
 * Time: 09:25 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Forms\Element\Hidden;use Phalcon\Forms\Element\Check;
class ClienteForm extends \Phalcon\Forms\Form
{

    /**
     * Initialize the cliente form
     */
    public function initialize($entity = null, $options = array())
    {
        $required['clave']="";
        $required['valor']="";

        if(isset($options['required']))
        {
            $required['clave']="required";
            $required['valor']="true";
        }
        /*======================= ID ==============================*/
        if (!isset($options['edit'])) {
            $element = new Text("cliente_id");
            $this->add($element->setLabel("N° de Cliente"));
        } else {
            $this->add(new Hidden("cliente_id"));
        }
        /*======================= CLIENTE_NOMBRE ==============================*/
        //Primero El PRINCIPAL.
        $nombre = new DataListElement('cliente_nombre',
            array(
                array('placeholder' => 'SELECCIONE EL CLIENTE',$required['clave']=>$required['valor'], 'class'=>'form-control', 'maxlength' => 60),
                Cliente::find(array('cliente_habilitado=1','order'=>'cliente_nombre')),
                array('cliente_id', 'cliente_nombre'),
                'cliente_id'
            ));
        $nombre->setLabel('Nombre');
        $this->add($nombre);

        /*======================= CLIENTE_OPERADORA ==============================*/
        //Todas Las Operadoras Dependientes:
        $listaOperadoras = new DataListElement('operadora_nombre',
            array(
                array('placeholder' => 'SELECCIONE LA OPERADORA', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                Operadora::find(array('operadora_habilitado=1','order'=>'operadora_nombre')),
                array('operadora_id', 'operadora_nombre'),
                'operadora_id'
            ));
        $listaOperadoras->setLabel('Operadora');
        $this->add($listaOperadoras);

        /*======================= CLIENTE - EQUIPO/POZO - YACIMIENTO ==============================*/
        //Primero El PRINCIPAL.
        $listaYacimiento = new DataListElement('yacimiento_destino',
            array(
                array('placeholder' => 'SELECCIONAR', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                Yacimiento::find(array('yacimiento_habilitado=1','order'=>'yacimiento_destino')),
                array('yacimiento_id', 'yacimiento_destino'),
                'yacimiento_id'
            ));
        $listaYacimiento->setLabel('Yacimiento');
        $this->add($listaYacimiento);

        /*=================================================*/
        $listaEquipoPozo = new DataListElement('equipoPozo_nombre',
            array(
                array('placeholder' => 'SELECCIONE UN YACIMENTO', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                Equipopozo::find(array('equipoPozo_habilitado=1','order'=>'equipoPozo_nombre')),
                array('equipoPozo_id', 'equipoPozo_nombre'),
                'equipoPozo_id'
            ));
        $listaEquipoPozo->setLabel('Equipo/Pozo');
        $this->add($listaEquipoPozo);

        /*======================== CLIENTE - CENTRO COSTO - LINEA =========================*/
        //DataList Dependientes: Linea
        $listaLinea = new DataListElement('linea_nombre',
            array(
                array('placeholder' => 'SELECCIONAR', 'maxlength' => 50, 'class'=>'form-control'),
                Linea::find(array('linea_habilitado=1','order'=>'linea_nombre')),
                array('linea_id', 'linea_nombre'),
                'linea_id'
            ));
        $listaLinea->setLabel('Linea');
        $this->add($listaLinea);


        /*=================================================*/
        $listaCentroCosto = new DataListElement('centroCosto_codigo',
            array(
                array('placeholder' => 'SELECCIONE UNA LINEA', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                Centrocosto::find(array('centroCosto_habilitado=1','order'=>'centroCosto_codigo')),
                array('centroCosto_id', 'centroCosto_codigo'),
                'centroCosto_id'
            ));
        $listaCentroCosto->setLabel('Centro Costo');
        $this->add($listaCentroCosto);


    }

}