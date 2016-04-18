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
        if($entity!=null) {
            $columnas = $entity;
            foreach($columnas as $col)
            {
                $elemento = new Text($col->getColumnaClave(),
                    array('placeholder' => 'Ingrese '.$col->getColumnaNombre(), 'class'=>'form-control', 'maxlength' => 60));
                $elemento->setLabel($col->getColumnaNombre());
                if(isset($options['remito_id']))
                {
                    $remito_id = $options['remito_id'];
                    $contenidoExtra = Contenidoextra::findFirst(array('contenidoExtra_remitoId = :remito_id: AND
                    contenidoExtra_columnaId=:columna_id:','bind'=>array('remito_id'=>$remito_id,'columna_id'=>$col->getColumnaId())));
                    if($contenidoExtra){
                        $elemento->setDefault($contenidoExtra->getContenidoExtraDescripcion());
                    }
                }
                $this->add($elemento);
            }

        }

    }

}