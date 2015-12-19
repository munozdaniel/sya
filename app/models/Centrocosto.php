<?php

class Centrocosto extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $centroCosto_id;

    /**
     *
     * @var string
     */
    protected $centroCosto_codigo;

    /**
     *
     * @var integer
     */
    protected $centroCosto_habilitado;

    /**
     * Method to set the value of field centroCosto_id
     *
     * @param integer $centroCosto_id
     * @return $this
     */
    public function setCentroCostoId($centroCosto_id)
    {
        $this->centroCosto_id = $centroCosto_id;

        return $this;
    }

    /**
     * Method to set the value of field centroCosto_codigo
     *
     * @param string $centroCosto_codigo
     * @return $this
     */
    public function setCentroCostoCodigo($centroCosto_codigo)
    {
        $this->centroCosto_codigo = $centroCosto_codigo;

        return $this;
    }

    /**
     * Method to set the value of field centroCosto_habilitado
     *
     * @param integer $centroCosto_habilitado
     * @return $this
     */
    public function setCentroCostoHabilitado($centroCosto_habilitado)
    {
        $this->centroCosto_habilitado = $centroCosto_habilitado;

        return $this;
    }

    /**
     * Returns the value of field centroCosto_id
     *
     * @return integer
     */
    public function getCentroCostoId()
    {
        return $this->centroCosto_id;
    }

    /**
     * Returns the value of field centroCosto_codigo
     *
     * @return string
     */
    public function getCentroCostoCodigo()
    {
        return $this->centroCosto_codigo;
    }

    /**
     * Returns the value of field centroCosto_habilitado
     *
     * @return integer
     */
    public function getCentroCostoHabilitado()
    {
        return $this->centroCosto_habilitado;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'centrocosto';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Centrocosto[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Centrocosto
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
