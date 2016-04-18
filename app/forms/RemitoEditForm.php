<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 20/03/2016
 * Time: 12:02 PM
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
class RemitoNuevoForm extends Form
{
    /**
     * Utiliza select2
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, $options = array())
    {
        /*Si el form es de creacion, los campos seran required. Viceversa.*/
        $required['clave']="unrequired";
        $required['valor']="true";

        if(isset($options['required']))
        {
            $required['clave']="required";
            $required['valor']="true";
        }
        /*======================= ID ==============================*/
        if (!isset($options['edit'])) {
            $element = new Text("remito_id",array('class'=>'form-control'));
            $this->add($element->setLabel("ID"));
        } else {
            $this->add(new Hidden("remito_id"));
        }
        /*=========================== FECHA =====================================*/
        $fecha = new Date("remito_fecha",array( 'class'=>'form-control','tabindex'=>'1',$required['clave']=>$required['valor']));
        $fecha->setLabel("Fecha");
        $fecha->addValidators(array(
            new PresenceOf(array(
                'message' => 'La fecha es Requerida'
            ))
        ));
        $this->add($fecha);
        /*=========================== REMITO SYA =====================================*/
        $elemento = new Numeric("remito_nro",array(
            'class'=>'form-control',
            'placeholder'=>'Ingrese un valor númerico',
            $required['clave']=>$required['valor'],'tabindex'=>'2'
        ));
        $elemento->setLabel("Remito Sya");
        $elemento->setFilters(array('int'));
        $elemento->addValidators(array(
            new PresenceOf(array(
                'message' => 'El Remito es Requerido'
            ))
        ));
        $this->add($elemento);


        /*=========================== TRANSPORTE =====================================*/
        $elemento = new Select('remito_transporteId',
            Transporte::find(array('transporte_habilitado=1','order'=>'transporte_dominio')),
            array(
                'using' => array('transporte_id', 'transporte_dominio'),
                'useEmpty' => true,
                'emptyText' => 'INGRESE EL DOMINIO',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],'tabindex'=>'3'
            )
        );
        $elemento->setLabel('Transporte');
        $this->add($elemento);
        /*=========================== TIPO DE EQUIPO =====================================*/
        $elemento = new Select('remito_tipoEquipoId',
            Tipoequipo::find(array('tipoEquipo_habilitado=1','order'=>'tipoEquipo_nombre')),
            array(
                'using' => array('tipoEquipo_id', 'tipoEquipo_nombre'),
                'useEmpty' => true,
                'emptyText' => 'INGRESE EL NOMBRE',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],'tabindex'=>'4'
            )
        );
        $elemento->setLabel('Tipo de Equipo');
        $this->add($elemento);
        /*=========================== TIPO DE CARGA =====================================*/
        $elemento = new Select('remito_tipoCargaId',
            Tipocarga::find(array('tipoCarga_habilitado=1','order'=>'tipoCarga_nombre')),
            array(
                'using' => array('tipoCarga_id', 'tipoCarga_nombre'),
                'useEmpty' => true,
                'emptyText' => 'INGRESE EL NOMBRE',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],'tabindex'=>'5'
            )
        );
        $elemento->setLabel('Tipo de Carga');
        $this->add($elemento);
        /*=========================== TIPO DE CARGA =====================================*/
        $elemento = new Select('remito_choferId',
            Chofer::find(array('chofer_habilitado=1','order'=>'chofer_nombreCompleto')),
            array(
                'using' => array('chofer_id', 'chofer_dni'),
                'useEmpty' => true,
                'emptyText' => 'INGRESE EL DNI',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],'tabindex'=>'6'
            )
        );
        $elemento->setLabel('Chofer');
        $this->add($elemento);
        /*=========================== VIAJE =====================================*/
        $elemento = new Select('remito_viajeId',
            Viaje::find(array('viaje_habilitado=1','order'=>'viaje_origen')),
            array(
                'using' => array('viaje_id', 'viaje_origen'),
                'useEmpty' => true,
                'emptyText' => 'INGRESE EL ORIGEN',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],'tabindex'=>'7'
            )
        );
        $elemento->setLabel('Viaje');
        $this->add($elemento);
        /*=========================== CONCATENADO =====================================*/
        $elemento = new Select('remito_concatenadoId',
            Concatenado::find(array('concatenado_habilitado=1','order'=>'concatenado_nombre')),
            array(
                'using' => array('concatenado_id', 'concatenado_nombre'),
                'useEmpty' => true,
                'emptyText' => 'INGRESE EL NOMBRE',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],'tabindex'=>'8'
            )
        );
        $elemento->setLabel('Concatenado');
        $this->add($elemento);
        /*=========================== TARIFA =====================================*/
        $tarifa ="";

        $tarifa_horaInicial = new Text("tarifa_horaInicial",
            array('class'=>'form-control',$required['clave']=>$required['valor'],'tabindex'=>'9'
        ));
        $tarifa_horaInicial->setLabel("Hora Inicial");
        $tarifa_horaInicial->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Hora Inicial es requerida'
            ))
        ));
        $this->add($tarifa_horaInicial);
        $tarifa_horaFinal = new Text("tarifa_horaFinal",
            array('class'=>'form-control',$required['clave']=>$required['valor'],'tabindex'=>'10'
        ));
        $tarifa_horaFinal->setLabel("Hora Final");
        $tarifa_horaFinal->addValidators(array(
            new PresenceOf(array(
                'message' => 'La Hora Final es requerida'
            ))
        ));
        $this->add($tarifa_horaFinal);

        $tarifa_hsServicio = new Numeric('tarifa_hsServicio',
            array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0,'tabindex'=>'11'
            ));
        $tarifa_hsServicio->setFilters(array('float'));
        $tarifa_hsServicio->setLabel("Horas de Servicio");
        $this->add($tarifa_hsServicio);

        $tarifa_hsHidro = new Numeric('tarifa_hsHidro',
            array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0,'tabindex'=>'12'
            ));
        $tarifa_hsHidro->setFilters(array('float'));
        $tarifa_hsHidro->setLabel("Horas de Hidro");
        $this->add($tarifa_hsHidro);

        $tarifa_hsMalacate = new Numeric('tarifa_hsMalacate',
            array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0,'tabindex'=>'13'
            ));
        $tarifa_hsMalacate->setFilters(array('float'));
        $tarifa_hsMalacate->setLabel("Horas de Malacate");
        $this->add($tarifa_hsMalacate);

        $tarifa_hsStand = new Numeric('tarifa_hsStand',
            array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0,'tabindex'=>'14'
            ));
        $tarifa_hsStand->setFilters(array('float'));
        $tarifa_hsStand->setLabel("Horas Stand");
        $this->add($tarifa_hsStand);

        $tarifa_km = new Numeric('tarifa_km',
            array('placeholder'=>'Ingresar valor númerico', 'class'=>'form-control','min'=>0,'tabindex'=>'15'
            ));
        $tarifa_km->setFilters(array('float'));
        $tarifa_km->setLabel("Kilometros");
        $this->add($tarifa_km);
        if($entity!=null)
        {
            $tarifa = $entity->getTarifa();

            $tarifa_horaInicial->setDefault($tarifa->getTarifaHoraInicial());

            $tarifa_horaFinal->setDefault($tarifa->getTarifaHoraFinal());

            $tarifa_hsServicio->setDefault($tarifa->getTarifaHsservicio());

            $tarifa_hsHidro->setDefault($tarifa->getTarifaHshidro());

            $tarifa_hsMalacate->setDefault($tarifa->getTarifaHsmalacate());

            $tarifa_hsStand->setDefault($tarifa->getTarifaHsstand());

            $tarifa_km->setDefault($tarifa->getTarifaKm());

        }
        /*======================= YACIMIENTO ==============================*/
        $elemento = new Select('yacimiento_id',
            Yacimiento::find(array('yacimiento_habilitado=1', 'order' => 'yacimiento_destino')),
            array(
                'using' => array('yacimiento_id', 'yacimiento_destino'),
                'useEmpty' => false,
                'emptyText' => 'INGRESE EL DESTINO',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],
            )
        );
        $elemento->setDefault($entity->getOperadora()->getYacimiento()->getYacimientoId());
        $elemento->setLabel('Yacimiento');
        $this->add($elemento);
        /*=========================== OPERADORA =====================================*/
        $elemento = new Select('remito_operadoraId',
            Operadora::find(array('operadora_habilitado=1', 'order' => 'operadora_nombre')),
            array(
                'using' => array('operadora_id', 'operadora_nombre'),
                'useEmpty' => false,
                'emptyText' => 'INGRESE LA OPERADORA',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],
            )
        );
        $elemento->setLabel('Operadora');
        $this->add($elemento);

        /*======================= EQUIPO POZO ==============================*/
        $elemento = new Select('remito_equipoPozoId',
            Equipopozo::find(array('equipoPozo_habilitado=1', 'order' => 'equipoPozo_nombre')),
            array(
                'using' => array('equipoPozo_id', 'equipoPozo_nombre'),
                'useEmpty' => false,
                'emptyText' => 'INGRESE EL EQUIPO/POZO',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],
            )
        );
        $elemento->setLabel('Equipo/Pozo');
        $this->add($elemento);

        /*======================= LINEA ==============================*/
        $elemento = new Select('centroCosto_lineaId',
            Linea::find(array('linea_habilitado=1', 'order' => 'linea_nombre')),
            array(
                'using' => array('linea_id', 'linea_nombre'),
                'useEmpty' => false,
                'emptyText' => 'INGRESE LA LINEA',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],
            )
        );
        $elemento->setDefault($entity->getCentroCosto()->getLinea()->getLineaId());
        $elemento->setLabel('Linea');
        $this->add($elemento);
        /*======================= CENTROCOSTO ==============================*/
        $elemento = new Select('remito_centroCostoId',
            Centrocosto::find(array('centroCosto_habilitado=1', 'order' => 'centroCosto_codigo')),
            array(
                'using' => array('centroCosto_id', 'centroCosto_codigo'),
                'useEmpty' => false,
                'emptyText' => 'INGRESE EL CODIGO',
                'emptyValue' => '',
                'class' => 'form-control autocompletar',
                'style' => 'width:100%',
                $required['clave']=>$required['valor'],
            )
        );
        $elemento->setLabel('Centro de Costo');
        $this->add($elemento);
        /*=========================== ORDEN DE CONFORMIDAD =====================================*/
        $elemento = new Text('remito_conformidad',
            array('placeholder' => '', 'class'=>'form-control', 'maxlength' => 50,'tabindex'=>'16'
            ));
        $elemento->setLabel('Conformidad RE');
        $this->add($elemento);
        /*=========================== ORDEN DE NO CONFORMIDAD =====================================*/
        $elemento = new Text('remito_noConformidad',
            array('placeholder' => '', 'class'=>'form-control', 'maxlength' => 50,'tabindex'=>'17'
            ));
        $elemento->setLabel('Mot no Conformidad RE');
        $this->add($elemento);
        /*=========================== OBSERVACION =====================================*/
        $elemento = new \Phalcon\Forms\Element\TextArea('remito_observacion',
            array('placeholder' => 'INGRESAR UNA OBSERVACIÓN', 'class'=>'form-control', 'maxlength' => 150,'tabindex'=>'18'
            ));
        $elemento->setLabel('Observación');
        $this->add($elemento);
        /*=========================== CONTINUA =====================================*/

        $elemento = new Numeric("remito_continua",array(
            'class'=>'form-control',
            'placeholder'=>'INGRESE EL NRO REMITO','tabindex'=>'15'
        ));
        $elemento->setLabel("EL REMITO CONTINUA EN:");
        $elemento->setFilters(array('int'));

        $this->add($elemento);
    }

}