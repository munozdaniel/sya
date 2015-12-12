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
    protected $yacimiento_equipoPozo;

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
     * Method to set the value of field yacimiento_equipoPozo
     *
     * @param integer $yacimiento_equipoPozo
     * @return $this
     */
    public function setYacimientoEquipoPozo($yacimiento_equipoPozo)
    {
        $this->yacimiento_equipoPozo = $yacimiento_equipoPozo;

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
     * Returns the value of field yacimiento_equipoPozo
     *
     * @return integer
     */
    public function getYacimientoEquipoPozo()
    {
        return $this->yacimiento_equipoPozo;
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

}
