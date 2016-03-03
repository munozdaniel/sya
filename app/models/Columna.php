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
            $data['success']=true;
            $data['mensaje']="Operación Exitosa";
            $retorno=array();
            $manager = new \Phalcon\Mvc\Model\Transaction\Manager();
            $transaction = $manager->get();

            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(1);
            $columna->setColumnaNombre('ORDEN');
            $columna->setColumnaClave('Remito.remito_nroOrden');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
                $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(2);
            $columna->setColumnaNombre('REMITO');
            $columna->setColumnaClave('Remito.remito_nro');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(3);
            $columna->setColumnaNombre('PATENTE');
            $columna->setColumnaClave('Transporte.transporte_dominio');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(4);
            $columna->setColumnaNombre('N° INTERNO');
            $columna->setColumnaClave('Transporte.transporte_nroInterno');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(5);
            $columna->setColumnaNombre('TIPO EQUIPO');
            $columna->setColumnaClave('Tipoequipo.tipoEquipo_nombre');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(6);
            $columna->setColumnaNombre('TIPO CARGA');
            $columna->setColumnaClave('Tipocarga.tipoCarga_nombre');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(7);
            $columna->setColumnaNombre('DNI');
            $columna->setColumnaClave('Chofer.chofer_dni');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(8);
            $columna->setColumnaNombre('CHOFER');
            $columna->setColumnaClave('Chofer.chofer_nombreCompleto');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(9);
            $columna->setColumnaNombre('FECHA');
            $columna->setColumnaClave('DATE_FORMAT(Remito.remito_fecha, \'%d/%m/%Y\')');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(10);
            $columna->setColumnaNombre('CLIENTE');
            $columna->setColumnaClave('Cliente.cliente_nombre');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(11);
            $columna->setColumnaNombre('ORIGEN');
            $columna->setColumnaClave('Viaje.viaje_origen');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(12);
            $columna->setColumnaNombre('DESTINO');
            $columna->setColumnaClave('Yacimiento.yacimiento_destino');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(13);
            $columna->setColumnaNombre('EQUIPO/POZO');
            $columna->setColumnaClave('Equipopozo.equipoPozo_nombre');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(14);
            $columna->setColumnaNombre('CONCATENADO');
            $columna->setColumnaClave('Concatenado.concatenado_nombre');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(15);
            $columna->setColumnaNombre('OPERADORA');
            $columna->setColumnaClave('Operadora.operadora_nombre');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(16);
            $columna->setColumnaNombre('LINEA-PSL');
            $columna->setColumnaClave('Linea.linea_nombre');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(17);
            $columna->setColumnaNombre('CENTRO COSTO');
            $columna->setColumnaClave('Centrocosto.centroCosto_codigo');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(18);
            $columna->setColumnaNombre('OBSERVACIONES');
            $columna->setColumnaClave('Remito.remito_observacion');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(19);
            $columna->setColumnaNombre('KM');
            $columna->setColumnaClave('Tarifa.tarifa_km');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(20);
            $columna->setColumnaNombre('HS HIDRO');
            $columna->setColumnaClave('tarifa_hsHidro');//Ahora esta unificado con las hsMalacate FIXME
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(20);
            $columna->setColumnaNombre('HS MALACATE');
            $columna->setColumnaClave('Tarifa.tarifa_hsMalacate');//Ahora esta unificado con las hsMalacate FIXME
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(21);
            $columna->setColumnaNombre('HS DE ESPERA');
            $columna->setColumnaClave('Tarifa.tarifa_hsStand');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(22);
            $columna->setColumnaNombre('HS TOTAL SERVICIO');
            $columna->setColumnaClave('Tarifa.tarifa_hsServicio');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(23);
            $columna->setColumnaNombre('CONFORMIDAD RE');
            $columna->setColumnaClave('Remito.remito_conformidad');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $columna = new Columna();
            $columna->setTransaction($transaction);
            $columna->setColumnaCabeceraId($cabecera_id);
            $columna->setColumnaPosicion(24);
            $columna->setColumnaNombre('MOT NO CONFORM RE');
            $columna->setColumnaClave('Remito.remito_noConformidad');
            $columna->setColumnaHabilitado(1);
            $columna->setColumnaExtra(0);
            if (!$columna->save()) {
               $transaction->rollback("Ocurrió un problema al guardar una columna");
                $data['mensaje']= "Ocurrio un problema al guardar la columna";
                $data['success']=false;
                return $data;
            }
            $retorno[]=array('columna_id'=>$columna->getColumnaId(),'columna_nombre'=>$columna->getColumnaNombre());

            /*=================================*/
            $transaction->commit();
            $data['columnas']=$retorno;
            return $data;
        } catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
            echo 'FALLO, motivo: ', $e->getMessage();
        }
    }
    /**
     * Busca todas las columnas por id (extras y no extra), y las devuelve
     * @param $cabecera_id
     * @return array|Columna[]
     */
    public static function verColumnasOrdenadasByCabeceraId($cabecera_id)
    {
        //Busco todas las columnas para armar el th ordenadamente
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 ORDER BY columna_posicion DESC",
            'bind'=>array('cabecera_id'=>$cabecera_id)
        ));
        if($columnas)
            return $columnas;
        return null;
    }

    /**
     * Busca todas las columnas extras por id.
     * @param $cabecera_id
     * @return array|Columna[]
     */
    public static function verColumnasExtrasOrdenadasByCabeceraId($cabecera_id)
    {
        //Busco todas las columnas para armar el th ordenadamente
        $columnas = Columna::find(array(
            "columna_cabeceraId=:cabecera_id: AND columna_habilitado = 1 AND columna_extra = 1 ORDER BY columna_posicion ASC",
            'bind'=>array('cabecera_id'=>$cabecera_id)
        ));
        if($columnas)
            return $columnas;
        return null;    }

}
