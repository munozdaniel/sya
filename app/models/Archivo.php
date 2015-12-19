<?php

class Archivo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $archivo_id;

    /**
     *
     * @var string
     */
    protected $archivo_carpeta;

    /**
     *
     * @var string
     */
    protected $archivo_nombre;

    /**
     *
     * @var string
     */
    protected $archivo_fechaCreacion;

    /**
     * Method to set the value of field archivo_id
     *
     * @param integer $archivo_id
     * @return $this
     */
    public function setArchivoId($archivo_id)
    {
        $this->archivo_id = $archivo_id;

        return $this;
    }

    /**
     * Method to set the value of field archivo_carpeta
     *
     * @param string $archivo_carpeta
     * @return $this
     */
    public function setArchivoCarpeta($archivo_carpeta)
    {
        $this->archivo_carpeta = $archivo_carpeta;

        return $this;
    }

    /**
     * Method to set the value of field archivo_nombre
     *
     * @param string $archivo_nombre
     * @return $this
     */
    public function setArchivoNombre($archivo_nombre)
    {
        $this->archivo_nombre = $archivo_nombre;

        return $this;
    }

    /**
     * Method to set the value of field archivo_fechaCreacion
     *
     * @param string $archivo_fechaCreacion
     * @return $this
     */
    public function setArchivoFechaCreacion($archivo_fechaCreacion)
    {
        $this->archivo_fechaCreacion = $archivo_fechaCreacion;

        return $this;
    }

    /**
     * Returns the value of field archivo_id
     *
     * @return integer
     */
    public function getArchivoId()
    {
        return $this->archivo_id;
    }

    /**
     * Returns the value of field archivo_carpeta
     *
     * @return string
     */
    public function getArchivoCarpeta()
    {
        return $this->archivo_carpeta;
    }

    /**
     * Returns the value of field archivo_nombre
     *
     * @return string
     */
    public function getArchivoNombre()
    {
        return $this->archivo_nombre;
    }

    /**
     * Returns the value of field archivo_fechaCreacion
     *
     * @return string
     */
    public function getArchivoFechaCreacion()
    {
        return $this->archivo_fechaCreacion;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'archivo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Archivo[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Archivo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
