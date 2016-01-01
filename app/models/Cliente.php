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
    protected $cliente_operadoraId;

    /**
     *
     * @var integer
     */
    protected $cliente_frsId;

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
     * Method to set the value of field cliente_operadoraId
     *
     * @param integer $cliente_operadoraId
     * @return $this
     */
    public function setClienteOperadoraId($cliente_operadoraId)
    {
        $this->cliente_operadoraId = $cliente_operadoraId;

        return $this;
    }

    /**
     * Method to set the value of field cliente_frsId
     *
     * @param integer $cliente_frsId
     * @return $this
     */
    public function setClienteFrsId($cliente_frsId)
    {
        $this->cliente_frsId = $cliente_frsId;

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
     * Returns the value of field cliente_operadoraId
     *
     * @return integer
     */
    public function getClienteOperadoraId()
    {
        return $this->cliente_operadoraId;
    }

    /**
     * Returns the value of field cliente_frsId
     *
     * @return integer
     */
    public function getClienteFrsId()
    {
        return $this->cliente_frsId;
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
        $this->belongsTo('cliente_operadoraId', 'Operadora', 'operadora_id', array('alias' => 'Operadora'));
        $this->belongsTo('cliente_frsId', 'Frs', 'frs_id', array('alias' => 'Frs'));
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
