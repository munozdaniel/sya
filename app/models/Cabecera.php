<?php
$manager = new \Phalcon\Mvc\Model\Transaction\Manager();

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
     * Guarda una cabecera con las columnas basicas de una planilla.
     * Esta operación se utiliza cuando se guarda una planilla nueva.
     * @return boolean
     */
    public static function guardarCabeceraBasica($nombrePlanilla)
    {
        try {

            $manager = new \Phalcon\Mvc\Model\Transaction\Manager();
            $transaction = $manager->get();

            $cabecera = new Cabecera();
            $cabecera->setTransaction($transaction);

            $cabecera->setCabeceraNombre($nombrePlanilla);
            $cabecera->setCabeceraHabilitado(1);
            $cabecera->setCabeceraFecha(date('Y-m-d'));
            if (!$cabecera->save()) {
                $transaction->rollback("Ocurrió un problema al guardar la cabecera [Cabecera.php ln 200]");
                return false;
            }
            Columna::guardarColumnasBasica($cabecera->getCabeceraId());
            $transaction->commit();
            return true;
        } catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
            echo 'FALLO, motivo: ', $e->getMessage();
            return false;
        }
    }

    /**
     * Busca todas las cabeceras en orden descendente por id.
     * Devuelve un arreglo, cada elemento tiene un nombre y un valor.
     * Nombre es el nombre de la cabecera mas la fecha
     * Valor es el id de la cabecera.
     * @return array|null
     */
    public static function  findAllCabecera()
    {
        $cabeceras = Cabecera::find(array("order" => "cabecera_id DESC"));
        if ($cabeceras) {
            $retorno = array();
            foreach ($cabeceras as $cab) {
                $item = array();
                $item['nombre'] = $cab->getCabeceraNombre();
                $item['valor'] = $cab->getCabeceraId();
                $retorno[] = $item;
            }
        }else{
            $retorno = null;
        }
        return $retorno;

    }

    /**
     * Devuelve todas las columnas de una cabecera
     */
    public static function getTodasLasColumnasHabilitadas($cabecera_id){
        $columnas = Columna::find(array('columna_cabeceraId =:cabecera_id: AND columna_habilitado=1','bind'=>array('cabecera_id'=>$cabecera_id)));
        return $columnas;
    }
    /**
     * Devuelve todas las columnas de una cabecera
     */
    public static function getTodasLasColumnasDeshabilitadas($cabecera_id){
        $columnas = Columna::find(array('columna_cabeceraId =:cabecera_id: AND columna_habilitado=0','bind'=>array('cabecera_id'=>$cabecera_id)));
        return $columnas;
    }
    /**
     * Controla que no se repita el nombre de la cabecera. y que sea obligatorio
     * @return bool
     */
    public function validation()
    {
        $this->validate(new \Phalcon\Mvc\Model\Validator\Uniqueness(array(
            "field"   => "cabecera_nombre",
            "message" => "El nombre de la cabecera ya existe"
        )));
        $this->validate(new \Phalcon\Mvc\Model\Validator\PresenceOf(array(
            "field" => 'cabecera_nombre',
            "message" => 'El nombre de la cabecera es requerido'
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

}
