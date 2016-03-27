<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">AGREGAR NUEVO REMITO <br></h3>
        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/nuevoRemitoPorPlanilla", "<i class='fa fa-sign-out fa-rotate-180'></i> VOLVER",'class':'btn btn-flat bg-olive') }}<br>

                </td>

                <td align="right">
                    {{ submit_button(" Guardar Remito",'id':'submit','class':'btn btn-flat btn-lg btn-primary') }}
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Formulario -->
{{ content() }}
{{ form("remito/guardarNuevo",'id':'form-crearRemito' ,"method":"post") }}


<!-- Cuerpo -->
{# =================================== PLANILLA ================================== #}
{#Campos Ocultos#}
{% if planilla is defined %}
    {{ hidden_field('remito_planillaId','value':planilla.getPlanillaId()) }}
{% endif %}
<div class="box box-primary">
    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-table"></i>
                Planilla
            </h3>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                {% if planilla is defined %}
                    <br>
                    <div class="btn btn-flat table-bordered">
                        <strong>{{ planilla.getPlanillaNombreCliente() }}</strong>
                        <br> {{ date('d/m/Y',(planilla.getPlanillaFecha()) | strtotime) }}
                    </div>
                {% endif %}
            </div>
            <div class="col-md-8">
                <div class="col-md-6 form-group">
                    {{ remitoForm.label('remito_fecha') }}
                    {{ remitoForm.render('remito_fecha') }}
                </div>
                <div class="col-md-6 form-group">
                    {{ remitoForm.label('remito_nro') }}
                    {{ remitoForm.render('remito_nro') }}
                </div>
                <div class="col-md-12">
                    <hr>
                </div>

                <div class="col-md-6 form-group">
                    <label>Tipo de Planilla</label>
                    <br>
                    <label style="margin-right: 55px">
                        <input type="radio" name="remito_tipo" value="0" class="flat-red" checked> Mensual
                    </label>
                    <label>
                        <input type="radio" name="remito_tipo" class="flat-red" value="1"> On Call
                    </label>
                </div>
                <div class="col-md-6 form-group">

                    <label for="exampleInputFile">Remito Escaneado</label>
                    <br>
                    <input type="file" id="remito_pdf">

                    <p class="help-block"><i class="fa fa-info-circle"></i> Buscar en el Servidor el PDF</p>
                </div>

            </div>
        </div>
    </div>
</div>
{# =================================== TRANSPORTE ================================== #}
<div class="box box-primary">
    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-truck"></i>
                Transporte
            </h3>
            <a class="btn btn-github panel-title pull-right">
                <i class="fa fa-plus-circle"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                {{ remitoForm.label('transporte_dominio') }}
                {{ remitoForm.render('transporte_dominio') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tipoEquipo_nombre') }}
                {{ remitoForm.render('tipoEquipo_nombre') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tipoCarga_nombre') }}
                {{ remitoForm.render('tipoCarga_nombre') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('chofer_dni') }}
                {{ remitoForm.render('chofer_dni') }}
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
</div>
{# =================================== CLIENTE ================================== #}
<div class="box box-primary">
    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-male"></i>
                Cliente
            </h3>
            <a class="btn btn-github panel-title pull-right">
                <i class="fa fa-plus-circle btn"></i>
                <i class="fa fa-refresh btn"></i>
            </a>
        </div>
        <div class="row">


            <div class="col-md-4 form-group">
                {{ clienteForm.label('yacimiento_destino') }}
                {{ clienteForm.render('yacimiento_destino') }}
            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('operadora_nombre') }}
                {{ clienteForm.render('operadora_nombre') }}
                {{ clienteForm.render('script_yacimiento_operadoras') }}

            </div>
            <div class="col-md-4  form-group">
                {{ clienteForm.label('equipoPozo_nombre') }}
                {{ clienteForm.render('equipoPozo_nombre') }}
                {{ clienteForm.render('script_yacimiento_ep') }}
            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('linea_nombre') }}
                {{ clienteForm.render('linea_nombre') }}
            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('centroCosto_codigo') }}
                {{ clienteForm.render('centroCosto_codigo') }}
                {{ clienteForm.render('script_linea_cc') }}

            </div>

        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>
</div>
{# =================================== VIAJE ===================================== #}
<div class="box box-primary">
    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-exchange"></i>
                Viaje
            </h3>
            <a class="btn btn-github panel-title pull-right">
                <i class="fa fa-plus-circle"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                {{ remitoForm.label('viaje_origen') }}
                {{ remitoForm.render('viaje_origen') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('concatenado_nombre') }}
                {{ remitoForm.render('concatenado_nombre') }}
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
</div>
{# =================================== TARIFA ================================== #}
<div class="box box-primary">
    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-clock-o"></i>
                Tarifa
            </h3>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tarifa_horaInicial') }}
                {{ remitoForm.render('tarifa_horaInicial') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tarifa_horaFinal') }}
                {{ remitoForm.render('tarifa_horaFinal') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tarifa_hsServicio') }}
                {{ remitoForm.render('tarifa_hsServicio') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tarifa_hsHidro') }}
                {{ remitoForm.render('tarifa_hsHidro') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tarifa_hsMalacate') }}
                {{ remitoForm.render('tarifa_hsMalacate') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tarifa_hsStand') }}
                {{ remitoForm.render('tarifa_hsStand') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('tarifa_km') }}
                {{ remitoForm.render('tarifa_km') }}
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
</div>
{# =================================== COLUMNA ADICIONALES ================================== #}
{% if columnaExtraForm is defined %}
    <div class="box box-primary">
        <div class=" box-body">
            <div class="box-header">
                <h3 class="panel-title pull-left">
                    <i class="fa fa-stack-exchange"></i>
                    Columnas Extras
                </h3>
            </div>
            <div class="row">
                {% for element in columnaExtraForm %}
                    <div class="col-md-6 form-group">
                        {{ element.label() }}
                        {{ element.render() }}
                    </div>
                {% endfor %}

            </div>
        </div>
    </div>
{% endif %}
{# =================================== DATOS VARIOS ================================== #}
<div class="box box-primary">
    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-info-circle"></i>
                Información Extra
            </h3>
        </div>
        <div class="row">

            <div class="col-md-4 col-md-offset-2 form-group">
                {{ remitoForm.label('remito_conformidad') }}
                {{ remitoForm.render('remito_conformidad') }}
            </div>
            <div class="col-md-4 form-group">
                {{ remitoForm.label('remito_noConformidad') }}
                {{ remitoForm.render('remito_noConformidad') }}
            </div>

            <div class="col-md-8 col-md-offset-2 form-group">
                {{ remitoForm.label('remito_observacion') }}
                {{ remitoForm.render('remito_observacion') }}
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12">

    {{ submit_button(" Guardar Remito",'id':'submit','class':'btn btn-flat btn-lg btn-primary') }}
</div>
{{ end_form() }}
<!--
<script>
    $(function () {
        $(".autocompletar").select2({
            theme: "bootstrap", selectOnClose: true,
            closeOnSelect: true
        }).on('select2:close', function (evt) {
            //Permite seleccionar el item con TAB
            var context = $(evt.target);

            $(document).on('keydown.select2', function (e) {
                if (e.which === 9) { // tab
                    var highlighted = context
                            .data('select2')
                            .$dropdown
                            .find('.select2-results__option--highlighted');
                    if (highlighted) {
                        var id = highlighted.data('data').id;
                        context.val(id).trigger('change');
                    }
                }
            });

            // unbind the event again to avoid binding multiple times
            setTimeout(function () {
                $(document).off('keydown.select2');
            }, 1);
        });
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
</script>
-->