<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 01/12/2015
 * Time: 10:12 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class UsuariosForm extends Form
{

    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
{
    /*======================= usuario_id ================================*/
    if (!isset($options['edit'])) {
        $element = new Text("usuario_id");
        $this->add($element->setLabel("Id"));
    } else {
        $this->add(new Hidden("usuario_id"));
    }
    /*======================= usuario_nick ================================*/

    $name = new Text("name");
    $name->setLabel("Name");
    $name->setFilters(array('striptags', 'string'));
    $name->addValidators(array(
        new PresenceOf(array(
            'message' => 'Name is required'
        ))
    ));
    $this->add($name);
    /*======================= usuario_nombreCompleto ================================*/

    $type = new Select('product_types_id', ProductTypes::find(), array(
        'using'      => array('id', 'name'),
        'useEmpty'   => true,
        'emptyText'  => '...',
        'emptyValue' => ''
    ));
    $type->setLabel('Type');
    $this->add($type);
    /*======================= usuario_contrasenia ================================*/

    $price = new Text("price");
    $price->setLabel("Price");
    $price->setFilters(array('float'));
    $price->addValidators(array(
        new PresenceOf(array(
            'message' => 'Price is required'
        )),
        new Numericality(array(
            'message' => 'Price is required'
        ))
    ));
    $this->add($price);
    /*======================= usuario_sector ================================*/
    /*======================= usuario_email ================================*/
    /*======================= usuario_activo ================================*/
    /*======================= usuario_fechaCreacion ================================*/
    /*======================= usuario_imagen ================================*/

}
}