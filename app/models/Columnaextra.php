<?php

class Columnaextra extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $columnaExtra_id;

    /**
     *
     * @var string
     */
    protected $columnaExtra_nombre;

    /**
     *
     * @var integer
     */
    protected $columnaExtra_habilitado;

    /**
     * Method to set the value of field columnaExtra_id
     *
     * @param integer $columnaExtra_id
     * @return $this
     */
    public function setColumnaExtraId($columnaExtra_id)
    {
        $this->columnaExtra_id = $columnaExtra_id;

        return $this;
    }

    /**
     * Method to set the value of field columnaExtra_nombre
     *
     * @param string $columnaExtra_nombre
     * @return $this
     */
    public function setColumnaExtraNombre($columnaExtra_nombre)
    {
        $this->columnaExtra_nombre = $columnaExtra_nombre;

        return $this;
    }

    /**
     * Method to set the value of field columnaExtra_habilitado
     *
     * @param integer $columnaExtra_habilitado
     * @return $this
     */
    public function setColumnaExtraHabilitado($columnaExtra_habilitado)
    {
        $this->columnaExtra_habilitado = $columnaExtra_habilitado;

        return $this;
    }

    /**
     * Returns the value of field columnaExtra_id
     *
     * @return integer
     */
    public function getColumnaExtraId()
    {
        return $this->columnaExtra_id;
    }

    /**
     * Returns the value of field columnaExtra_nombre
     *
     * @return string
     */
    public function getColumnaExtraNombre()
    {
        return $this->columnaExtra_nombre;
    }

    /**
     * Returns the value of field columnaExtra_habilitado
     *
     * @return integer
     */
    public function getColumnaExtraHabilitado()
    {
        return $this->columnaExtra_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('columnaExtra_id', 'Contenidoextra', 'contenidoExtra_columnaExtraId', array('alias' => 'Contenidoextra'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'columnaextra';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columnaextra[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columnaextra
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
