<?php

class Sectores extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $sector_id;

    /**
     *
     * @var string
     */
    public $sector_nombre;

    /**
     *
     * @var integer
     */
    public $sector_activo;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('sector_id', 'Usuarios', 'usuario_sector', array('alias' => 'Usuarios'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'sectores';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sectores[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Sectores
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
