<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 19/12/2015
 * Time: 05:20 PM
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Forms\Element\Hidden;use Phalcon\Forms\Element\Check;
class ClienteNewForm  extends \Phalcon\Forms\Form
{

    /**
     * Initialize the cliente form
     * cliente_id
     * cliente_nombre
     * linea_nombre
     * script_cliente_linea
     * centroCosto_codigo
     * script_linea_cc
     * yacimiento_destino
     * script_yacimiento_ep
     * operadora_nombre
     * script_yacimiento_operadoras
     * equipoPozo_nombre
     * script_yacimiento_ep
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
        /*======================= Obtener todos los Clientes ==============================*/

        $elemento = new DataListElement('cliente_nombre',
            array(
                array('placeholder' => 'SELECCIONE EL CLIENTE',$required['clave']=>$required['valor'], 'class'=>'form-control', 'maxlength' => 60),
                Cliente::find(array('cliente_habilitado=1','order'=>'cliente_nombre')),
                array('cliente_id', 'cliente_nombre'),
                'cliente_id'
            ));
        $elemento->setLabel('Nombre');
        $this->add($elemento);

        /*======================= Obtener todos las Lineas por Cliente ==============================*/

        $listaLinea = new DataListElement('linea_nombre',
            array(
                array('placeholder' => 'SELECCIONAR', 'maxlength' => 50, 'class'=>'form-control'),
                NULL,
                array('linea_id', 'linea_nombre'),
                'linea_id'
            ));
        $listaLinea->setLabel('Linea');
        $this->add($listaLinea);

        /********************** Script Para unir el Cliente y sus Lineas. *********************/

        $script = new DataListScript('script_cliente_linea',
            array(
                'url'               =>'/sya/linea/buscarLineas',
                'id_principal'      =>'cliente_nombre',
                'id_hidden_ppal'    =>'cliente_id',
                'id_dependiente'    =>'linea_nombre',
                'columnas'          =>  array('linea_id','linea_nombre')
            )
        );
        $script->setLabel("Script Cliente Linea");
        $this->add($script);
        /*======================= Obtener todos los CC por Linea ==============================*/
        $listaCentroCosto = new DataListElement('centroCosto_codigo',
            array(
                array('placeholder' => 'SELECCIONE UNA LINEA', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                null,
                array('centroCosto_id', 'centroCosto_codigo'),
                'centroCosto_id'
            ));
        $listaCentroCosto->setLabel('Centro Costo');
        $this->add($listaCentroCosto);
        /********************** Script Para unir la Linea y sus CC. *********************/
        $script = new DataListScript('script_linea_cc',
            array(
                'url'               =>'/sya/centrocosto/buscarCentroCosto',
                'id_principal'      =>'linea_nombre',
                'id_hidden_ppal'    =>'linea_id',
                'id_dependiente'    =>'centroCosto_codigo',
                'columnas'          =>  array('centroCosto_id','centroCosto_codigo')
            )
        );
        $script->setLabel(" ");
        $this->add($script);
        /*======================= Obtener todos los Yacimientos==============================*/
        $elemento = new DataListElement('yacimiento_destino',
            array(
                array('placeholder' => 'SELECCIONAR', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                Yacimiento::find(array('yacimiento_habilitado=1','order'=>'yacimiento_destino')),
                array('yacimiento_id', 'yacimiento_destino'),
                'yacimiento_id'
            ));
        $elemento->setLabel('Yacimiento');
        $this->add($elemento);
        /*======================= Obtener todos las Operadoras por Yacimiento ==============================*/
        $listaOperadoras = new DataListElement('operadora_nombre',
            array(
                array('placeholder' => 'SELECCIONE LA OPERADORA', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                null,
                array('operadora_id', 'operadora_nombre'),
                'operadora_id'
            ));
        $listaOperadoras->setLabel('Operadora');
        $this->add($listaOperadoras);
        /********************** Script Para unir el Yacimiento y sus Operadoras. *********************/
        $script = new DataListScript('script_yacimiento_operadoras',
            array(
                'url'               =>'/sya/operadora/buscarOperadoras',
                'id_principal'      =>'yacimiento_destino',
                'id_hidden_ppal'    =>'yacimiento_id',
                'id_dependiente'    =>'operadora_nombre',
                'columnas'          =>  array('operadora_id','operadora_nombre')
            )
        );
        $script->setLabel(" ");
        $this->add($script);
        /*======================= Obtener todos los EP por Yacimiento ==============================*/
        $listaEquipoPozo = new DataListElement('equipoPozo_nombre',
            array(
                array('placeholder' => 'SELECCIONE UN YACIMENTO', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                null,
                array('equipoPozo_id', 'equipoPozo_nombre'),
                'equipoPozo_id'
            ));
        $listaEquipoPozo->setLabel('Equipo/Pozo');
        $this->add($listaEquipoPozo);
        /********************** Script Para unir el Yacimiento y sus EP. *********************/
        $script = new DataListScript('script_yacimiento_ep',
            array(
                'url'               =>'/sya/equipopozo/buscarEquipoPozo',
                'id_principal'      =>'yacimiento_destino',
                'id_hidden_ppal'    =>'yacimiento_id',
                'id_dependiente'    =>'equipoPozo_nombre',
                'columnas'          =>  array('equipoPozo_id','equipoPozo_nombre')
            )
        );
        $script->setLabel(" ");
        $this->add($script);

    }

}