<?php

class Planilla extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $planilla_id;

    /**
     *
     * @var string
     */
    protected $planilla_nombreCliente;

    /**
     *
     * @var string
     */
    protected $planilla_fecha;

    /**
     *
     * @var integer
     */
    protected $planilla_armada;

    /**
     *
     * @var integer
     */
    protected $planilla_cabeceraId;
    /**
     *
     * @var integer
     */
    protected $planilla_descripcion;

    /**
     *
     * @var integer
     */
    protected $planilla_habilitado;

    /**
     * Method to set the value of field planilla_id
     *
     * @param integer $planilla_id
     * @return $this
     */
    public function setPlanillaId($planilla_id)
    {
        $this->planilla_id = $planilla_id;

        return $this;
    }

    /**
     * Method to set the value of field planilla_nombreCliente
     *
     * @param string $planilla_nombreCliente
     * @return $this
     */
    public function setPlanillaNombreCliente($planilla_nombreCliente)
    {
        $this->planilla_nombreCliente = $planilla_nombreCliente;

        return $this;
    }

    /**
     * Method to set the value of field planilla_fecha
     *
     * @param string $planilla_fecha
     * @return $this
     */
    public function setPlanillaFecha($planilla_fecha)
    {
        $this->planilla_fecha = $planilla_fecha;

        return $this;
    }

    /**
     * Method to set the value of field planilla_armada
     *
     * @param integer $planilla_armada
     * @return $this
     */
    public function setPlanillaArmada($planilla_armada)
    {
        $this->planilla_armada = $planilla_armada;

        return $this;
    }

    /**
     * Method to set the value of field planilla_cabeceraId
     *
     * @param integer $planilla_cabeceraId
     * @return $this
     */
    public function setPlanillaCabeceraId($planilla_cabeceraId)
    {
        $this->planilla_cabeceraId = $planilla_cabeceraId;

        return $this;
    }

    /**
     * Method to set the value of field planilla_habilitado
     *
     * @param integer $planilla_habilitado
     * @return $this
     */
    public function setPlanillaHabilitado($planilla_habilitado)
    {
        $this->planilla_habilitado = $planilla_habilitado;

        return $this;
    }

    /**
     * Returns the value of field planilla_id
     *
     * @return integer
     */
    public function getPlanillaId()
    {
        return $this->planilla_id;
    }

    /**
     * Returns the value of field planilla_nombreCliente
     *
     * @return string
     */
    public function getPlanillaNombreCliente()
    {
        return $this->planilla_nombreCliente;
    }

    /**
     * Returns the value of field planilla_fecha
     *
     * @return string
     */
    public function getPlanillaFecha()
    {
        return $this->planilla_fecha;
    }

    /**
     * Returns the value of field planilla_armada
     *
     * @return integer
     */
    public function getPlanillaArmada()
    {
        return $this->planilla_armada;
    }

    /**
     * Returns the value of field planilla_cabeceraId
     *
     * @return integer
     */
    public function getPlanillaCabeceraId()
    {
        return $this->planilla_cabeceraId;
    }

    /**
     * Returns the value of field planilla_habilitado
     *
     * @return integer
     */
    public function getPlanillaHabilitado()
    {
        return $this->planilla_habilitado;
    }
    /**
     * Returns the value of field planilla_descripcion
     *
     * @return integer
     */
    public function getPlanillaDescripcion()
    {
        return $this->planilla_descripcion;
    }
    public function setPlanillaDescripcion($planilla_descripcion)
    {
        $this->planilla_descripcion=$planilla_descripcion;
    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('planilla_id', 'Remito', 'remito_planillaId', array('alias' => 'Remito'));
        $this->belongsTo('planilla_cabeceraId', 'Cabecera', 'cabecera_id', array('alias' => 'Cabecera'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'planilla';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Planilla[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Planilla
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function validation()
    {
        $this->validate(new \Phalcon\Mvc\Model\Validator\Uniqueness(array(
            "field"   => "planilla_nombreCliente",
            "message" => "La Planilla ya existe"
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
