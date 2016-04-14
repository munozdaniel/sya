<?php

class Yacimiento extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $yacimiento_id;

    /**
     *
     * @var string
     */
    protected $yacimiento_destino;

    /**
     *
     * @var integer
     */
    protected $yacimiento_habilitado;

    /**
     * Method to set the value of field yacimiento_id
     *
     * @param integer $yacimiento_id
     * @return $this
     */
    public function setYacimientoId($yacimiento_id)
    {
        $this->yacimiento_id = $yacimiento_id;

        return $this;
    }

    /**
     * Method to set the value of field yacimiento_destino
     *
     * @param string $yacimiento_destino
     * @return $this
     */
    public function setYacimientoDestino($yacimiento_destino)
    {
        $this->yacimiento_destino = $yacimiento_destino;

        return $this;
    }

    /**
     * Method to set the value of field yacimiento_habilitado
     *
     * @param integer $yacimiento_habilitado
     * @return $this
     */
    public function setYacimientoHabilitado($yacimiento_habilitado)
    {
        $this->yacimiento_habilitado = $yacimiento_habilitado;

        return $this;
    }

    /**
     * Returns the value of field yacimiento_id
     *
     * @return integer
     */
    public function getYacimientoId()
    {
        return $this->yacimiento_id;
    }

    /**
     * Returns the value of field yacimiento_destino
     *
     * @return string
     */
    public function getYacimientoDestino()
    {
        return $this->yacimiento_destino;
    }

    /**
     * Returns the value of field yacimiento_habilitado
     *
     * @return integer
     */
    public function getYacimientoHabilitado()
    {
        return $this->yacimiento_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('yacimiento_id', 'Equipopozo', 'equipoPozo_yacimientoId', array('alias' => 'Equipopozo'));
        $this->hasMany('yacimiento_id', 'Operadora', 'operadora_yacimientoId', array('alias' => 'Operadora'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'yacimiento';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Yacimiento[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Yacimiento
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
                    "field"   => "yacimiento_destino",
                    "message" => "El Destino ya existe en la Base de Datos."
                )
            )
        );

        return $this->validationHasFailed() != true;
    }
}
