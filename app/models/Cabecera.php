<?php

class Cabecera extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $cabecera_id;

    /**
     *
     * @var string
     */
    protected $cabecera_nombre;

    /**
     *
     * @var integer
     */
    protected $cabecera_habilitado;

    /**
     *
     * @var string
     */
    protected $cabecera_fecha;



    /**
     * Method to set the value of field cabecera_id
     *
     * @param integer $cabecera_id
     * @return $this
     */
    public function setCabeceraId($cabecera_id)
    {
        $this->cabecera_id = $cabecera_id;

        return $this;
    }

    /**
     * Method to set the value of field cabecera_nombre
     *
     * @param string $cabecera_nombre
     * @return $this
     */
    public function setCabeceraNombre($cabecera_nombre)
    {
        $this->cabecera_nombre = $cabecera_nombre;

        return $this;
    }

    /**
     * Method to set the value of field cabecera_habilitado
     *
     * @param integer $cabecera_habilitado
     * @return $this
     */
    public function setCabeceraHabilitado($cabecera_habilitado)
    {
        $this->cabecera_habilitado = $cabecera_habilitado;

        return $this;
    }

    /**
     * Method to set the value of field cabecera_fecha
     *
     * @param string $cabecera_fecha
     * @return $this
     */
    public function setCabeceraFecha($cabecera_fecha)
    {
        $this->cabecera_fecha = $cabecera_fecha;

        return $this;
    }

    /**
     * Returns the value of field cabecera_id
     *
     * @return integer
     */
    public function getCabeceraId()
    {
        return $this->cabecera_id;
    }

    /**
     * Returns the value of field cabecera_nombre
     *
     * @return string
     */
    public function getCabeceraNombre()
    {
        return $this->cabecera_nombre;
    }

    /**
     * Returns the value of field cabecera_habilitado
     *
     * @return integer
     */
    public function getCabeceraHabilitado()
    {
        return $this->cabecera_habilitado;
    }

    /**
     * Returns the value of field cabecera_fecha
     *
     * @return string
     */
    public function getCabeceraFecha()
    {
        return $this->cabecera_fecha;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('cabecera_id', 'Columna', 'columna_cabeceraId', array('alias' => 'Columna'));
        $this->hasMany('cabecera_id', 'Planilla', 'planilla_cabeceraId', array('alias' => 'Planilla'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cabecera';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cabecera[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cabecera
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @param $nombre
     * @return cabecera_id
     */
    public static function guardar($nombre)
    {
        /*$cabecera = new Cabecera();
        $cabecera->setCabeceraFecha(date('Y-m-d'));
        $cabecera->setCabeceraHabilitado(1);
        $cabecera->setCabeceraNombre(strtoupper($nombre));
        if($cabecera->save())
        {

        }*/
    }
}
