<?php

class Viaje extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $viaje_id;

    /**
     *
     * @var string
     */
    protected $viaje_origen;


    /**
     *
     * @var integer
     */
    protected $viaje_habilitado;

    /**
     * Method to set the value of field viaje_id
     *
     * @param integer $viaje_id
     * @return $this
     */
    public function setViajeId($viaje_id)
    {
        $this->viaje_id = $viaje_id;

        return $this;
    }

    /**
     * Method to set the value of field viaje_origen
     *
     * @param string $viaje_origen
     * @return $this
     */
    public function setViajeOrigen($viaje_origen)
    {
        $this->viaje_origen = $viaje_origen;

        return $this;
    }



    /**
     * Method to set the value of field viaje_habilitado
     *
     * @param integer $viaje_habilitado
     * @return $this
     */
    public function setViajeHabilitado($viaje_habilitado)
    {
        $this->viaje_habilitado = $viaje_habilitado;

        return $this;
    }

    /**
     * Returns the value of field viaje_id
     *
     * @return integer
     */
    public function getViajeId()
    {
        return $this->viaje_id;
    }

    /**
     * Returns the value of field viaje_origen
     *
     * @return string
     */
    public function getViajeOrigen()
    {
        return $this->viaje_origen;
    }



    /**
     * Returns the value of field viaje_habilitado
     *
     * @return integer
     */
    public function getViajeHabilitado()
    {
        return $this->viaje_habilitado;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'viaje';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Viaje[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Viaje
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
                    "field"   => "viaje_origen",
                    "message" => "El Origen ya se encuentra  en la Base de Datos."
                )
            )
        );

        return $this->validationHasFailed() != true;
    }
}
