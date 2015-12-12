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
    protected $cliente_linea;

    /**
     *
     * @var integer
     */
    protected $cliente_yacimiento;

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
     * Method to set the value of field cliente_linea
     *
     * @param integer $cliente_linea
     * @return $this
     */
    public function setClienteLinea($cliente_linea)
    {
        $this->cliente_linea = $cliente_linea;

        return $this;
    }

    /**
     * Method to set the value of field cliente_yacimiento
     *
     * @param integer $cliente_yacimiento
     * @return $this
     */
    public function setClienteYacimiento($cliente_yacimiento)
    {
        $this->cliente_yacimiento = $cliente_yacimiento;

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
     * Returns the value of field cliente_linea
     *
     * @return integer
     */
    public function getClienteLinea()
    {
        return $this->cliente_linea;
    }

    /**
     * Returns the value of field cliente_yacimiento
     *
     * @return integer
     */
    public function getClienteYacimiento()
    {
        return $this->cliente_yacimiento;
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
