<?php

class Columna extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $columna_id;

    /**
     *
     * @var integer
     */
    protected $columna_nombre;

    /**
     *
     * @var integer
     */
    protected $columna_clave;

    /**
     *
     * @var integer
     */
    protected $columna_posicion;

    /**
     *
     * @var integer
     */
    protected $columna_extra;

    /**
     *
     * @var integer
     */
    protected $columna_cabeceraId;

    /**
     *
     * @var integer
     */
    protected $columna_habilitado;

    /**
     * Method to set the value of field columna_id
     *
     * @param integer $columna_id
     * @return $this
     */
    public function setColumnaId($columna_id)
    {
        $this->columna_id = $columna_id;

        return $this;
    }

    /**
     * Method to set the value of field columna_nombre
     *
     * @param integer $columna_nombre
     * @return $this
     */
    public function setColumnaNombre($columna_nombre)
    {
        $this->columna_nombre = $columna_nombre;

        return $this;
    }

    /**
     * Method to set the value of field columna_clave
     *
     * @param integer $columna_clave
     * @return $this
     */
    public function setColumnaClave($columna_clave)
    {
        $this->columna_clave = $columna_clave;

        return $this;
    }

    /**
     * Method to set the value of field columna_posicion
     *
     * @param integer $columna_posicion
     * @return $this
     */
    public function setColumnaPosicion($columna_posicion)
    {
        $this->columna_posicion = $columna_posicion;

        return $this;
    }

    /**
     * Method to set the value of field columna_extra
     *
     * @param integer $columna_extra
     * @return $this
     */
    public function setColumnaExtra($columna_extra)
    {
        $this->columna_extra = $columna_extra;

        return $this;
    }

    /**
     * Method to set the value of field columna_cabeceraId
     *
     * @param integer $columna_cabeceraId
     * @return $this
     */
    public function setColumnaCabeceraId($columna_cabeceraId)
    {
        $this->columna_cabeceraId = $columna_cabeceraId;

        return $this;
    }

    /**
     * Method to set the value of field columna_habilitado
     *
     * @param integer $columna_habilitado
     * @return $this
     */
    public function setColumnaHabilitado($columna_habilitado)
    {
        $this->columna_habilitado = $columna_habilitado;

        return $this;
    }

    /**
     * Returns the value of field columna_id
     *
     * @return integer
     */
    public function getColumnaId()
    {
        return $this->columna_id;
    }

    /**
     * Returns the value of field columna_nombre
     *
     * @return integer
     */
    public function getColumnaNombre()
    {
        return $this->columna_nombre;
    }

    /**
     * Returns the value of field columna_clave
     *
     * @return integer
     */
    public function getColumnaClave()
    {
        return $this->columna_clave;
    }

    /**
     * Returns the value of field columna_posicion
     *
     * @return integer
     */
    public function getColumnaPosicion()
    {
        return $this->columna_posicion;
    }

    /**
     * Returns the value of field columna_extra
     *
     * @return integer
     */
    public function getColumnaExtra()
    {
        return $this->columna_extra;
    }

    /**
     * Returns the value of field columna_cabeceraId
     *
     * @return integer
     */
    public function getColumnaCabeceraId()
    {
        return $this->columna_cabeceraId;
    }

    /**
     * Returns the value of field columna_habilitado
     *
     * @return integer
     */
    public function getColumnaHabilitado()
    {
        return $this->columna_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('columna_id', 'Contenidoextra', 'contenidoExtra_columnaId', array('alias' => 'Contenidoextra'));
        $this->belongsTo('columna_cabeceraId', 'Cabecera', 'cabecera_id', array('alias' => 'Cabecera'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'columna';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columna[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columna
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
