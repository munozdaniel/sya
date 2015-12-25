<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 24/12/2015
 * Time: 06:43 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use \Phalcon\Forms\Element\Hidden;

class CentroCostoForm  extends Form
{

    /**
     * Inicializar Formulario EquipoPozo.
     */
    public function initialize($entity = null, $options = array())
    {

        /*======================== ID =========================*/
        if (!isset($options['edit'])) {
            $equipoPozo_id = new Text("centroCosto_id");
            $this->add($equipoPozo_id->setLabel("N° de Centro Costo"));
        } else {
            $this->add(new Hidden("centroCosto_id"));
        }
        /*======================== CODIGO =========================*/

        $equipoPozo_nombre = new Text("centroCosto_codigo", array(
            'maxlength' => 50,
            'placeholder' => 'CODIGO',
        ));
        $equipoPozo_nombre->setLabel("Centro Costo");
        $equipoPozo_nombre->setFilters(array('striptags', 'string'));
        $equipoPozo_nombre->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Codigo es Requerido'
            ))
        ));
        $this->add($equipoPozo_nombre);
        /*======================== LINEA =========================*/
        //"centroCosto_lineaId" .... linea_id - linea_nombre
        $listaLinea = new DataListElement('centroCosto_linea',
            array(array('placeholder' => 'LINEA', 'maxlength' => 50),
                Linea::find(),
                array('linea_id', 'linea_nombre'),'centroCosto_lineaId'
            ));
        $listaLinea->setLabel('Linea');

        $this->add($listaLinea);
        /*VERIFICAR SI ES NECESARIO EL PRESENCEOF*/

    }

}