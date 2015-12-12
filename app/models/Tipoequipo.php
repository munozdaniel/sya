<?php

class Tipoequipo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $tipoEquipo_id;

    /**
     *
     * @var string
     */
    protected $tipoEquipo_nombre;

    /**
     * Method to set the value of field tipoEquipo_id
     *
     * @param integer $tipoEquipo_id
     * @return $this
     */
    public function setTipoEquipoId($tipoEquipo_id)
    {
        $this->tipoEquipo_id = $tipoEquipo_id;

        return $this;
    }

    /**
     * Method to set the value of field tipoEquipo_nombre
     *
     * @param string $tipoEquipo_nombre
     * @return $this
     */
    public function setTipoEquipoNombre($tipoEquipo_nombre)
    {
        $this->tipoEquipo_nombre = $tipoEquipo_nombre;

        return $this;
    }

    /**
     * Returns the value of field tipoEquipo_id
     *
     * @return integer
     */
    public function getTipoEquipoId()
    {
        return $this->tipoEquipo_id;
    }

    /**
     * Returns the value of field tipoEquipo_nombre
     *
     * @return string
     */
    public function getTipoEquipoNombre()
    {
        return $this->tipoEquipo_nombre;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tipoequipo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipoequipo[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tipoequipo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
