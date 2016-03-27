<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 13/02/2016
 * Time: 05:42 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Hidden;
class RemitoForm  extends Form
{
    public function initialize($entity = null, $options = array())
    {
        /*Si el form es de creacion, los campos seran required. Viceversa.*/
        $required['clave']="";
        $required['valor']="";

        if(isset($options['required']))
        {
            $required['clave']="required";
            $required['valor']="true";
        }
        /*======================= ID ==============================*/
        if (!isset($options['edit'])) {
            $element = new Text("remito_id");
            $this->add($element->setLabel("ID"));
        } else {
            $this->add(new Hidden("remito_id"));
        }
        /*=========================== REMITO SYA =====================================*/
        $periodo = new Numeric("remito_nro",array(
            'class'=>'form-control',
            'placeholder'=>'INGRESAR VALOR NÚMERICO',
            $required['clave']=>$required['valor']
        ));
        $periodo->setLabel("REMITO SYA");
        $periodo->setFilters(array('int'));
        $periodo->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Remito es Requerido'
            ))
        ));
        $this->add($periodo);
        /*=========================== TRANSPORTE =====================================*/
        $transporte = new DataListElement('transporte_dominio',
            array(
                array('placeholder' => 'SELECCIONAR LA PATENTE', 'class'=>'form-control', 'maxlength' => 11,$required['clave']=>$required['valor']),
                Transporte::find(array('transporte_habilitado=1','order'=>'transporte_dominio')),
                array('transporte_id', 'transporte_dominio'),
                'remito_transporteId'
            ));
        $transporte->setLabel('TRANSPORTE');
        $this->add($transporte);
        /*=========================== TIPO DE EQUIPO =====================================*/
        $elemento = new DataListElement('tipoEquipo_nombre',
            array(
                array('placeholder' => 'SELECCIONAR EL NOMBRE', 'class'=>'form-control', 'maxlength' => 50,$required['clave']=>$required['valor']),
                Tipoequipo::find(array('tipoEquipo_habilitado=1','order'=>'tipoEquipo_nombre')),
                array('tipoEquipo_id', 'tipoEquipo_nombre'),
                'remito_tipoEquipoId'
            ));
        $elemento->setLabel('TIPO DE EQUIPO');
        $this->add($elemento);
        /*=========================== TIPO DE CARGA =====================================*/
        $elemento = new DataListElement('tipoCarga_nombre',
            array(
                array('placeholder' => 'SELECCIONAR EL NOMBRE', 'class'=>'form-control', 'maxlength' => 50,$required['clave']=>$required['valor']),
                Tipocarga::find(array('tipoCarga_habilitado=1','order'=>'tipoCarga_nombre')),
                array('tipoCarga_id', 'tipoCarga_nombre'),
                'remito_tipoCargaId'
            ));
        $elemento->setLabel('TIPO DE CARGA');
        $this->add($elemento);
        /*=========================== CHOFER =====================================*/
        $elemento = new DataListElement('chofer_dni',
            array(
                array('placeholder' => 'SELECCIONAR EL DNI', 'class'=>'form-control',
                    'maxlength' => 50,$required['clave']=>$required['valor']),
                Chofer::find(array('chofer_habilitado=1','order'=>'chofer_nombreCompleto')),
                array('chofer_id', 'chofer_dni'),
                'remito_choferId'
            ));
        $elemento->setLabel('CHOFER');
        $this->add($elemento);
        /*=========================== VIAJE =====================================*/
        $viaje=Viaje::find(array('viaje_habilitado=1','order'=>array('viaje_origen')));
        $elemento = new DataListElement('viaje_origen',
            array(
                array('placeholder' => 'SELECCIONAR EL ORIGEN', 'class'=>'form-control', 'maxlength' => 50,$required['clave']=>$required['valor']),
                $viaje,
                array('viaje_id', 'viaje_origen'),
                'remito_viajeId'
            ));
        $elemento->setLabel('VIAJE');
        $this->add($elemento);
        /*=========================== CONCATENADO =====================================*/
        $elemento = new DataListElement('concatenado_nombre',
            array(
                array('placeholder' => 'SELECCIONAR EL NOMBRE', 'class'=>'form-control', 'maxlength' => 60,$required['clave']=>$required['valor']),
                Concatenado::find(array('concatenado_habilitado=1','order'=>'concatenado_nombre')),
                array('concatenado_id', 'concatenado_nombre'),
                'remito_concatenadoId'
            ));
        $elemento->setLabel('CONCATENADO');
        $this->add($elemento);
        /*=========================== FECHA =====================================*/
        $fecha = new Date("remito_fecha",array( 'class'=>'form-control',$required['clave']=>$required['valor']));
        $fecha->setLabel("FECHA");
        $fecha->addValidators(array(
            new PresenceOf(array(
                'message' => 'La fecha es Requerida'
            ))
        ));
        $this->add($fecha);
        /*=========================== TARIFA =====================================*/
        $elemento = new TypeElement("tarifa_horaInicial",array('type'=>'time', 'class'=>'form-control',$required['clave']=>$required['valor']
        ));
        $elemento->setLabel("HORA INICIAL");
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Hora Inicial es requerida'
            ))
        ));
        $this->add($elemento);
        $elemento = new TypeElement("tarifa_horaFinal",array('type'=>'time', 'class'=>'form-control',$required['clave']=>$required['valor']
        ));
        $elemento->setLabel("HORA FINAL");
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Hora Final es requerida'
            ))
        ));
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsServicio',array('placeholder'=>'INGRESAR VALOR NÚMERICO', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("HORAS DE SERVICIO");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsHidro',array('placeholder'=>'INGRESAR VALOR NÚMERICO', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("HORAS DE HIDRO");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsMalacate',array('placeholder'=>'INGRESAR VALOR NÚMERICO', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("HORAS DE MALACATE");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsStand',array('placeholder'=>'INGRESAR VALOR NÚMERICO', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("HORAS DE ESPERA");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_km',array('placeholder'=>'INGRESAR VALOR NÚMERICO', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("KILOMETROS");
        $this->add($elemento);
        /*=========================== OBSERVACION =====================================*/
        $elemento = new \Phalcon\Forms\Element\TextArea('remito_observacion',
            array('placeholder' => 'ESCRIBIR...', 'class'=>'form-control', 'maxlength' => 150));
        $elemento->setLabel('OBSERVACIÓN');
        $this->add($elemento);
        /*=========================== ORDEN DE CONFORMIDAD =====================================*/
        $elemento = new Text('remito_conformidad',
            array('placeholder' => '', 'class'=>'form-control', 'maxlength' => 50));
        $elemento->setLabel('CONFORMIDAD RE');
        $this->add($elemento);
        /*=========================== ORDEN DE NO CONFORMIDAD =====================================*/
        $elemento = new Text('remito_noConformidad',
            array('placeholder' => '', 'class'=>'form-control', 'maxlength' => 50));
        $elemento->setLabel('MOT NO CONF RE');
        $this->add($elemento);

    }
}