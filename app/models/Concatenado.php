<?php

class Concatenado extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $concatenado_id;

    /**
     *
     * @var string
     */
    protected $concatenado_nombre;

    /**
     *
     * @var integer
     */
    protected $concatenado_habilitado;

    /**
     * Method to set the value of field concatenado_id
     *
     * @param integer $concatenado_id
     * @return $this
     */
    public function setConcatenadoId($concatenado_id)
    {
        $this->concatenado_id = $concatenado_id;

        return $this;
    }

    /**
     * Method to set the value of field concatenado_nombre
     *
     * @param string $concatenado_nombre
     * @return $this
     */
    public function setConcatenadoNombre($concatenado_nombre)
    {
        $this->concatenado_nombre = $concatenado_nombre;

        return $this;
    }

    /**
     * Method to set the value of field concatenado_habilitado
     *
     * @param integer $concatenado_habilitado
     * @return $this
     */
    public function setConcatenadoHabilitado($concatenado_habilitado)
    {
        $this->concatenado_habilitado = $concatenado_habilitado;

        return $this;
    }

    /**
     * Returns the value of field concatenado_id
     *
     * @return integer
     */
    public function getConcatenadoId()
    {
        return $this->concatenado_id;
    }

    /**
     * Returns the value of field concatenado_nombre
     *
     * @return string
     */
    public function getConcatenadoNombre()
    {
        return $this->concatenado_nombre;
    }

    /**
     * Returns the value of field concatenado_habilitado
     *
     * @return integer
     */
    public function getConcatenadoHabilitado()
    {
        return $this->concatenado_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('concatenado_id', 'Orden', 'orden_concatenadoId', array('alias' => 'Orden'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'concatenado';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Concatenado[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Concatenado
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
