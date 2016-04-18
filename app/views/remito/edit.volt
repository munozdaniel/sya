<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">EDITAR REMITO <br></h3>
        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/buscarRemitoPorPlanilla", "<i class='fa fa-search'></i> Realizar nueva búsqueda",'class':'btn btn-flat btn-google') }}
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Formulario -->

{{ content() }}
{{ form("remito/save", "method":"post") }}
{{ remitoForm.render('remito_id') }}
<!-- Cuerpo -->
{# =================================== PLANILLA ================================== #}
<div class="box box-primary">
    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-table"></i>
                Planilla
            </h3>
        </div>
        <div class="row">
            <div class="col-md-4 ">
                {% if planilla is defined %}
                    <br>
                    <strong>{{ planilla.getPlanillaNombreCliente() }}</strong>
                    <br> {{ date('d/m/Y',(planilla.getPlanillaFecha()) | strtotime) }}
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


                <div class="col-md-12 form-group">

                    <label for="exampleInputFile">Remito Escaneado</label>
                    <br>
                    <input type="file" id="remito_pdf" name="remito_pdf" data-max-size='3mb' class="form-control">

                    <p class="help-block"><i class="fa fa-info-circle"></i> Buscar el PDF en el Servidor </p>
                    <script>
                        $('input[type=file]').fileValidator({
                            onValidation: function (files) {
                                $(this).attr('class', '');
                            },
                            onInvalid: function (type, file) {
                                $(this).addClass('invalid ' + type);
                            },
                            maxSize: '3m',
                            type: 'pdf'
                        });

                    </script>
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
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_transporteId') }}
                {{ remitoForm.render('remito_transporteId') }}
                <a class="btn   " onclick='$("#remito_transporteId").select2("val", ""); '>ACTUALIZAR</a>
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_tipoEquipoId') }}
                {{ remitoForm.render('remito_tipoEquipoId') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_tipoCargaId') }}
                {{ remitoForm.render('remito_tipoCargaId') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_choferId') }}
                {{ remitoForm.render('remito_choferId') }}
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
        </div>
        <div class="row">
            <div id="mensajes_clientes" class="col-md-12"></div>
            <div class="col-md-4 form-group AQUI">
                {{ remitoForm.label('yacimiento_id') }}
                {{ remitoForm.render('yacimiento_id') }}
                <i id="load_yac_dep" class="fa fa-2x fa-refresh  fa-spin ocultar"></i>
            </div>
            <div class="col-md-4 form-group">
                {{ remitoForm.label('remito_operadoraId') }}
                {{ remitoForm.render('remito_operadoraId') }}
            </div>
            <div class="col-md-4 form-group">
                {{ remitoForm.label('remito_equipoPozoId') }}
                {{ remitoForm.render('remito_equipoPozoId') }}
            </div>
            <div class="col-md-4 form-group AQUI">
                {{ remitoForm.label('centroCosto_lineaId') }}
                {{ remitoForm.render('centroCosto_lineaId') }}
                <i id="load_linea_dep" class="fa fa-2x fa-refresh  fa-spin ocultar"></i>

            </div>
            <div class="col-md-4 form-group">
                {{ remitoForm.label('remito_centroCostoId') }}
                {{ remitoForm.render('remito_centroCostoId') }}
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
                {{ remitoForm.label('remito_viajeId') }}
                {{ remitoForm.render('remito_viajeId') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_concatenadoId') }}
                {{ remitoForm.render('remito_concatenadoId') }}
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

<script>
    $(function () {
        $(".autocompletar").select2();
    });
</script>
{{ end_form() }}
<script>
    $("#yacimiento_id").change(function (event) {
        $('.help-block').remove();
        var select_op = $("#remito_operadoraId");
        select_op.select2("val", "");
        select_op.empty();
        var select_eq = $("#remito_equipoPozoId");
        select_eq.select2("val", "");
        select_eq.empty();
        $('#load_yac_dep').toggle();
        //PREPARANDO los datos para enviar
        var datos = {
            'yacimiento_id': $(this).val()
        };

        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/yacimiento/cargarDependientes', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                .done(function (data) {
                    console.log(data);
                    var elemento;
                    if (!data.success) {
                        $('#mensajes_clientes').append('<div class="help-block  alert-danger"><h4><i class="fa fa-exclamation-triangle"></i> ' + data.mensaje + '</h4></div>'); // add the actual error message under our input
                    } else {
                        var html = "";

                        if (data.tiene_op) {
                            html = '<option value="" >SELECCIONE UNA OPERADORA</option>';
                            for (var item_op in data.operadoras) {
                                elemento = data.operadoras[item_op];

                                html += '<option value="' + elemento.valor + '">' + elemento.nombre + '</option>';
                            }
                            $('select#remito_operadoraId').html(html);

                        }
                        if (data.tiene_eq) {
                            html = '<option value="" >SELECCIONE UN EQUIPO/POZO</option>';
                            for (var item in data.equipos) {
                                elemento = data.equipos[item];
                                html += '<option value="' + elemento.valor + '">' + elemento.nombre + '</option>';
                            }
                            $('select#remito_equipoPozoId').html(html);
                        }
                        $('#load_yac_dep').toggle();
                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
        event.preventDefault();
    });
    $("#centroCosto_lineaId").change(function (event) {
        $('.help-block').remove();
        var select_op = $("#remito_centroCostoId");
        select_op.select2("val", "");
        select_op.empty();
        $('#load_linea_dep').toggle();
        //PREPARANDO los datos para enviar
        var datos = {
            'linea_id': $(this).val()
        };

        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/linea/cargarDependientes', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                .done(function (data) {
                    console.log(data);
                    var elemento;
                    if (!data.success) {
                        $('#mensajes_clientes').append('<div class="help-block  alert-danger"><h4><i class="fa fa-exclamation-triangle"></i> ' + data.mensaje + '</h4></div>'); // add the actual error message under our input
                    } else {
                        html = '<option value="" >SELECCIONE UN CODIGO</option>';
                        for (var item_op in data.centros) {
                            elemento = data.centros[item_op];

                            html += '<option value="' + elemento.valor + '">' + elemento.nombre + '</option>';
                        }
                        $('select#remito_centroCostoId').html(html);

                        $('#load_linea_dep').toggle();
                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
        event.preventDefault();
    });
</script>