<?php

class Chofer extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $chofer_id;

    /**
     *
     * @var string
     */
    protected $chofer_nombreCompleto;

    /**
     *
     * @var integer
     */
    protected $chofer_dni;

    /**
     *
     * @var integer
     */
    protected $chofer_esFletero;

    /**
     * Method to set the value of field chofer_id
     *
     * @param integer $chofer_id
     * @return $this
     */
    public function setChoferId($chofer_id)
    {
        $this->chofer_id = $chofer_id;

        return $this;
    }

    /**
     * Method to set the value of field chofer_nombreCompleto
     *
     * @param string $chofer_nombreCompleto
     * @return $this
     */
    public function setChoferNombreCompleto($chofer_nombreCompleto)
    {
        $this->chofer_nombreCompleto = $chofer_nombreCompleto;

        return $this;
    }

    /**
     * Method to set the value of field chofer_dni
     *
     * @param integer $chofer_dni
     * @return $this
     */
    public function setChoferDni($chofer_dni)
    {
        $this->chofer_dni = $chofer_dni;

        return $this;
    }

    /**
     * Method to set the value of field chofer_esFletero
     *
     * @param integer $chofer_esFletero
     * @return $this
     */
    public function setChoferEsFletero($chofer_esFletero)
    {
        $this->chofer_esFletero = $chofer_esFletero;

        return $this;
    }

    /**
     * Returns the value of field chofer_id
     *
     * @return integer
     */
    public function getChoferId()
    {
        return $this->chofer_id;
    }

    /**
     * Returns the value of field chofer_nombreCompleto
     *
     * @return string
     */
    public function getChoferNombreCompleto()
    {
        return $this->chofer_nombreCompleto;
    }

    /**
     * Returns the value of field chofer_dni
     *
     * @return integer
     */
    public function getChoferDni()
    {
        return $this->chofer_dni;
    }

    /**
     * Returns the value of field chofer_esFletero
     *
     * @return integer
     */
    public function getChoferEsFletero()
    {
        return $this->chofer_esFletero;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'chofer';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Chofer[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Chofer
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
