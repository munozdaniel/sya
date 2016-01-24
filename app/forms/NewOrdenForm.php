<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 03/01/2016
 * Time: 09:35 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Date;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Forms\Element\Hidden;use Phalcon\Forms\Element\Check;
class NewOrdenForm extends \Phalcon\Forms\Form
{

    /**
     * Initialize the cliente form
     * Los campos que se generarán automaticamente son:
     *  - Fecha de Creacion - CreadoPor
     * Los campos relacionados con el cliente se generarán en un formulario aparte.
     */
    public function initialize($entity = null, $options = array())
    {
        /*======================= ID ==============================*/
        if (!isset($options['edit'])) {
            $element = new Text("orden_id");
            $this->add($element->setLabel("N° de Orden"));
        } else {
            $this->add(new Hidden("orden_id"));
        }
        /*=========================== PLANILLA =====================================*/
        $planilla = new DataListElement('planilla_nombreCliente',
            array(
                array('placeholder' => 'Seleccione una Planilla', 'class'=>'form-control', 'maxlength' => 11,'autofocus'=>'true','required'=>''),
                Planilla::find(array('planilla_habilitado=1','order'=>'planilla_nombreCliente')),
                array('planilla_id', 'planilla_nombreCliente'),
                'orden_planillaId'
            ));
        $planilla->setLabel('Planilla');
        $this->add($planilla);
        /*=========================== REMITO SYA =====================================*/
        $periodo = new Numeric("orden_remito",array(
            'class'=>'form-control',
            'placeholder'=>'Ingrese un valor númerico','required'=>''
        ));
        $periodo->setLabel("Remito Sya");
        $periodo->setFilters(array('int'));
        $periodo->addValidators(array(
            new \Phalcon\Validation\Validator\PresenceOf(array(
                'message' => 'El Remito es Requerido'
            ))
        ));
        $this->add($periodo);
        /*=========================== TRANSPORTE =====================================*/
        $transporte = new DataListElement('transporte_dominio',
            array(
                array('placeholder' => 'Seleccione el Dominio', 'class'=>'form-control', 'maxlength' => 11,'required'=>''),
                Transporte::find(array('transporte_habilitado=1','order'=>'transporte_dominio')),
                array('transporte_id', 'transporte_dominio'),
                'orden_transporteId'
            ));
        $transporte->setLabel('Dominio');
        $this->add($transporte);
        /*=========================== TIPO DE EQUIPO =====================================*/
        $elemento = new DataListElement('tipoEquipo_nombre',
            array(
                array('placeholder' => 'Seleccione el Equipo', 'class'=>'form-control', 'maxlength' => 50,'required'=>''),
                Tipoequipo::find(array('tipoEquipo_habilitado=1','order'=>'tipoEquipo_nombre')),
                array('tipoEquipo_id', 'tipoEquipo_nombre'),
                'orden_tipoEquipoId'
            ));
        $elemento->setLabel('Tipo de Equipo');
        $this->add($elemento);
        /*=========================== TIPO DE CARGA =====================================*/
        $elemento = new DataListElement('tipoCarga_nombre',
            array(
                array('placeholder' => 'Seleccione el Tipo de Carga', 'class'=>'form-control', 'maxlength' => 50,'required'=>''),
                Tipocarga::find(array('tipoCarga_habilitado=1','order'=>'tipoCarga_nombre')),
                array('tipoCarga_id', 'tipoCarga_nombre'),
                'orden_tipoCargaId'
            ));
        $elemento->setLabel('Tipo de Carga');
        $this->add($elemento);
        /*=========================== CHOFER =====================================*/
        $elemento = new DataListElement('chofer_nombreCompleto',
            array(
                array('placeholder' => 'Seleccione el Chofer', 'class'=>'form-control', 'maxlength' => 50,'required'=>''),
                Chofer::find(array('chofer_habilitado=1','order'=>'chofer_nombreCompleto')),
                array('chofer_id', 'chofer_nombreCompleto'),
                'orden_choferId'
            ));
        $elemento->setLabel('Nombre del Chofer');
        $this->add($elemento);
        /*=========================== VIAJE =====================================*/
        $viaje=Viaje::find(array('viaje_habilitado=1','order'=>array('viaje_origen','viaje_concatenado')));
        $elemento = new DataListElement('viaje_origen',
            array(
                array('placeholder' => 'Seleccione el Origen', 'class'=>'form-control', 'maxlength' => 50,'required'=>''),
                $viaje,
                array('viaje_id', 'viaje_origen'),
                'orden_viajeId'
            ));
        $elemento->setLabel('Origen');
        $this->add($elemento);
        /*=========================== CONCATENADO =====================================*/
        $elemento = new DataListElement('concatenado_nombre',
            array(
                array('placeholder' => 'Seleccione el Concatenado', 'class'=>'form-control', 'maxlength' => 60,'required'=>''),
                Concatenado::find(array('concatenado_habilitado=1','order'=>'concatenado_nombre')),
                array('concatenado_id', 'concatenado_nombre'),
                'orden_concatenadoId'
            ));
        $elemento->setLabel('Concatenado');
        $this->add($elemento);
        /*=========================== FECHA =====================================*/
        $fecha = new Date("orden_fecha",array( 'class'=>'form-control','required'=>''));
        $fecha->setLabel("Fecha");
        $fecha->setFilters(array('date'));
        $fecha->addValidators(array(
            new PresenceOf(array(
                'message' => 'La fecha es Requerida'
            ))
        ));
        $this->add($fecha);
        /*=========================== TARIFA =====================================*/
        $elemento = new TypeElement("tarifa_horaInicial",array('type'=>'time', 'class'=>'form-control','required'=>''
    ));
        $elemento->setLabel("Hora Inicial");
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Hora Inicial es requerida'
            ))
        ));
        $this->add($elemento);
        $elemento = new TypeElement("tarifa_horaFinal",array('type'=>'time', 'class'=>'form-control','required'=>''
        ));
        $elemento->setLabel("Hora Final");
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Hora Final es requerida'
            ))
        ));
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsServicio',array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("Horas de Servicio");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsHidro',array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("Horas de Hidro");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsMalacate',array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("Horas de Malacate");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_hsStand',array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("Horas Stand");
        $this->add($elemento);
        $elemento = new Numeric('tarifa_km',array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0));
        $elemento->setFilters(array('float'));
        $elemento->setLabel("Kilometros");
        $this->add($elemento);
        /*=========================== COLUMNA EXTRA =====================================*/
        //El id de este elemento se agrega a contenidoExtra
        //Las Columnas Extras deberian ser agregadas despues de crear la orden, para poder agregar las columnas extras que se quieran.
        /*
        $elemento = new DataListElement('columnaExtra_nombre',
            array(
                array('placeholder' => 'Titulo de la Columna', 'class'=>'form-control', 'maxlength' => 50,'required'=>''),
                Columnaextra::find(array('columnaExtra_habilitado=1','order'=>'columnaExtra_nombre')),
                array('columnaExtra_id', 'columnaExtra_nombre'),
                'columnaExtra_id'
            ));
        $elemento->setLabel('Titulo de la Columna Extra');
        $this->add($elemento);
        /*=========================== CONTENIDO EXTRA =====================================*/
        //El id de este elemento se agrega a contenidoExtra
        /*$elemento = new Text('contenidoExtra_descripcion',
                array('placeholder' => 'Titulo de la Columna', 'class'=>'form-control', 'maxlength' => 50,'required'=>''));
        $elemento->setLabel('Concatenado');
        $this->add($elemento);
        /*=========================== OBSERVACION =====================================*/
        $elemento = new \Phalcon\Forms\Element\TextArea('orden_observacion',
            array('placeholder' => 'Escribir ...', 'class'=>'form-control', 'maxlength' => 150));
        $elemento->setLabel('Observación');
        $this->add($elemento);
        /*=========================== ORDEN DE CONFORMIDAD =====================================*/
        $elemento = new Text('orden_conformidad',
            array('placeholder' => '', 'class'=>'form-control', 'maxlength' => 50));
        $elemento->setLabel('Conformidad RE');
        $this->add($elemento);
        /*=========================== ORDEN DE NO CONFORMIDAD =====================================*/
        $elemento = new Text('orden_noConformidad',
            array('placeholder' => '', 'class'=>'form-control', 'maxlength' => 50));
        $elemento->setLabel('Mot no Conformidad RE');
        $this->add($elemento);
    }

}