<?php

class Equipopozo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $equipoPozo_id;

    /**
     *
     * @var string
     */
    protected $equipoPozo_nombre;

    /**
     *
     * @var integer
     */
    protected $equipoPozo_habilitado;

    /**
     * Method to set the value of field equipoPozo_id
     *
     * @param integer $equipoPozo_id
     * @return $this
     */
    public function setEquipoPozoId($equipoPozo_id)
    {
        $this->equipoPozo_id = $equipoPozo_id;

        return $this;
    }

    /**
     * Method to set the value of field equipoPozo_nombre
     *
     * @param string $equipoPozo_nombre
     * @return $this
     */
    public function setEquipoPozoNombre($equipoPozo_nombre)
    {
        $this->equipoPozo_nombre = $equipoPozo_nombre;

        return $this;
    }

    /**
     * Method to set the value of field equipoPozo_habilitado
     *
     * @param integer $equipoPozo_habilitado
     * @return $this
     */
    public function setEquipoPozoHabilitado($equipoPozo_habilitado)
    {
        $this->equipoPozo_habilitado = $equipoPozo_habilitado;

        return $this;
    }

    /**
     * Returns the value of field equipoPozo_id
     *
     * @return integer
     */
    public function getEquipoPozoId()
    {
        return $this->equipoPozo_id;
    }

    /**
     * Returns the value of field equipoPozo_nombre
     *
     * @return string
     */
    public function getEquipoPozoNombre()
    {
        return $this->equipoPozo_nombre;
    }

    /**
     * Returns the value of field equipoPozo_habilitado
     *
     * @return integer
     */
    public function getEquipoPozoHabilitado()
    {
        return $this->equipoPozo_habilitado;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'equipopozo';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipopozo[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipopozo
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
                    "field"   => "equipoPozo_nombre",
                    "message" => "El nombre del Equipo/Pozo ya existe"
                )
            )
        );

        return $this->validationHasFailed() != true;
    }
}
