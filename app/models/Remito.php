<?php

class Remito extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $remito_id;

    /**
     *
     * @var integer
     */
    protected $remito_nro;

    /**
     *
     * @var integer
     */
    protected $remito_nroOrden;

    /**
     *
     * @var integer
     */
    protected $remito_tipo;

    /**
     *
     * @var integer
     */
    protected $remito_planillaId;

    /**
     *
     * @var integer
     */
    protected $remito_periodo;

    /**
     *
     * @var integer
     */
    protected $remito_transporteId;

    /**
     *
     * @var integer
     */
    protected $remito_tipoEquipoId;

    /**
     *
     * @var integer
     */
    protected $remito_tipoCargaId;

    /**
     *
     * @var integer
     */
    protected $remito_choferId;

    /**
     *
     * @var integer
     */
    protected $remito_viajeId;

    /**
     *
     * @var integer
     */
    protected $remito_concatenadoId;

    /**
     *
     * @var integer
     */
    protected $remito_tarifaId;

    /**
     *
     * @var integer
     */
    protected $remito_contenidoExtraId;

    /**
     *
     * @var integer
     */
    protected $remito_clienteId;

    /**
     *
     * @var integer
     */
    protected $remito_centroCostoId;

    /**
     *
     * @var integer
     */
    protected $remito_equipoPozoId;

    /**
     *
     * @var integer
     */
    protected $remito_operadoraId;

    /**
     *
     * @var integer
     */
    protected $remito_observacion;

    /**
     *
     * @var integer
     */
    protected $remito_pdf;

    /**
     *
     * @var string
     */
    protected $remito_fecha;

    /**
     *
     * @var string
     */
    protected $remito_fechaCreacion;

    /**
     *
     * @var string
     */
    protected $remito_conformidad;

    /**
     *
     * @var string
     */
    protected $remito_noConformidad;

    /**
     *
     * @var string
     */
    protected $remito_creadoPor;

    /**
     *
     * @var integer
     */
    protected $remito_habilitado;

    /**
     *
     * @var integer
     */
    protected $remito_ultima;

    /**
     * Method to set the value of field remito_id
     *
     * @param integer $remito_id
     * @return $this
     */
    public function setRemitoId($remito_id)
    {
        $this->remito_id = $remito_id;

        return $this;
    }

    /**
     * Method to set the value of field remito_nro
     *
     * @param integer $remito_nro
     * @return $this
     */
    public function setRemitoNro($remito_nro)
    {
        $this->remito_nro = $remito_nro;

        return $this;
    }

    /**
     * Method to set the value of field remito_nroOrden
     *
     * @param integer $remito_nroOrden
     * @return $this
     */
    public function setRemitoNroOrden($remito_nroOrden)
    {
        $this->remito_nroOrden = $remito_nroOrden;

        return $this;
    }

    /**
     * Method to set the value of field remito_tipo
     *
     * @param integer $remito_tipo
     * @return $this
     */
    public function setRemitoTipo($remito_tipo)
    {
        $this->remito_tipo = $remito_tipo;

        return $this;
    }

    /**
     * Method to set the value of field remito_planillaId
     *
     * @param integer $remito_planillaId
     * @return $this
     */
    public function setRemitoPlanillaId($remito_planillaId)
    {
        $this->remito_planillaId = $remito_planillaId;

        return $this;
    }

    /**
     * Method to set the value of field remito_periodo
     *
     * @param integer $remito_periodo
     * @return $this
     */
    public function setRemitoPeriodo($remito_periodo)
    {
        $this->remito_periodo = $remito_periodo;

        return $this;
    }

    /**
     * Method to set the value of field remito_transporteId
     *
     * @param integer $remito_transporteId
     * @return $this
     */
    public function setRemitoTransporteId($remito_transporteId)
    {
        $this->remito_transporteId = $remito_transporteId;

        return $this;
    }

    /**
     * Method to set the value of field remito_tipoEquipoId
     *
     * @param integer $remito_tipoEquipoId
     * @return $this
     */
    public function setRemitoTipoEquipoId($remito_tipoEquipoId)
    {
        $this->remito_tipoEquipoId = $remito_tipoEquipoId;

        return $this;
    }

    /**
     * Method to set the value of field remito_tipoCargaId
     *
     * @param integer $remito_tipoCargaId
     * @return $this
     */
    public function setRemitoTipoCargaId($remito_tipoCargaId)
    {
        $this->remito_tipoCargaId = $remito_tipoCargaId;

        return $this;
    }

    /**
     * Method to set the value of field remito_choferId
     *
     * @param integer $remito_choferId
     * @return $this
     */
    public function setRemitoChoferId($remito_choferId)
    {
        $this->remito_choferId = $remito_choferId;

        return $this;
    }

    /**
     * Method to set the value of field remito_viajeId
     *
     * @param integer $remito_viajeId
     * @return $this
     */
    public function setRemitoViajeId($remito_viajeId)
    {
        $this->remito_viajeId = $remito_viajeId;

        return $this;
    }

    /**
     * Method to set the value of field remito_concatenadoId
     *
     * @param integer $remito_concatenadoId
     * @return $this
     */
    public function setRemitoConcatenadoId($remito_concatenadoId)
    {
        $this->remito_concatenadoId = $remito_concatenadoId;

        return $this;
    }

    /**
     * Method to set the value of field remito_tarifaId
     *
     * @param integer $remito_tarifaId
     * @return $this
     */
    public function setRemitoTarifaId($remito_tarifaId)
    {
        $this->remito_tarifaId = $remito_tarifaId;

        return $this;
    }

    /**
     * Method to set the value of field remito_contenidoExtraId
     *
     * @param integer $remito_contenidoExtraId
     * @return $this
     */
    public function setRemitoContenidoExtraId($remito_contenidoExtraId)
    {
        $this->remito_contenidoExtraId = $remito_contenidoExtraId;

        return $this;
    }

    /**
     * Method to set the value of field remito_clienteId
     *
     * @param integer $remito_clienteId
     * @return $this
     */
    public function setRemitoClienteId($remito_clienteId)
    {
        $this->remito_clienteId = $remito_clienteId;

        return $this;
    }

    /**
     * Method to set the value of field remito_centroCostoId
     *
     * @param integer $remito_centroCostoId
     * @return $this
     */
    public function setRemitoCentroCostoId($remito_centroCostoId)
    {
        $this->remito_centroCostoId = $remito_centroCostoId;

        return $this;
    }

    /**
     * Method to set the value of field remito_equipoPozoId
     *
     * @param integer $remito_equipoPozoId
     * @return $this
     */
    public function setRemitoEquipoPozoId($remito_equipoPozoId)
    {
        $this->remito_equipoPozoId = $remito_equipoPozoId;

        return $this;
    }

    /**
     * Method to set the value of field remito_operadoraId
     *
     * @param integer $remito_operadoraId
     * @return $this
     */
    public function setRemitoOperadoraId($remito_operadoraId)
    {
        $this->remito_operadoraId = $remito_operadoraId;

        return $this;
    }

    /**
     * Method to set the value of field remito_observacion
     *
     * @param integer $remito_observacion
     * @return $this
     */
    public function setRemitoObservacion($remito_observacion)
    {
        $this->remito_observacion = $remito_observacion;

        return $this;
    }

    /**
     * Method to set the value of field remito_pdf
     *
     * @param integer $remito_pdf
     * @return $this
     */
    public function setRemitoPdf($remito_pdf)
    {
        $this->remito_pdf = $remito_pdf;

        return $this;
    }

    /**
     * Method to set the value of field remito_fecha
     *
     * @param string $remito_fecha
     * @return $this
     */
    public function setRemitoFecha($remito_fecha)
    {
        $this->remito_fecha = $remito_fecha;

        return $this;
    }

    /**
     * Method to set the value of field remito_fechaCreacion
     *
     * @param string $remito_fechaCreacion
     * @return $this
     */
    public function setRemitoFechaCreacion($remito_fechaCreacion)
    {
        $this->remito_fechaCreacion = $remito_fechaCreacion;

        return $this;
    }

    /**
     * Method to set the value of field remito_conformidad
     *
     * @param string $remito_conformidad
     * @return $this
     */
    public function setRemitoConformidad($remito_conformidad)
    {
        $this->remito_conformidad = $remito_conformidad;

        return $this;
    }

    /**
     * Method to set the value of field remito_noConformidad
     *
     * @param string $remito_noConformidad
     * @return $this
     */
    public function setRemitoNoConformidad($remito_noConformidad)
    {
        $this->remito_noConformidad = $remito_noConformidad;

        return $this;
    }

    /**
     * Method to set the value of field remito_creadoPor
     *
     * @param string $remito_creadoPor
     * @return $this
     */
    public function setRemitoCreadoPor($remito_creadoPor)
    {
        $this->remito_creadoPor = $remito_creadoPor;

        return $this;
    }

    /**
     * Method to set the value of field remito_habilitado
     *
     * @param integer $remito_habilitado
     * @return $this
     */
    public function setRemitoHabilitado($remito_habilitado)
    {
        $this->remito_habilitado = $remito_habilitado;

        return $this;
    }

    /**
     * Method to set the value of field remito_ultima
     *
     * @param integer $remito_ultima
     * @return $this
     */
    public function setRemitoUltima($remito_ultima)
    {
        $this->remito_ultima = $remito_ultima;

        return $this;
    }

    /**
     * Returns the value of field remito_id
     *
     * @return integer
     */
    public function getRemitoId()
    {
        return $this->remito_id;
    }

    /**
     * Returns the value of field remito_nro
     *
     * @return integer
     */
    public function getRemitoNro()
    {
        return $this->remito_nro;
    }

    /**
     * Returns the value of field remito_nroOrden
     *
     * @return integer
     */
    public function getRemitoNroOrden()
    {
        return $this->remito_nroOrden;
    }

    /**
     * Returns the value of field remito_tipo
     *
     * @return integer
     */
    public function getRemitoTipo()
    {
        return $this->remito_tipo;
    }

    /**
     * Returns the value of field remito_planillaId
     *
     * @return integer
     */
    public function getRemitoPlanillaId()
    {
        return $this->remito_planillaId;
    }

    /**
     * Returns the value of field remito_periodo
     *
     * @return integer
     */
    public function getRemitoPeriodo()
    {
        return $this->remito_periodo;
    }

    /**
     * Returns the value of field remito_transporteId
     *
     * @return integer
     */
    public function getRemitoTransporteId()
    {
        return $this->remito_transporteId;
    }

    /**
     * Returns the value of field remito_tipoEquipoId
     *
     * @return integer
     */
    public function getRemitoTipoEquipoId()
    {
        return $this->remito_tipoEquipoId;
    }

    /**
     * Returns the value of field remito_tipoCargaId
     *
     * @return integer
     */
    public function getRemitoTipoCargaId()
    {
        return $this->remito_tipoCargaId;
    }

    /**
     * Returns the value of field remito_choferId
     *
     * @return integer
     */
    public function getRemitoChoferId()
    {
        return $this->remito_choferId;
    }

    /**
     * Returns the value of field remito_viajeId
     *
     * @return integer
     */
    public function getRemitoViajeId()
    {
        return $this->remito_viajeId;
    }

    /**
     * Returns the value of field remito_concatenadoId
     *
     * @return integer
     */
    public function getRemitoConcatenadoId()
    {
        return $this->remito_concatenadoId;
    }

    /**
     * Returns the value of field remito_tarifaId
     *
     * @return integer
     */
    public function getRemitoTarifaId()
    {
        return $this->remito_tarifaId;
    }

    /**
     * Returns the value of field remito_contenidoExtraId
     *
     * @return integer
     */
    public function getRemitoContenidoExtraId()
    {
        return $this->remito_contenidoExtraId;
    }

    /**
     * Returns the value of field remito_clienteId
     *
     * @return integer
     */
    public function getRemitoClienteId()
    {
        return $this->remito_clienteId;
    }

    /**
     * Returns the value of field remito_centroCostoId
     *
     * @return integer
     */
    public function getRemitoCentroCostoId()
    {
        return $this->remito_centroCostoId;
    }

    /**
     * Returns the value of field remito_equipoPozoId
     *
     * @return integer
     */
    public function getRemitoEquipoPozoId()
    {
        return $this->remito_equipoPozoId;
    }

    /**
     * Returns the value of field remito_operadoraId
     *
     * @return integer
     */
    public function getRemitoOperadoraId()
    {
        return $this->remito_operadoraId;
    }

    /**
     * Returns the value of field remito_observacion
     *
     * @return integer
     */
    public function getRemitoObservacion()
    {
        return $this->remito_observacion;
    }

    /**
     * Returns the value of field remito_pdf
     *
     * @return integer
     */
    public function getRemitoPdf()
    {
        return $this->remito_pdf;
    }

    /**
     * Returns the value of field remito_fecha
     *
     * @return string
     */
    public function getRemitoFecha()
    {
        return $this->remito_fecha;
    }

    /**
     * Returns the value of field remito_fechaCreacion
     *
     * @return string
     */
    public function getRemitoFechaCreacion()
    {
        return $this->remito_fechaCreacion;
    }

    /**
     * Returns the value of field remito_conformidad
     *
     * @return string
     */
    public function getRemitoConformidad()
    {
        return $this->remito_conformidad;
    }

    /**
     * Returns the value of field remito_noConformidad
     *
     * @return string
     */
    public function getRemitoNoConformidad()
    {
        return $this->remito_noConformidad;
    }

    /**
     * Returns the value of field remito_creadoPor
     *
     * @return string
     */
    public function getRemitoCreadoPor()
    {
        return $this->remito_creadoPor;
    }

    /**
     * Returns the value of field remito_habilitado
     *
     * @return integer
     */
    public function getRemitoHabilitado()
    {
        return $this->remito_habilitado;
    }

    /**
     * Returns the value of field remito_ultima
     *
     * @return integer
     */
    public function getRemitoUltima()
    {
        return $this->remito_ultima;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('remito_planillaId', 'Planilla', 'planilla_id', array('alias' => 'Planilla'));
        $this->belongsTo('remito_clienteId', 'Cliente', 'cliente_id', array('alias' => 'Cliente'));
        $this->belongsTo('remito_centroCostoId', 'Centrocosto', 'centroCosto_id', array('alias' => 'Centrocosto'));
        $this->belongsTo('remito_equipoPozoId', 'Equipopozo', 'equipoPozo_id', array('alias' => 'Equipopozo'));
        $this->belongsTo('remito_operadoraId', 'Operadora', 'operadora_id', array('alias' => 'Operadora'));
        $this->belongsTo('remito_transporteId', 'Transporte', 'transporte_id', array('alias' => 'Transporte'));
        $this->belongsTo('remito_tipoEquipoId', 'Tipoequipo', 'tipoEquipo_id', array('alias' => 'Tipoequipo'));
        $this->belongsTo('remito_tipoCargaId', 'Tipocarga', 'tipoCarga_id', array('alias' => 'Tipocarga'));
        $this->belongsTo('remito_choferId', 'Chofer', 'chofer_id', array('alias' => 'Chofer'));
        $this->belongsTo('remito_viajeId', 'Viaje', 'viaje_id', array('alias' => 'Viaje'));
        $this->belongsTo('remito_concatenadoId', 'Concatenado', 'concatenado_id', array('alias' => 'Concatenado'));
        $this->belongsTo('remito_tarifaId', 'Tarifa', 'tarifa_id', array('alias' => 'Tarifa'));
        $this->belongsTo('remito_contenidoExtraId', 'Contenidoextra', 'contenidoExtra_id', array('alias' => 'Contenidoextra'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'remito';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Remito[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Remito
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
