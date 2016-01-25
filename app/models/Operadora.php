<?php

class Operadora extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $operadora_id;

    /**
     *
     * @var string
     */
    protected $operadora_nombre;

    /**
     *
     * @var integer
     */
    protected $operadora_clienteId;

    /**
     *
     * @var integer
     */
    protected $operadora_habilitado;

    /**
     * Method to set the value of field operadora_id
     *
     * @param integer $operadora_id
     * @return $this
     */
    public function setOperadoraId($operadora_id)
    {
        $this->operadora_id = $operadora_id;

        return $this;
    }

    /**
     * Method to set the value of field operadora_nombre
     *
     * @param string $operadora_nombre
     * @return $this
     */
    public function setOperadoraNombre($operadora_nombre)
    {
        $this->operadora_nombre = $operadora_nombre;

        return $this;
    }

    /**
     * Method to set the value of field operadora_clienteId
     *
     * @param integer $operadora_clienteId
     * @return $this
     */
    public function setOperadoraClienteId($operadora_clienteId)
    {
        $this->operadora_clienteId = $operadora_clienteId;

        return $this;
    }

    /**
     * Method to set the value of field operadora_habilitado
     *
     * @param integer $operadora_habilitado
     * @return $this
     */
    public function setOperadoraHabilitado($operadora_habilitado)
    {
        $this->operadora_habilitado = $operadora_habilitado;

        return $this;
    }

    /**
     * Returns the value of field operadora_id
     *
     * @return integer
     */
    public function getOperadoraId()
    {
        return $this->operadora_id;
    }

    /**
     * Returns the value of field operadora_nombre
     *
     * @return string
     */
    public function getOperadoraNombre()
    {
        return $this->operadora_nombre;
    }

    /**
     * Returns the value of field operadora_clienteId
     *
     * @return integer
     */
    public function getOperadoraClienteId()
    {
        return $this->operadora_clienteId;
    }

    /**
     * Returns the value of field operadora_habilitado
     *
     * @return integer
     */
    public function getOperadoraHabilitado()
    {
        return $this->operadora_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('operadora_id', 'Frs', 'frs_operadoraId', array('alias' => 'Frs'));
        $this->hasMany('operadora_id', 'Yacimiento', 'yacimiento_operadoraId', array('alias' => 'Yacimiento'));
        $this->belongsTo('operadora_clienteId', 'Cliente', 'cliente_id', array('alias' => 'Cliente'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'operadora';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Operadora[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Operadora
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function validation()
    {

        $this->validate(
            new \Phalcon\Mvc\Model\Validator\Uniqueness(
                array(
                    "field"   => "operadora_nombre",
                    "message" => "La Operadora ya existe"
                )
            )
        );

        return $this->validationHasFailed() != true;
    }
}
