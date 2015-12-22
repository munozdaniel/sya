<?php

class Linea extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $linea_id;

    /**
     *
     * @var string
     */
    protected $linea_nombre;

    /**
     *
     * @var integer
     */
    protected $linea_habilitado;

    /**
     * Method to set the value of field linea_id
     *
     * @param integer $linea_id
     * @return $this
     */
    public function setLineaId($linea_id)
    {
        $this->linea_id = $linea_id;

        return $this;
    }

    /**
     * Method to set the value of field linea_nombre
     *
     * @param string $linea_nombre
     * @return $this
     */
    public function setLineaNombre($linea_nombre)
    {
        $this->linea_nombre = $linea_nombre;

        return $this;
    }

    /**
     * Method to set the value of field linea_habilitado
     *
     * @param integer $linea_habilitado
     * @return $this
     */
    public function setLineaHabilitado($linea_habilitado)
    {
        $this->linea_habilitado = $linea_habilitado;

        return $this;
    }

    /**
     * Returns the value of field linea_id
     *
     * @return integer
     */
    public function getLineaId()
    {
        return $this->linea_id;
    }

    /**
     * Returns the value of field linea_nombre
     *
     * @return string
     */
    public function getLineaNombre()
    {
        return $this->linea_nombre;
    }

    /**
     * Returns the value of field linea_habilitado
     *
     * @return integer
     */
    public function getLineaHabilitado()
    {
        return $this->linea_habilitado;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'linea';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Linea[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Linea
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
                    "field"   => "linea_nombre",
                    "message" => "El nombre de la Linea-PSL ya existe"
                )
            )
        );

        return $this->validationHasFailed() != true;
    }
}
