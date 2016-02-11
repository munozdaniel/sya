<?php

class Cliente extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $cliente_id;

    /**
     *
     * @var string
     */
    protected $cliente_nombre;

    /**
     *
     * @var integer
     */
    protected $cliente_habilitado;

    /**
     * Method to set the value of field cliente_id
     *
     * @param integer $cliente_id
     * @return $this
     */
    public function setClienteId($cliente_id)
    {
        $this->cliente_id = $cliente_id;

        return $this;
    }

    /**
     * Method to set the value of field cliente_nombre
     *
     * @param string $cliente_nombre
     * @return $this
     */
    public function setClienteNombre($cliente_nombre)
    {
        $this->cliente_nombre = $cliente_nombre;

        return $this;
    }

    /**
     * Method to set the value of field cliente_habilitado
     *
     * @param integer $cliente_habilitado
     * @return $this
     */
    public function setClienteHabilitado($cliente_habilitado)
    {
        $this->cliente_habilitado = $cliente_habilitado;

        return $this;
    }

    /**
     * Returns the value of field cliente_id
     *
     * @return integer
     */
    public function getClienteId()
    {
        return $this->cliente_id;
    }

    /**
     * Returns the value of field cliente_nombre
     *
     * @return string
     */
    public function getClienteNombre()
    {
        return $this->cliente_nombre;
    }

    /**
     * Returns the value of field cliente_habilitado
     *
     * @return integer
     */
    public function getClienteHabilitado()
    {
        return $this->cliente_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('cliente_id', 'Linea', 'linea_clienteId', array('alias' => 'Linea'));
        $this->hasMany('cliente_id', 'Remito', 'remito_clienteId', array('alias' => 'Remito'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cliente';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cliente[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cliente
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
