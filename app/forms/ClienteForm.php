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
        /*======================= ID ==============================*/
        if (!isset($options['edit'])) {
            $element = new Text("cliente_id");
            $this->add($element->setLabel("N° de Cliente"));
        } else {
            $this->add(new Hidden("cliente_id"));
        }
        /*======================= CLIENTE_NOMBRE ==============================*/
        $nombre = new Text("cliente_nombre",array(
            'maxlength'   => 60, 'class'=>'form-control',
            'placeholder'=>'NOMBRE DEL CLIENTE'
        ));
        $nombre->setLabel("Ingrese un Nombre");
        $nombre->setFilters(array('striptags', 'string'));
        $nombre->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'El Nombre es Requerido'
            ))
        ));
        $this->add($nombre);
        /*======================= CLIENTE_OPERADORA ==============================*/
        //Primero El PRINCIPAL.
        $dl_operadora = new DataListElement('operadora_nombre',
            array(
                array('placeholder' => 'NOMBRE', 'class'=>'form-control', 'maxlength' => 50),
                Operadora::find(array('operadora_habilitado=1','order'=>'operadora_nombre')),
                array('operadora_id', 'operadora_nombre'),
                'operadora_id'
            ));
        $dl_operadora->setLabel('Operadora');
        $this->add($dl_operadora);
        //Script checkbox
        /*======================= CLIENTE_FRS ==============================*/

        //Primero El PRINCIPAL.
        $dl_frs = new DataListElement('frs_codigo',
            array(
                array('placeholder' => 'CODIGO', 'maxlength' => 50, 'class'=>'form-control'),
                Frs::find(array('frs_habilitado=1','order'=>'frs_codigo')),
                array('frs_id', 'frs_codigo'),
                'frs_id'
            ));
        $dl_frs->setLabel('FRS');
        $this->add($dl_frs);
        /*======================= CLIENTE - EQUIPO/POZO - YACIMIENTO ==============================*/
        //Primero El PRINCIPAL.
        $listaYacimiento = new DataListElement('yacimiento_destino',
            array(
                array('placeholder' => 'SELECCIONAR', 'maxlength' => 50, 'class'=>'form-control'),
                Yacimiento::find(array('yacimiento_habilitado=1','order'=>'yacimiento_destino')),
                array('yacimiento_id', 'yacimiento_destino'),
                'yacimiento_id'
            ));
        $listaYacimiento->setLabel('Yacimiento');
        $this->add($listaYacimiento);

        //DataList Dependientes: EquipoPozo - Segun el Yacimiento, mostrará los nombres que le correspondan.

        $listaEquipoPozo = new DataListElement('equipoPozo_nombre',
            array(
                array('placeholder' => 'SELECCIONE UN YACIMENTO', 'maxlength' => 50, 'class'=>'form-control'),
                null,
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

        //DataList Dependientes: Centro Costo - Segun la linea, mostrará los codigos que le correspondan.

        $listaCentroCosto = new DataListElement('centroCosto_codigo',
            array(
                array('placeholder' => 'SELECCIONE UNA LINEA', 'maxlength' => 50, 'class'=>'form-control'),
                null,
                array('centroCosto_id', 'centroCosto_codigo'),
                'centroCosto_id'
            ));
        $listaCentroCosto->setLabel('Centro Costo');
        $this->add($listaCentroCosto);

        /*===============================SCRIPT PARA LOS DATALIST DEPENDIENTES=====================*/
        //UnionElementScript: La lista dinamica del EquipoPozo
        $script = new DataListScript('equipoPozo_lineaScript',
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