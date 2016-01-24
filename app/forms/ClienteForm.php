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
class ClienteForm  extends \Phalcon\Forms\Form
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
                null,
                array('operadora_id', 'operadora_nombre'),
                'operadora_id'
            ));
        $listaOperadoras->setLabel('Operadora');
        $this->add($listaOperadoras);
        //Script Para unir el Cliente y sus Operadoras.
        $script = new DataListScript('cliente_operadoraScript',
            array(
                'url'               =>'/sya/operadora/buscarOperadoras',
                'id_principal'      =>'cliente_nombre',
                'id_hidden_ppal'    =>'cliente_id',
                'id_dependiente'    =>'operadora_nombre',
                'columnas'          =>  array('operadora_id','operadora_nombre')
            )
        );
        $script->setLabel(" ");
        $this->add($script);
        /*======================= CLIENTE_FRS ==============================*/

        //Primero El PRINCIPAL.
        $dl_frs = new DataListElement('frs_codigo',
            array(
                array('placeholder' => 'CODIGO', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                NULL,
                array('frs_id', 'frs_codigo'),
                'frs_id'
            ));
        $dl_frs->setLabel('FRS');
        $this->add($dl_frs);
        //Script Para unir a la Operadora y sus FRS.
        $script = new DataListScript('operadora_frsScript',
            array(
                'url'               =>'/sya/frs/buscarFrs',
                'id_principal'      =>'operadora_nombre',
                'id_hidden_ppal'    =>'operadora_id',
                'id_dependiente'    =>'frs_codigo',
                'columnas'          =>  array('frs_id','frs_codigo')
            )
        );
        $script->setLabel(" ");
        $this->add($script);
        /*======================= CLIENTE - EQUIPO/POZO - YACIMIENTO ==============================*/
        //Primero El PRINCIPAL.
        $listaYacimiento = new DataListElement('yacimiento_destino',
            array(
                array('placeholder' => 'SELECCIONAR', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                null,
                array('yacimiento_id', 'yacimiento_destino'),
                'yacimiento_id'
            ));
        $listaYacimiento->setLabel('Yacimiento');
        $this->add($listaYacimiento);
        //Script Para unir a la Operadora y sus Yacimientos.
        $script = new DataListScript('operadora_yacimientoScript',
            array(
                'url'               =>'/sya/yacimiento/buscarYacimientos',
                'id_principal'      =>'operadora_nombre',
                'id_hidden_ppal'    =>'operadora_id',
                'id_dependiente'    =>'yacimiento_destino',
                'columnas'          =>  array('yacimiento_id','yacimiento_destino')
            )
        );
        $script->setLabel(" ");
        $this->add($script);

        /*=================================================*/
        $listaEquipoPozo = new DataListElement('equipoPozo_nombre',
            array(
                array('placeholder' => 'SELECCIONE UN YACIMENTO', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                null,
                array('equipoPozo_id', 'equipoPozo_nombre'),
                'equipoPozo_id'
            ));
        $listaEquipoPozo->setLabel('Equipo/Pozo');
        $this->add($listaEquipoPozo);
        //Script Para unir el YAcimiento y sus EquipoPozo.
        $script = new DataListScript('yacimiento_EPScript',
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


        /*======================== CLIENTE - CENTRO COSTO - LINEA =========================*/
        //DataList Dependientes: Linea
        $listaLinea = new DataListElement('linea_nombre',
            array(
                array('placeholder' => 'SELECCIONAR', 'maxlength' => 50, 'class'=>'form-control'),
                NULL,
                array('linea_id', 'linea_nombre'),
                'linea_id'
            ));
        $listaLinea->setLabel('Linea');
        $this->add($listaLinea);
        //UnionElementScript
        $script = new DataListScript('cliente_lineaScript',
            array(
                'url'               =>'/sya/linea/buscarLineas',
                'id_principal'      =>'cliente_nombre',
                'id_hidden_ppal'    =>'cliente_id',
                'id_dependiente'    =>'linea_nombre',
                'columnas'          =>  array('linea_id','linea_nombre')
            )
        );
        $script->setLabel(" ");
        $this->add($script);


        /*=================================================*/
        $listaCentroCosto = new DataListElement('centroCosto_codigo',
            array(
                array('placeholder' => 'SELECCIONE UNA LINEA', 'maxlength' => 50, 'class'=>'form-control',$required['clave']=>$required['valor']),
                null,
                array('centroCosto_id', 'centroCosto_codigo'),
                'centroCosto_id'
            ));
        $listaCentroCosto->setLabel('Centro Costo');
        $this->add($listaCentroCosto);
        //UnionElementScript
        $script = new DataListScript('centroCosto_lineaScript',
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

    }

}