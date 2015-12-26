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
     * * El datalist estará compuesto por:
     * 1ero: un input para escribir el campo buscado.
     * 2do: un datalist, con los datos del modelo.
     * 3ero: un hiddenfield, donde se guardará el id del item seleccionado.
     *
     * $attributes
     * [0]: Contiene un arreglo con los atributos que puede tener el input.
     * [1]: Contiene una tabla de la BD (El Modelo)
     * [2]: Contiene los campos que va a componer el DataList.
     * [3]: El ID del campo Hidden que se va a utilizar para recuperar la clave del elemento seleccionado.
     * Datos a tener en cuenta: El boton submit en el formulario debe tener un id "submit"
     *
     * @param null $attributes
     * @return string
     */
    public function render($attributes = null)
    {
        $atributosInput = $this->getAttributes ()[0];
        $atributosModelo = $this->getAttributes ()[1];
        $columnas = $this->getAttributes ()[2];
        $idHidden = $this->getAttributes ()[3];

        $nombre = $this->getName();
        $listNombre = "list_".$nombre;

        $html = "<input type='text' id='$nombre' name='$nombre' list='$listNombre'";
        foreach($atributosInput as $atributo => $valor)
        {
            $html .= " $atributo = ' $valor '";
        }
        $html .= ">\n ";
        $html .= "<datalist  id=\"" . $listNombre ."\"  >";
        if($atributosModelo != null){
            foreach($atributosModelo as $option => $valor)
            {
                $html .= "<option data-value=\"" . $valor->$columnas[0]. "\" value=\"".$valor-> $columnas[1]."\">";
                $html .= "</option> \n ";
            }
        }
        $html .="</datalist>";
        $html .= "<input type='hidden' id=".$idHidden." name=".$idHidden." >";
        $html .= "\n<script>\n";
        $html .= "$(document).ready(function () {\n";
        $html .= "$('#submit').click(function () {\n";
        $html .= "var value = $('#".$nombre."').val();\n";
        $html .= "var clave = $('#".$listNombre." [value=\"' + value + '\"]').data('value');\n";
        $html .= "if (typeof clave != 'undefined')\n";
        $html .= "document.getElementById('".$idHidden."').value = clave ;\n";
        $html .= " });\n";
        $html .= "});\n";
        $html .= "</script>\n";
        //$html .= "\n <script>";
        //$html .= "\n   $(document).ready(function () { \n $('#submit').click(function () {\n alert('document.getElementById('".$this->getName()."_field').value');\n ";
        //$html .= "var value = $('#".$this->getName()."').val();\n ";
        //$html .= "document.getElementById('".$this->getName()."_field').value = $('#list_".$this->getName()." [value=' + value + ']').data('value') ; }); \n});\n   </script>";
        return $html;
    }
}