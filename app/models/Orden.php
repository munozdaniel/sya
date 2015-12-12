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
    protected $orden_planilla;

    /**
     *
     * @var integer
     */
    protected $orden_periodo;

    /**
     *
     * @var integer
     */
    protected $orden_transporte;

    /**
     *
     * @var integer
     */
    protected $orden_tipoEquipo;

    /**
     *
     * @var integer
     */
    protected $orden_tipoCarga;

    /**
     *
     * @var integer
     */
    protected $orden_chofer;

    /**
     *
     * @var integer
     */
    protected $orden_cliente;

    /**
     *
     * @var integer
     */
    protected $orden_viaje;

    /**
     *
     * @var integer
     */
    protected $orden_tarifa;

    /**
     *
     * @var integer
     */
    protected $orden_columnaExtra;

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
     * Method to set the value of field orden_planilla
     *
     * @param integer $orden_planilla
     * @return $this
     */
    public function setOrdenPlanilla($orden_planilla)
    {
        $this->orden_planilla = $orden_planilla;

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
     * Method to set the value of field orden_transporte
     *
     * @param integer $orden_transporte
     * @return $this
     */
    public function setOrdenTransporte($orden_transporte)
    {
        $this->orden_transporte = $orden_transporte;

        return $this;
    }

    /**
     * Method to set the value of field orden_tipoEquipo
     *
     * @param integer $orden_tipoEquipo
     * @return $this
     */
    public function setOrdenTipoEquipo($orden_tipoEquipo)
    {
        $this->orden_tipoEquipo = $orden_tipoEquipo;

        return $this;
    }

    /**
     * Method to set the value of field orden_tipoCarga
     *
     * @param integer $orden_tipoCarga
     * @return $this
     */
    public function setOrdenTipoCarga($orden_tipoCarga)
    {
        $this->orden_tipoCarga = $orden_tipoCarga;

        return $this;
    }

    /**
     * Method to set the value of field orden_chofer
     *
     * @param integer $orden_chofer
     * @return $this
     */
    public function setOrdenChofer($orden_chofer)
    {
        $this->orden_chofer = $orden_chofer;

        return $this;
    }

    /**
     * Method to set the value of field orden_cliente
     *
     * @param integer $orden_cliente
     * @return $this
     */
    public function setOrdenCliente($orden_cliente)
    {
        $this->orden_cliente = $orden_cliente;

        return $this;
    }

    /**
     * Method to set the value of field orden_viaje
     *
     * @param integer $orden_viaje
     * @return $this
     */
    public function setOrdenViaje($orden_viaje)
    {
        $this->orden_viaje = $orden_viaje;

        return $this;
    }

    /**
     * Method to set the value of field orden_tarifa
     *
     * @param integer $orden_tarifa
     * @return $this
     */
    public function setOrdenTarifa($orden_tarifa)
    {
        $this->orden_tarifa = $orden_tarifa;

        return $this;
    }

    /**
     * Method to set the value of field orden_columnaExtra
     *
     * @param integer $orden_columnaExtra
     * @return $this
     */
    public function setOrdenColumnaExtra($orden_columnaExtra)
    {
        $this->orden_columnaExtra = $orden_columnaExtra;

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
     * Returns the value of field orden_id
     *
     * @return integer
     */
    public function getOrdenId()
    {
        return $this->orden_id;
    }

    /**
     * Returns the value of field orden_planilla
     *
     * @return integer
     */
    public function getOrdenPlanilla()
    {
        return $this->orden_planilla;
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
     * Returns the value of field orden_transporte
     *
     * @return integer
     */
    public function getOrdenTransporte()
    {
        return $this->orden_transporte;
    }

    /**
     * Returns the value of field orden_tipoEquipo
     *
     * @return integer
     */
    public function getOrdenTipoEquipo()
    {
        return $this->orden_tipoEquipo;
    }

    /**
     * Returns the value of field orden_tipoCarga
     *
     * @return integer
     */
    public function getOrdenTipoCarga()
    {
        return $this->orden_tipoCarga;
    }

    /**
     * Returns the value of field orden_chofer
     *
     * @return integer
     */
    public function getOrdenChofer()
    {
        return $this->orden_chofer;
    }

    /**
     * Returns the value of field orden_cliente
     *
     * @return integer
     */
    public function getOrdenCliente()
    {
        return $this->orden_cliente;
    }

    /**
     * Returns the value of field orden_viaje
     *
     * @return integer
     */
    public function getOrdenViaje()
    {
        return $this->orden_viaje;
    }

    /**
     * Returns the value of field orden_tarifa
     *
     * @return integer
     */
    public function getOrdenTarifa()
    {
        return $this->orden_tarifa;
    }

    /**
     * Returns the value of field orden_columnaExtra
     *
     * @return integer
     */
    public function getOrdenColumnaExtra()
    {
        return $this->orden_columnaExtra;
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
