<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 13/02/2016
 * Time: 06:15 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
class ColumnaExtraForm extends Form
{
    public function initialize($entity = null, $options = array())
    {

        /*=========================== COLUMNA EXTRA =====================================*/
        if(isset($options['extra'])) {
            $columnas = $options['extra'];
            foreach($columnas as $col)
            {
                $elemento = new Text($col->getColumnaClave(),
                    array('placeholder' => 'Ingrese '.$col->getColumnaNombre(), 'class'=>'form-control', 'maxlength' => 60));
                $elemento->setLabel($col->getColumnaNombre());
                $this->add($elemento);
            }

        }

    }

}