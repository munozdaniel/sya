<?php
/**
 * La funcion de este elemento es la de crear un campo input con autocomplete, es decir, a partir de una lista
 * se podra ir completando el input.
 * User: Daniel
 * Date: 19/12/2015
 * Time: 06:03 PM
 */

class DataListElement extends \Phalcon\Forms\Element implements \Phalcon\Forms\ElementInterface
{
    public function  __construct( $name, array $attributes)
    {

        parent::__construct($name, $attributes);
    }

    /**
     * El atributo que ingresa es un arreglo de tres elementos, sin contar el id que se puede recuperar con $this->getName()
     * [0]: Contiene un arreglo con los atributos que puede tener el input.
     * [1]: Contiene una tabla de la BD
     * [2]: Contiene los campos que va a componer el DataList.
     * @param null $attributes
     * @return string
     */
    public function render($attributes = null)
    {
        $atributosInput = $this->getAttributes ()[0];
        $atributosLista = $this->getAttributes ()[1];
        $campos = $this->getAttributes ()[2];
        $html = "<input type='text' id='" . $this->getName() ."' name='" . $this->getName() ."' list='list_" . $this->getName()."'";
        foreach($atributosInput as $atributo => $valor)
        {
            $html .= " $atributo = ' $valor '";
        }
        $html .= ">\n ";
        $html .= "<datalist  id=\"list_" . $this->getName() ."\"  >";
        foreach($atributosLista as $option => $valor)
        {
            $html .= "<option data-value=\"" . $valor->$campos[0]. "\" value=\"".$valor-> $campos[1]."\">";
            $html .= "</option> \n ";
        }
        $html .="</datalist>";
        $html .= "<input type='hidden' id=".$this->getName()."_field name=".$this->getName()."_field >";
        $html .= "\n <script>";
        $html .= "\n   $(document).ready(function () { \n $('#submit').click(function () {\n ";
        $html .= "var value = $('#".$this->getName()."').val()\n ";
        $html .= "document.getElementById('".$this->getName()."_field').value = $('#list_".$this->getName()." [value=' + value + ']').data('value') ; }); \n});\n   </script>";
        return $html;
    }
}