<?php

use Phalcon\Mvc\Model\Validator\Uniqueness;
class Transporte extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $transporte_id;

    /**
     *
     * @var string
     */
    protected $transporte_dominio;

    /**
     *
     * @var integer
     */
    protected $transporte_nroInterno;

    /**
     *
     * @var integer
     */
    protected $transporte_habilitado;

    /**
     * Method to set the value of field transporte_id
     *
     * @param integer $transporte_id
     * @return $this
     */
    public function setTransporteId($transporte_id)
    {
        $this->transporte_id = $transporte_id;

        return $this;
    }

    /**
     * Method to set the value of field transporte_dominio
     *
     * @param string $transporte_dominio
     * @return $this
     */
    public function setTransporteDominio($transporte_dominio)
    {
        $this->transporte_dominio = $transporte_dominio;

        return $this;
    }

    /**
     * Method to set the value of field transporte_nroInterno
     *
     * @param integer $transporte_nroInterno
     * @return $this
     */
    public function setTransporteNroInterno($transporte_nroInterno)
    {
        $this->transporte_nroInterno = $transporte_nroInterno;

        return $this;
    }

    /**
     * Method to set the value of field transporte_habilitado
     *
     * @param integer $transporte_habilitado
     * @return $this
     */
    public function setTransporteHabilitado($transporte_habilitado)
    {
        $this->transporte_habilitado = $transporte_habilitado;

        return $this;
    }

    /**
     * Returns the value of field transporte_id
     *
     * @return integer
     */
    public function getTransporteId()
    {
        return $this->transporte_id;
    }

    /**
     * Returns the value of field transporte_dominio
     *
     * @return string
     */
    public function getTransporteDominio()
    {
        return $this->transporte_dominio;
    }

    /**
     * Returns the value of field transporte_nroInterno
     *
     * @return integer
     */
    public function getTransporteNroInterno()
    {
        return $this->transporte_nroInterno;
    }

    /**
     * Returns the value of field transporte_habilitado
     *
     * @return integer
     */
    public function getTransporteHabilitado()
    {
        return $this->transporte_habilitado;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'transporte';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transporte[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Transporte
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    public function validation()
    {

        $this->validate(
            new Uniqueness(
                array(
                    "field"   => "transporte_dominio",
                    "message" => "El Dominio ya se encuentra  en la Base de Datos."
                )
            )
        );

        return $this->validationHasFailed() != true;
    }
}
