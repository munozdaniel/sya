<?php
/**
 * Permite especificar el tipo del input.
 * type: date, color, range, month, week, time, datetime, datetime-local, etc.
 * http://www.w3schools.com/html/html_form_input_types.asp
 * User: Daniel
 * Date: 04/01/2016
 * Time: 07:12 PM
 */

class TypeElement  extends \Phalcon\Forms\Element implements \Phalcon\Forms\ElementInterface
{
    public function  __construct($name, array $attributes)
    {

        parent::__construct($name, $attributes);
    }

    /**
     * @param null $attributes
     * @return string
     */
    public function render($attributes = null)
    {
        $nombre = $this->getName();
        $atributosInput = $this->getAttributes ();

        $html = "<input  id='$nombre' name='$nombre' ";
        foreach($atributosInput as $atributo => $valor)
        {
            $html .= " $atributo = '$valor'";
        }
        $html .= ">\n ";

        return $html;
    }
}