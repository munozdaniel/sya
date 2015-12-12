<?php

class Tarifa extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $tarifa_id;

    /**
     *
     * @var string
     */
    protected $tarifa_horaInicial;

    /**
     *
     * @var string
     */
    protected $tarifa_horaFinal;

    /**
     *
     * @var integer
     */
    protected $tarifa_hsServicio;

    /**
     *
     * @var integer
     */
    protected $tarifa_hsHidro;

    /**
     *
     * @var integer
     */
    protected $tarifa_hsMalacate;

    /**
     *
     * @var integer
     */
    protected $tarifa_hsStand;

    /**
     *
     * @var integer
     */
    protected $tarifa_km;

    /**
     * Method to set the value of field tarifa_id
     *
     * @param integer $tarifa_id
     * @return $this
     */
    public function setTarifaId($tarifa_id)
    {
        $this->tarifa_id = $tarifa_id;

        return $this;
    }

    /**
     * Method to set the value of field tarifa_horaInicial
     *
     * @param string $tarifa_horaInicial
     * @return $this
     */
    public function setTarifaHoraInicial($tarifa_horaInicial)
    {
        $this->tarifa_horaInicial = $tarifa_horaInicial;

        return $this;
    }

    /**
     * Method to set the value of field tarifa_horaFinal
     *
     * @param string $tarifa_horaFinal
     * @return $this
     */
    public function setTarifaHoraFinal($tarifa_horaFinal)
    {
        $this->tarifa_horaFinal = $tarifa_horaFinal;

        return $this;
    }

    /**
     * Method to set the value of field tarifa_hsServicio
     *
     * @param integer $tarifa_hsServicio
     * @return $this
     */
    public function setTarifaHsServicio($tarifa_hsServicio)
    {
        $this->tarifa_hsServicio = $tarifa_hsServicio;

        return $this;
    }

    /**
     * Method to set the value of field tarifa_hsHidro
     *
     * @param integer $tarifa_hsHidro
     * @return $this
     */
    public function setTarifaHsHidro($tarifa_hsHidro)
    {
        $this->tarifa_hsHidro = $tarifa_hsHidro;

        return $this;
    }

    /**
     * Method to set the value of field tarifa_hsMalacate
     *
     * @param integer $tarifa_hsMalacate
     * @return $this
     */
    public function setTarifaHsMalacate($tarifa_hsMalacate)
    {
        $this->tarifa_hsMalacate = $tarifa_hsMalacate;

        return $this;
    }

    /**
     * Method to set the value of field tarifa_hsStand
     *
     * @param integer $tarifa_hsStand
     * @return $this
     */
    public function setTarifaHsStand($tarifa_hsStand)
    {
        $this->tarifa_hsStand = $tarifa_hsStand;

        return $this;
    }

    /**
     * Method to set the value of field tarifa_km
     *
     * @param integer $tarifa_km
     * @return $this
     */
    public function setTarifaKm($tarifa_km)
    {
        $this->tarifa_km = $tarifa_km;

        return $this;
    }

    /**
     * Returns the value of field tarifa_id
     *
     * @return integer
     */
    public function getTarifaId()
    {
        return $this->tarifa_id;
    }

    /**
     * Returns the value of field tarifa_horaInicial
     *
     * @return string
     */
    public function getTarifaHoraInicial()
    {
        return $this->tarifa_horaInicial;
    }

    /**
     * Returns the value of field tarifa_horaFinal
     *
     * @return string
     */
    public function getTarifaHoraFinal()
    {
        return $this->tarifa_horaFinal;
    }

    /**
     * Returns the value of field tarifa_hsServicio
     *
     * @return integer
     */
    public function getTarifaHsServicio()
    {
        return $this->tarifa_hsServicio;
    }

    /**
     * Returns the value of field tarifa_hsHidro
     *
     * @return integer
     */
    public function getTarifaHsHidro()
    {
        return $this->tarifa_hsHidro;
    }

    /**
     * Returns the value of field tarifa_hsMalacate
     *
     * @return integer
     */
    public function getTarifaHsMalacate()
    {
        return $this->tarifa_hsMalacate;
    }

    /**
     * Returns the value of field tarifa_hsStand
     *
     * @return integer
     */
    public function getTarifaHsStand()
    {
        return $this->tarifa_hsStand;
    }

    /**
     * Returns the value of field tarifa_km
     *
     * @return integer
     */
    public function getTarifaKm()
    {
        return $this->tarifa_km;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tarifa';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tarifa[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tarifa
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
