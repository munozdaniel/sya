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
use Phalcon\Forms\Element\Hidden;
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
            'maxlength'   => 60,
        ));
        $nombre->setLabel("Nombre");
        $nombre->setFilters(array('striptags', 'string'));
        $nombre->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'El Nombre es Requerido'
            ))
        ));
        $this->add($nombre);
        /*======================= CLIENTE_OPERADORA ==============================*/
        $operadora = new Text("cliente_operadora",array(
            'maxlength'   => 50));
        $operadora->setLabel("Operadora");
        $operadora->setFilters(array('striptags', 'string'));
        $operadora->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'La Operadora es Requerida'
            ))
        ));
        $this->add($operadora);
        /*======================= CLIENTE_FRS ==============================*/

        $cliente_frs = new Text("cliente_frs",array(
            'maxlength'   => 50));
        $cliente_frs->setLabel("FRS");
        $cliente_frs->setFilters(array('striptags', 'string'));
        $cliente_frs->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'FRS requerido'
            ))
        ));
        $this->add($operadora);
        /*======================= CLIENTE - EQUIPO/POZO - YACIMIENTO ==============================*/


        /*======================== CLIENTE - CENTRO COSTO - LINEA =========================*/
        //DataList Dependientes: Linea


        $listaLinea = new DataListElement('centroCosto_linea',
            array(
                array('placeholder' => 'LINEA', 'maxlength' => 50),
                Linea::find(),
                array('linea_id', 'linea_nombre'),
                'centroCosto_lineaId'
            ));
        $listaLinea->setLabel('Linea');
        $this->add($listaLinea);

        //DataList Dependientes: Centro Costo - Segun la linea, mostrará los codigos que le correspondan.

        $listaCentroCosto = new DataListElement('cliente_centroCosto',
            array(
                array('placeholder' => 'CODIGO', 'maxlength' => 50),
                null,
                array('centroCosto_id', 'centroCosto_codigo'),
                'cliente_centroCostoId'
            ));
        $listaCentroCosto->setLabel('Centro Costo');
        $this->add($listaCentroCosto);

        //UnionElementScript
        $script = new DataListScript('centroCosto_lineaScript',
            array(
                'url'               =>'/sya/cliente/buscarCentroCosto',
                'id_principal'      =>'centroCosto_linea',
                'id_hidden_ppal'    =>'centroCosto_lineaId',
                'id_dependiente'    =>'cliente_centroCosto',
                'columnas'          =>  array('centroCosto_id','centroCosto_codigo')
                )
        );
        $this->add($script);

    }

}