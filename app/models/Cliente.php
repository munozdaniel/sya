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
     * @var string
     */
    protected $cliente_operadora;

    /**
     *
     * @var string
     */
    protected $cliente_frs;

    /**
     *
     * @var integer
     */
    protected $cliente_habilitado;

    /**
     *
     * @var integer
     */
    protected $cliente_equipoPozoId;

    /**
     *
     * @var integer
     */
    protected $cliente_centroCostoId;

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
     * Method to set the value of field cliente_operadora
     *
     * @param string $cliente_operadora
     * @return $this
     */
    public function setClienteOperadora($cliente_operadora)
    {
        $this->cliente_operadora = $cliente_operadora;

        return $this;
    }

    /**
     * Method to set the value of field cliente_frs
     *
     * @param string $cliente_frs
     * @return $this
     */
    public function setClienteFrs($cliente_frs)
    {
        $this->cliente_frs = $cliente_frs;

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
     * Method to set the value of field cliente_equipoPozoId
     *
     * @param integer $cliente_equipoPozoId
     * @return $this
     */
    public function setClienteEquipoPozoId($cliente_equipoPozoId)
    {
        $this->cliente_equipoPozoId = $cliente_equipoPozoId;

        return $this;
    }

    /**
     * Method to set the value of field cliente_centroCostoId
     *
     * @param integer $cliente_centroCostoId
     * @return $this
     */
    public function setClienteCentroCostoId($cliente_centroCostoId)
    {
        $this->cliente_centroCostoId = $cliente_centroCostoId;

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
     * Returns the value of field cliente_operadora
     *
     * @return string
     */
    public function getClienteOperadora()
    {
        return $this->cliente_operadora;
    }

    /**
     * Returns the value of field cliente_frs
     *
     * @return string
     */
    public function getClienteFrs()
    {
        return $this->cliente_frs;
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
     * Returns the value of field cliente_equipoPozoId
     *
     * @return integer
     */
    public function getClienteEquipoPozoId()
    {
        return $this->cliente_equipoPozoId;
    }

    /**
     * Returns the value of field cliente_centroCostoId
     *
     * @return integer
     */
    public function getClienteCentroCostoId()
    {
        return $this->cliente_centroCostoId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('cliente_id', 'Orden', 'orden_clienteId', array('alias' => 'Orden'));
        $this->belongsTo('cliente_equipoPozoId', 'Equipopozo', 'equipoPozo_id', array('alias' => 'Equipopozo'));
        $this->belongsTo('cliente_centroCostoId', 'Centrocosto', 'centroCosto_id', array('alias' => 'Centrocosto'));
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
