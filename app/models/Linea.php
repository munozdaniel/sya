<?php

class Linea extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $linea_id;

    /**
     *
     * @var string
     */
    protected $linea_nombre;

    /**
     *
     * @var integer
     */
    protected $linea_centroCosto;

    /**
     * Method to set the value of field linea_id
     *
     * @param integer $linea_id
     * @return $this
     */
    public function setLineaId($linea_id)
    {
        $this->linea_id = $linea_id;

        return $this;
    }

    /**
     * Method to set the value of field linea_nombre
     *
     * @param string $linea_nombre
     * @return $this
     */
    public function setLineaNombre($linea_nombre)
    {
        $this->linea_nombre = $linea_nombre;

        return $this;
    }

    /**
     * Method to set the value of field linea_centroCosto
     *
     * @param integer $linea_centroCosto
     * @return $this
     */
    public function setLineaCentroCosto($linea_centroCosto)
    {
        $this->linea_centroCosto = $linea_centroCosto;

        return $this;
    }

    /**
     * Returns the value of field linea_id
     *
     * @return integer
     */
    public function getLineaId()
    {
        return $this->linea_id;
    }

    /**
     * Returns the value of field linea_nombre
     *
     * @return string
     */
    public function getLineaNombre()
    {
        return $this->linea_nombre;
    }

    /**
     * Returns the value of field linea_centroCosto
     *
     * @return integer
     */
    public function getLineaCentroCosto()
    {
        return $this->linea_centroCosto;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'linea';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Linea[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Linea
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
