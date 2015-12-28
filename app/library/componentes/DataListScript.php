<?php

/**
 * ENCARGADO DE CREAR UN SCRIPT PARA QUE UN DATALIST SEA DEPENDIENTE DE OTRO.
 * Created by PhpStorm.
 * User: Daniel
 * Date: 26/12/2015
 * Time: 12:46 PM
 */
class DataListScript extends \Phalcon\Forms\Element implements \Phalcon\Forms\ElementInterface
{
    public function  __construct($name, array $attributes)
    {

        parent::__construct($name, $attributes);
    }

    /**
     * $attributes
     * [url]: Contiene la url del /nombreProyecto/controlador/action donde se cargará la segunda lista.
     * [id_principal]: Corresponde al id del DataList Principal
     * [id_hidden_ppal]: Corresponde al id del Hidden Principal, se envia al controlador como parametro.
     * [id_dependiente]: Contiene el id del segundo DataList (Dependiente).
     * [columnas]: Contiene un array de dos elementos. [0]: id - [1]: nombre a mostrar
     *
     * @param null $attributes
     * @return string
     */
    public function render($attributes = null)
    {

        $url = $this->getAttributes()['url'];
        $nombre = $this->getAttributes()['id_principal'];
        $idHiddenPpal = $this->getAttributes()['id_hidden_ppal'];
        $idDependiente = $this->getAttributes()['id_dependiente'];
        $columnas = $this->getAttributes()['columnas'];
        $html="";
        $html .= "<script>";
        $html .= "     $(document).ready(function () { \n";
        $html .= " $(\"#$nombre\").blur(function (event) { \n";
        $html .= " var value = document.getElementById('$idHiddenPpal').value;  \n";
        $html .= " var getResultsUrl = '$url';\n";
        $html .= " $.ajax({\n";
        $html .= " data: {\"id\": value},\n";
        $html .= " method: \"POST\",\n";
        $html .= " url: getResultsUrl,";
        $html .= " \n success: function (response) {\n";
        $html .= " $(\"#$idDependiente\").empty();\n";
        $html .= " parsed = $.parseJSON(response);\n";
        $html .= " var html = \"\";\n";
        $html .= " for(datos in parsed.lista)\n";
        $html .= " {\n";
        $html .= " html += '<option data-value=\"'+parsed.lista[datos]['".$columnas[0]."']+'\" value=\"'+parsed.lista[datos]['".$columnas[1]."']+'\"></option>';\n";
        $html .= " }\n";
        $html .= "$('datalist#list_$idDependiente').html(html);\n";
        $html .= " console.log(response);\n";
        $html .= " },\n";
        $html .= " error: function (error) {\n";
        $html .= " alert(\"ERROR : \"+error.statusText) ;\n";
        $html .= " console.log(error);\n";
        $html .= "}\n";
        $html .= " });\n";
        $html .= " });\n";
        $html .= " });\n";
        $html .= " </script> \n";
        return $html;
    }
}