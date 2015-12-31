<?php

class Frs extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $frs_id;

    /**
     *
     * @var string
     */
    protected $frs_codigo;

    /**
     * Method to set the value of field frs_id
     *
     * @param integer $frs_id
     * @return $this
     */
    public function setFrsId($frs_id)
    {
        $this->frs_id = $frs_id;

        return $this;
    }

    /**
     * Method to set the value of field frs_codigo
     *
     * @param string $frs_codigo
     * @return $this
     */
    public function setFrsCodigo($frs_codigo)
    {
        $this->frs_codigo = $frs_codigo;

        return $this;
    }

    /**
     * Returns the value of field frs_id
     *
     * @return integer
     */
    public function getFrsId()
    {
        return $this->frs_id;
    }

    /**
     * Returns the value of field frs_codigo
     *
     * @return string
     */
    public function getFrsCodigo()
    {
        return $this->frs_codigo;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('frs_id', 'Cliente', 'cliente_frsId', array('alias' => 'Cliente'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'frs';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Frs[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Frs
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function validation()
    {

        $this->validate(
            new \Phalcon\Mvc\Model\Validator\Uniqueness(
                array(
                    "field"   => "frs_codigo",
                    "message" => "El Codigo FRS ya existe"
                )
            )
        );

        return $this->validationHasFailed() != true;
    }
}
