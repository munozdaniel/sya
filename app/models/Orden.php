<?php

class Orden extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $orden_id;

    /**
     *
     * @var integer
     */
    protected $orden_planillaId;

    /**
     *
     * @var integer
     */
    protected $orden_periodo;

    /**
     *
     * @var integer
     */
    protected $orden_transporteId;

    /**
     *
     * @var integer
     */
    protected $orden_tipoEquipoId;

    /**
     *
     * @var integer
     */
    protected $orden_tipoCargaId;

    /**
     *
     * @var integer
     */
    protected $orden_choferId;

    /**
     *
     * @var integer
     */
    protected $orden_clienteId;

    /**
     *
     * @var integer
     */
    protected $orden_viajeId;

    /**
     *
     * @var integer
     */
    protected $orden_concatenadoId;

    /**
     *
     * @var integer
     */
    protected $orden_tarifaId;

    /**
     *
     * @var integer
     */
    protected $orden_contenidoExtraId;

    /**
     *
     * @var string
     */
    protected $orden_observacion;

    /**
     *
     * @var string
     */
    protected $orden_fecha;

    /**
     *
     * @var string
     */
    protected $orden_fechaCreacion;

    /**
     *
     * @var string
     */
    protected $orden_conformidad;

    /**
     *
     * @var string
     */
    protected $orden_noConformidad;

    /**
     *
     * @var integer
     */
    protected $orden_creadoPor;

    /**
     *
     * @var integer
     */
    protected $orden_habilitado;

    /**
     * Method to set the value of field orden_id
     *
     * @param integer $orden_id
     * @return $this
     */
    public function setOrdenId($orden_id)
    {
        $this->orden_id = $orden_id;

        return $this;
    }

    /**
     * Method to set the value of field orden_planillaId
     *
     * @param integer $orden_planillaId
     * @return $this
     */
    public function setOrdenPlanillaId($orden_planillaId)
    {
        $this->orden_planillaId = $orden_planillaId;

        return $this;
    }

    /**
     * Method to set the value of field orden_periodo
     *
     * @param integer $orden_periodo
     * @return $this
     */
    public function setOrdenPeriodo($orden_periodo)
    {
        $this->orden_periodo = $orden_periodo;

        return $this;
    }

    /**
     * Method to set the value of field orden_transporteId
     *
     * @param integer $orden_transporteId
     * @return $this
     */
    public function setOrdenTransporteId($orden_transporteId)
    {
        $this->orden_transporteId = $orden_transporteId;

        return $this;
    }

    /**
     * Method to set the value of field orden_tipoEquipoId
     *
     * @param integer $orden_tipoEquipoId
     * @return $this
     */
    public function setOrdenTipoEquipoId($orden_tipoEquipoId)
    {
        $this->orden_tipoEquipoId = $orden_tipoEquipoId;

        return $this;
    }

    /**
     * Method to set the value of field orden_tipoCargaId
     *
     * @param integer $orden_tipoCargaId
     * @return $this
     */
    public function setOrdenTipoCargaId($orden_tipoCargaId)
    {
        $this->orden_tipoCargaId = $orden_tipoCargaId;

        return $this;
    }

    /**
     * Method to set the value of field orden_choferId
     *
     * @param integer $orden_choferId
     * @return $this
     */
    public function setOrdenChoferId($orden_choferId)
    {
        $this->orden_choferId = $orden_choferId;

        return $this;
    }

    /**
     * Method to set the value of field orden_clienteId
     *
     * @param integer $orden_clienteId
     * @return $this
     */
    public function setOrdenClienteId($orden_clienteId)
    {
        $this->orden_clienteId = $orden_clienteId;

        return $this;
    }

    /**
     * Method to set the value of field orden_viajeId
     *
     * @param integer $orden_viajeId
     * @return $this
     */
    public function setOrdenViajeId($orden_viajeId)
    {
        $this->orden_viajeId = $orden_viajeId;

        return $this;
    }

    /**
     * Method to set the value of field orden_concatenadoId
     *
     * @param integer $orden_concatenadoId
     * @return $this
     */
    public function setOrdenConcatenadoId($orden_concatenadoId)
    {
        $this->orden_concatenadoId = $orden_concatenadoId;

        return $this;
    }

    /**
     * Method to set the value of field orden_tarifaId
     *
     * @param integer $orden_tarifaId
     * @return $this
     */
    public function setOrdenTarifaId($orden_tarifaId)
    {
        $this->orden_tarifaId = $orden_tarifaId;

        return $this;
    }

    /**
     * Method to set the value of field orden_contenidoExtraId
     *
     * @param integer $orden_contenidoExtraId
     * @return $this
     */
    public function setOrdenContenidoExtraId($orden_contenidoExtraId)
    {
        $this->orden_contenidoExtraId = $orden_contenidoExtraId;

        return $this;
    }

    /**
     * Method to set the value of field orden_observacion
     *
     * @param string $orden_observacion
     * @return $this
     */
    public function setOrdenObservacion($orden_observacion)
    {
        $this->orden_observacion = $orden_observacion;

        return $this;
    }

    /**
     * Method to set the value of field orden_fecha
     *
     * @param string $orden_fecha
     * @return $this
     */
    public function setOrdenFecha($orden_fecha)
    {
        $this->orden_fecha = $orden_fecha;

        return $this;
    }

    /**
     * Method to set the value of field orden_fechaCreacion
     *
     * @param string $orden_fechaCreacion
     * @return $this
     */
    public function setOrdenFechaCreacion($orden_fechaCreacion)
    {
        $this->orden_fechaCreacion = $orden_fechaCreacion;

        return $this;
    }

    /**
     * Method to set the value of field orden_conformidad
     *
     * @param string $orden_conformidad
     * @return $this
     */
    public function setOrdenConformidad($orden_conformidad)
    {
        $this->orden_conformidad = $orden_conformidad;

        return $this;
    }

    /**
     * Method to set the value of field orden_noConformidad
     *
     * @param string $orden_noConformidad
     * @return $this
     */
    public function setOrdenNoConformidad($orden_noConformidad)
    {
        $this->orden_noConformidad = $orden_noConformidad;

        return $this;
    }

    /**
     * Method to set the value of field orden_creadoPor
     *
     * @param integer $orden_creadoPor
     * @return $this
     */
    public function setOrdenCreadoPor($orden_creadoPor)
    {
        $this->orden_creadoPor = $orden_creadoPor;

        return $this;
    }

    /**
     * Method to set the value of field orden_habilitado
     *
     * @param integer $orden_habilitado
     * @return $this
     */
    public function setOrdenHabilitado($orden_habilitado)
    {
        $this->orden_habilitado = $orden_habilitado;

        return $this;
    }

    /**
     * Returns the value of field orden_id
     *
     * @return integer
     */
    public function getOrdenId()
    {
        return $this->orden_id;
    }

    /**
     * Returns the value of field orden_planillaId
     *
     * @return integer
     */
    public function getOrdenPlanillaId()
    {
        return $this->orden_planillaId;
    }

    /**
     * Returns the value of field orden_periodo
     *
     * @return integer
     */
    public function getOrdenPeriodo()
    {
        return $this->orden_periodo;
    }

    /**
     * Returns the value of field orden_transporteId
     *
     * @return integer
     */
    public function getOrdenTransporteId()
    {
        return $this->orden_transporteId;
    }

    /**
     * Returns the value of field orden_tipoEquipoId
     *
     * @return integer
     */
    public function getOrdenTipoEquipoId()
    {
        return $this->orden_tipoEquipoId;
    }

    /**
     * Returns the value of field orden_tipoCargaId
     *
     * @return integer
     */
    public function getOrdenTipoCargaId()
    {
        return $this->orden_tipoCargaId;
    }

    /**
     * Returns the value of field orden_choferId
     *
     * @return integer
     */
    public function getOrdenChoferId()
    {
        return $this->orden_choferId;
    }

    /**
     * Returns the value of field orden_clienteId
     *
     * @return integer
     */
    public function getOrdenClienteId()
    {
        return $this->orden_clienteId;
    }

    /**
     * Returns the value of field orden_viajeId
     *
     * @return integer
     */
    public function getOrdenViajeId()
    {
        return $this->orden_viajeId;
    }

    /**
     * Returns the value of field orden_concatenadoId
     *
     * @return integer
     */
    public function getOrdenConcatenadoId()
    {
        return $this->orden_concatenadoId;
    }

    /**
     * Returns the value of field orden_tarifaId
     *
     * @return integer
     */
    public function getOrdenTarifaId()
    {
        return $this->orden_tarifaId;
    }

    /**
     * Returns the value of field orden_contenidoExtraId
     *
     * @return integer
     */
    public function getOrdenContenidoExtraId()
    {
        return $this->orden_contenidoExtraId;
    }

    /**
     * Returns the value of field orden_observacion
     *
     * @return string
     */
    public function getOrdenObservacion()
    {
        return $this->orden_observacion;
    }

    /**
     * Returns the value of field orden_fecha
     *
     * @return string
     */
    public function getOrdenFecha()
    {
        return $this->orden_fecha;
    }

    /**
     * Returns the value of field orden_fechaCreacion
     *
     * @return string
     */
    public function getOrdenFechaCreacion()
    {
        return $this->orden_fechaCreacion;
    }

    /**
     * Returns the value of field orden_conformidad
     *
     * @return string
     */
    public function getOrdenConformidad()
    {
        return $this->orden_conformidad;
    }

    /**
     * Returns the value of field orden_noConformidad
     *
     * @return string
     */
    public function getOrdenNoConformidad()
    {
        return $this->orden_noConformidad;
    }

    /**
     * Returns the value of field orden_creadoPor
     *
     * @return integer
     */
    public function getOrdenCreadoPor()
    {
        return $this->orden_creadoPor;
    }

    /**
     * Returns the value of field orden_habilitado
     *
     * @return integer
     */
    public function getOrdenHabilitado()
    {
        return $this->orden_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('orden_planillaId', 'Planilla', 'planilla_id', array('alias' => 'Planilla'));
        $this->belongsTo('orden_concatenadoId', 'Concatenado', 'concatenado_id', array('alias' => 'Concatenado'));
        $this->belongsTo('orden_contenidoExtraId', 'Contenidoextra', 'contenidoExtra_id', array('alias' => 'Contenidoextra'));
        $this->belongsTo('orden_transporteId', 'Transporte', 'transporte_id', array('alias' => 'Transporte'));
        $this->belongsTo('orden_tipoEquipoId', 'Tipoequipo', 'tipoEquipo_id', array('alias' => 'Tipoequipo'));
        $this->belongsTo('orden_tipoCargaId', 'Tipocarga', 'tipoCarga_id', array('alias' => 'Tipocarga'));
        $this->belongsTo('orden_choferId', 'Chofer', 'chofer_id', array('alias' => 'Chofer'));
        $this->belongsTo('orden_clienteId', 'Cliente', 'cliente_id', array('alias' => 'Cliente'));
        $this->belongsTo('orden_viajeId', 'Viaje', 'viaje_id', array('alias' => 'Viaje'));
        $this->belongsTo('orden_tarifaId', 'Tarifa', 'tarifa_id', array('alias' => 'Tarifa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'orden';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Orden[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Orden
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
