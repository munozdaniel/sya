<!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form('id':'form-buscarRemitos' ,"method":"post") }}


{# =================================== PLANILLA ================================== #}
{#Campos Ocultos#}
{#Fin Campos Ocultos#}
<div class="box box-primary">
    {{ submit_button(" BUSCAR REMITOS",'id':'submit','class':'btn btn-flat btn-lg btn-primary ') }}


    <div class=" box-body">
        <div class="box-header">
            <h3 class="panel-title pull-left">
                <i class="fa fa-table"></i>
                Planilla
            </h3>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                {{ remitoForm.label('remito_fecha') }}
                {{ remitoForm.render('remito_fecha') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_nro') }}
                {{ remitoForm.render('remito_nro') }}
            </div>
            <div class="col-md-12">
                <hr>
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

        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                {{ clienteForm.label('cliente_nombre') }}
                {{ clienteForm.render('cliente_nombre') }}

            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('linea_nombre') }}
                {{ clienteForm.render('linea_nombre') }}
                {{ clienteForm.render('script_cliente_linea') }}
            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('centroCosto_codigo') }}
                {{ clienteForm.render('centroCosto_codigo') }}
                {{ clienteForm.render('script_linea_cc') }}

            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('yacimiento_destino') }}
                {{ clienteForm.render('yacimiento_destino') }}
            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('operadora_nombre') }}
                {{ clienteForm.render('operadora_nombre') }}
                {{ clienteForm.render('script_yacimiento_operadoras') }}

            </div>
            <div class="col-md-12"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4  form-group">
                {{ clienteForm.label('equipoPozo_nombre') }}
                {{ clienteForm.render('equipoPozo_nombre') }}
                {{ clienteForm.render('script_yacimiento_ep') }}
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
                <i class="fa fa-stack-exchange"></i>
                Notas
            </h3>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                {{ remitoForm.label('remito_observacion') }}
                {{ remitoForm.render('remito_observacion') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_conformidad') }}
                {{ remitoForm.render('remito_conformidad') }}
            </div>
            <div class="col-md-3 form-group">
                {{ remitoForm.label('remito_noConformidad') }}
                {{ remitoForm.render('remito_noConformidad') }}
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
    {{ submit_button(" BUSCAR REMITOS",'id':'submit','class':'btn btn-flat btn-lg btn-primary ') }}

</div>

{{ end_form() }}
