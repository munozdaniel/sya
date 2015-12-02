<?php

class Usuarios extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $usuario_id;

    /**
     *
     * @var string
     */
    public $usuario_nick;

    /**
     *
     * @var string
     */
    public $usuario_nombreCompleto;

    /**
     *
     * @var string
     */
    public $usuario_contrasenia;

    /**
     *
     * @var integer
     */
    public $usuario_sector;

    /**
     *
     * @var string
     */
    public $usuario_email;

    /**
     *
     * @var integer
     */
    public $usuario_activo;

    /**
     *
     * @var string
     */
    public $usuario_fechaCreacion;

    /**
     *
     * @var string
     */
    public $usuario_imagen;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('usuario_sector', 'Sectores', 'sector_id', array('alias' => 'Sectores'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuarios';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuarios
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
