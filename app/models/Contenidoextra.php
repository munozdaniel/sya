<?php

class Contenidoextra extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $contenidoExtra_id;

    /**
     *
     * @var string
     */
    protected $contenidoExtra_descripcion;

    /**
     *
     * @var integer
     */
    protected $contenidoExtra_habilitado;

    /**
     *
     * @var integer
     */
    protected $contenidoExtra_columnaId;

    /**
     *
     * @var integer
     */
    protected $contenidoExtra_remitoId;

    /**
     * Method to set the value of field contenidoExtra_id
     *
     * @param integer $contenidoExtra_id
     * @return $this
     */
    public function setContenidoExtraId($contenidoExtra_id)
    {
        $this->contenidoExtra_id = $contenidoExtra_id;

        return $this;
    }

    /**
     * Method to set the value of field contenidoExtra_descripcion
     *
     * @param string $contenidoExtra_descripcion
     * @return $this
     */
    public function setContenidoExtraDescripcion($contenidoExtra_descripcion)
    {
        $this->contenidoExtra_descripcion = $contenidoExtra_descripcion;

        return $this;
    }

    /**
     * Method to set the value of field contenidoExtra_habilitado
     *
     * @param integer $contenidoExtra_habilitado
     * @return $this
     */
    public function setContenidoExtraHabilitado($contenidoExtra_habilitado)
    {
        $this->contenidoExtra_habilitado = $contenidoExtra_habilitado;

        return $this;
    }

    /**
     * Method to set the value of field contenidoExtra_columnaId
     *
     * @param integer $contenidoExtra_columnaId
     * @return $this
     */
    public function setContenidoExtraColumnaId($contenidoExtra_columnaId)
    {
        $this->contenidoExtra_columnaId = $contenidoExtra_columnaId;

        return $this;
    }

    /**
     * Method to set the value of field contenidoExtra_remitoId
     *
     * @param integer $contenidoExtra_remitoId
     * @return $this
     */
    public function setContenidoExtraRemitoId($contenidoExtra_remitoId)
    {
        $this->contenidoExtra_remitoId = $contenidoExtra_remitoId;

        return $this;
    }

    /**
     * Returns the value of field contenidoExtra_id
     *
     * @return integer
     */
    public function getContenidoExtraId()
    {
        return $this->contenidoExtra_id;
    }

    /**
     * Returns the value of field contenidoExtra_descripcion
     *
     * @return string
     */
    public function getContenidoExtraDescripcion()
    {
        return $this->contenidoExtra_descripcion;
    }

    /**
     * Returns the value of field contenidoExtra_habilitado
     *
     * @return integer
     */
    public function getContenidoExtraHabilitado()
    {
        return $this->contenidoExtra_habilitado;
    }

    /**
     * Returns the value of field contenidoExtra_columnaId
     *
     * @return integer
     */
    public function getContenidoExtraColumnaId()
    {
        return $this->contenidoExtra_columnaId;
    }

    /**
     * Returns the value of field contenidoExtra_remitoId
     *
     * @return integer
     */
    public function getContenidoExtraRemitoId()
    {
        return $this->contenidoExtra_remitoId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('contenidoExtra_columnaId', 'Columna', 'columna_id', array('alias' => 'Columna'));
        $this->belongsTo('contenidoExtra_remitoId', 'Remito', 'remito_id', array('alias' => 'Remito'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'contenidoextra';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Contenidoextra[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Contenidoextra
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
