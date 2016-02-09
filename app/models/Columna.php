<?php

class Columna extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $columna_id;

    /**
     *
     * @var integer
     */
    protected $columna_nombre;

    /**
     *
     * @var integer
     */
    protected $columna_clave;

    /**
     *
     * @var integer
     */
    protected $columna_posicion;

    /**
     *
     * @var integer
     */
    protected $columna_extra;

    /**
     *
     * @var integer
     */
    protected $columna_cabeceraId;

    /**
     *
     * @var integer
     */
    protected $columna_habilitado;


    /**
     * Method to set the value of field columna_id
     *
     * @param integer $columna_id
     * @return $this
     */
    public function setColumnaId($columna_id)
    {
        $this->columna_id = $columna_id;

        return $this;
    }

    /**
     * Method to set the value of field columna_nombre
     *
     * @param integer $columna_nombre
     * @return $this
     */
    public function setColumnaNombre($columna_nombre)
    {
        $this->columna_nombre = $columna_nombre;

        return $this;
    }

    /**
     * Method to set the value of field columna_clave
     *
     * @param integer $columna_clave
     * @return $this
     */
    public function setColumnaClave($columna_clave)
    {
        $this->columna_clave = $columna_clave;

        return $this;
    }

    /**
     * Method to set the value of field columna_posicion
     *
     * @param integer $columna_posicion
     * @return $this
     */
    public function setColumnaPosicion($columna_posicion)
    {
        $this->columna_posicion = $columna_posicion;

        return $this;
    }

    /**
     * Method to set the value of field columna_extra
     *
     * @param integer $columna_extra
     * @return $this
     */
    public function setColumnaExtra($columna_extra)
    {
        $this->columna_extra = $columna_extra;

        return $this;
    }

    /**
     * Method to set the value of field columna_cabeceraId
     *
     * @param integer $columna_cabeceraId
     * @return $this
     */
    public function setColumnaCabeceraId($columna_cabeceraId)
    {
        $this->columna_cabeceraId = $columna_cabeceraId;

        return $this;
    }

    /**
     * Method to set the value of field columna_habilitado
     *
     * @param integer $columna_habilitado
     * @return $this
     */
    public function setColumnaHabilitado($columna_habilitado)
    {
        $this->columna_habilitado = $columna_habilitado;

        return $this;
    }

    /**
     * Returns the value of field columna_id
     *
     * @return integer
     */
    public function getColumnaId()
    {
        return $this->columna_id;
    }

    /**
     * Returns the value of field columna_nombre
     *
     * @return integer
     */
    public function getColumnaNombre()
    {
        return $this->columna_nombre;
    }

    /**
     * Returns the value of field columna_clave
     *
     * @return integer
     */
    public function getColumnaClave()
    {
        return $this->columna_clave;
    }

    /**
     * Returns the value of field columna_posicion
     *
     * @return integer
     */
    public function getColumnaPosicion()
    {
        return $this->columna_posicion;
    }

    /**
     * Returns the value of field columna_extra
     *
     * @return integer
     */
    public function getColumnaExtra()
    {
        return $this->columna_extra;
    }

    /**
     * Returns the value of field columna_cabeceraId
     *
     * @return integer
     */
    public function getColumnaCabeceraId()
    {
        return $this->columna_cabeceraId;
    }

    /**
     * Returns the value of field columna_habilitado
     *
     * @return integer
     */
    public function getColumnaHabilitado()
    {
        return $this->columna_habilitado;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('columna_id', 'Contenidoextra', 'contenidoExtra_columnaId', array('alias' => 'Contenidoextra'));
        $this->belongsTo('columna_cabeceraId', 'Cabecera', 'cabecera_id', array('alias' => 'Cabecera'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'columna';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columna[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columna
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Guarda las columnas basicas de una planilla.
     * Esta operación se utiliza cuando se genera una cabeceraBasica
     * FIXME: Muy vinculado al codigo, si cambian los nombres de los atributos en la bd, tengo que cambiar aca.
     */
    public static function guardarColumnasBasica($cabecera_id)
    {
        try {

            $manager = new \Phalcon\Mvc\Model\Transaction\Manager();
            $transaction = $manager->get();

            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(1);
            $columna->setColumnaNombre('ORDEN');
            $columna->setColumnaClave('remito_nroOrden');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(2);
            $columna->setColumnaNombre('REMITO');
            $columna->setColumnaClave('remito_nro');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(3);
            $columna->setColumnaNombre('PATENTE');
            $columna->setColumnaClave('transporte_dominio');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(4);
            $columna->setColumnaNombre('N° INTERNO');
            $columna->setColumnaClave('transporte_nroInterno');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(5);
            $columna->setColumnaNombre('TIPO EQUIPO');
            $columna->setColumnaClave('tipoEquipo_nombre');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(6);
            $columna->setColumnaNombre('TIPO CARGA');
            $columna->setColumnaClave('tipoCarga_nombre');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(7);
            $columna->setColumnaNombre('DNI');
            $columna->setColumnaClave('chofer_dni');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(8);
            $columna->setColumnaNombre('CHOFER');
            $columna->setColumnaClave('chofer_nombreCompleto');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(9);
            $columna->setColumnaNombre('FECHA');
            $columna->setColumnaClave('remito_fecha');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(10);
            $columna->setColumnaNombre('CLIENTE');
            $columna->setColumnaClave('cliente_nombre');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(11);
            $columna->setColumnaNombre('ORIGEN');
            $columna->setColumnaClave('viaje_origen');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(12);
            $columna->setColumnaNombre('DESTINO');
            $columna->setColumnaClave('yacimient_destino');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(13);
            $columna->setColumnaNombre('EQUIPO/POZO');
            $columna->setColumnaClave('equipoPozo_nombre');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('CONCATENADO');
            $columna->setColumnaClave('concatenado_nombre');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('OPERADORA');
            $columna->setColumnaClave('operadora_nombre');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('LINEA-PSL');
            $columna->setColumnaClave('linea_nombre');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('CENTRO COSTO');
            $columna->setColumnaClave('centroCosto_codigo');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('OBSERVACIONES');
            $columna->setColumnaClave('remito_observacion');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('KM');
            $columna->setColumnaClave('tarifa_km');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('HS HIDRO/MALACATE');
            $columna->setColumnaClave('tarifa_hsHidro');//Ahora esta unificado con las hsMalacate FIXME
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*//*
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('HS MOV Y DESMOV');
            $columna->setColumnaClave('tarifa_movDesmov');//Ahora esta unificado
            $columna->setColumnaHabilitado(1);
            if(!$columna->save()){
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }*/
            /*=================================*/
            /* $columna = new Columna();
             $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
             $columna->setColumnaPosicion(14);
             $columna->setColumnaNombre('HS CARGA/DESCARGA');
             $columna->setColumnaClave('tarifa_cargaDescarga');
             $columna->setColumnaHabilitado(1);
             $columna->save();*/
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('HS DE ESPERA');
            $columna->setColumnaClave('tarifa_hsStand');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('HS TOTAL SERVICIO');
            $columna->setColumnaClave('tarifa_hsServicio');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('CONFORMIDAD RE');
            $columna->setColumnaClave('remito_conformidad');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('MOT NO CONFORM RE');
            $columna->setColumnaClave('remito_noConformidad');
            $columna->setColumnaHabilitado(1);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                return false;
            }
            /*=================================*/
            $transaction->commit();
            return true;
        } catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
            echo 'FALLO, motivo: ', $e->getMessage();
        }
    }
}
