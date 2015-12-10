<?php

class Planilla extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $planilla_id;

    /**
     *
     * @var string
     */
    protected $planilla_nombreCliente;

    /**
     *
     * @var string
     */
    protected $planilla_fecha;

    /**
     * Method to set the value of field planilla_id
     *
     * @param integer $planilla_id
     * @return $this
     */
    public function setPlanillaId($planilla_id)
    {
        $this->planilla_id = $planilla_id;

        return $this;
    }

    /**
     * Method to set the value of field planilla_nombreCliente
     *
     * @param string $planilla_nombreCliente
     * @return $this
     */
    public function setPlanillaNombreCliente($planilla_nombreCliente)
    {
        $this->planilla_nombreCliente = $planilla_nombreCliente;

        return $this;
    }

    /**
     * Method to set the value of field planilla_fecha
     *
     * @param string $planilla_fecha
     * @return $this
     */
    public function setPlanillaFecha($planilla_fecha)
    {
        $this->planilla_fecha = $planilla_fecha;

        return $this;
    }

    /**
     * Returns the value of field planilla_id
     *
     * @return integer
     */
    public function getPlanillaId()
    {
        return $this->planilla_id;
    }

    /**
     * Returns the value of field planilla_nombreCliente
     *
     * @return string
     */
    public function getPlanillaNombreCliente()
    {
        return $this->planilla_nombreCliente;
    }

    /**
     * Returns the value of field planilla_fecha
     *
     * @return string
     */
    public function getPlanillaFecha()
    {
        return $this->planilla_fecha;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'planilla';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Planilla[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Planilla
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
