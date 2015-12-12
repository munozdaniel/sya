<?php

class Tipocarga extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $tipoCarga_id;

    /**
     *
     * @var string
     */
    protected $tipoCarga_nombre;

    /**
     * Method to set the value of field tipoCarga_id
     *
     * @param integer $tipoCarga_id
     * @return $this
     */
    public function setTipoCargaId($tipoCarga_id)
    {
        $this->tipoCarga_id = $tipoCarga_id;

        return $this;
    }

    /**
     * Method to set the value of field tipoCarga_nombre
     *
     * @param string $tipoCarga_nombre
     * @return $this
     */
    public function setTipoCargaNombre($tipoCarga_nombre)
    {
        $this->tipoCarga_nombre = $tipoCarga_nombre;

        return $this;
    }

    /**
     * Returns the value of field tipoCarga_id
     *
     * @return integer
     */
    public function getTipoCargaId()
    {
        return $this->tipoCarga_id;
    }

    /**
     * Returns the value of field tipoCarga_nombre
     *
     * @return string
     */
    public function getTipoCargaNombre()
    {
        return $this->tipoCarga_nombre;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipocarga';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipocarga[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipocarga
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
