<div class="box-header">
    <h3 class="box-title"><strong>Agregar Remito</strong></h3>
    {% if planilla is defined %}
        <h3>{{ planilla.getPlanillaNombreCliente() }} <br> {{ date('d/m/Y',(planilla.getPlanillaFecha()) | strtotime)}}</h3>
    {% endif %}
    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("planilla/index", "<i class='fa fa-search'></i> Busqueda Personalizada",'class':'btn btn-flat btn-large bg-olive') }}
            </td>

            <td align="right">

                {{ submit_button(" Guardar Remito",'id':'submit','class':'btn btn-flat btn-large btn-primary') }}
            </td>
        </tr>
    </table>

</div>

<!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
        {{ form("orden/create",'id':'crearOrden-form' ,"method":"post") }}


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
            <div class="col-md-4 form-group">
                {{ newOrdenForm.label('orden_fecha') }}
                {{ newOrdenForm.render('orden_fecha') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('orden_remito') }}
                {{ newOrdenForm.render('orden_remito') }}
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
            <a class="btn btn-github panel-title pull-right">
                <i class="fa fa-plus-circle"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('transporte_dominio') }}
                {{ newOrdenForm.render('transporte_dominio') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tipoEquipo_nombre') }}
                {{ newOrdenForm.render('tipoEquipo_nombre') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tipoCarga_nombre') }}
                {{ newOrdenForm.render('tipoCarga_nombre') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('chofer_nombreCompleto') }}
                {{ newOrdenForm.render('chofer_nombreCompleto') }}
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
                <i class="fa fa-plus-circle"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-md-4 form-group">
                {{ clienteForm.label('cliente_nombre') }}
                {{ clienteForm.render('cliente_nombre') }}

            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('linea_nombre') }}
                {{ clienteForm.render('linea_nombre') }}
                {{ clienteForm.render('cliente_lineaScript') }}
            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('centroCosto_codigo') }}
                {{ clienteForm.render('centroCosto_codigo') }}

            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('yacimiento_destino') }}
                {{ clienteForm.render('yacimiento_destino') }}
                {{ clienteForm.render('operadora_yacimientoScript') }}
            </div>
            <div class="col-md-4  form-group">
                {{ clienteForm.label('equipoPozo_nombre') }}
                {{ clienteForm.render('equipoPozo_nombre') }}
                {{ clienteForm.render('yacimiento_EPScript') }}
            </div>
            <div class="col-md-4 form-group">
                {{ clienteForm.label('operadora_nombre') }}
                {{ clienteForm.render('operadora_nombre') }}
                {{ clienteForm.render('cliente_operadoraScript') }}
            </div>

            <div class="col-md-4 form-group">
                {{ clienteForm.render('centroCosto_lineaScript') }}
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
                {{ newOrdenForm.label('viaje_origen') }}
                {{ newOrdenForm.render('viaje_origen') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('concatenado_nombre') }}
                {{ newOrdenForm.render('concatenado_nombre') }}
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
                {{ newOrdenForm.label('tarifa_horaInicial') }}
                {{ newOrdenForm.render('tarifa_horaInicial') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tarifa_horaFinal') }}
                {{ newOrdenForm.render('tarifa_horaFinal') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tarifa_hsServicio') }}
                {{ newOrdenForm.render('tarifa_hsServicio') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tarifa_hsHidro') }}
                {{ newOrdenForm.render('tarifa_hsHidro') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tarifa_hsMalacate') }}
                {{ newOrdenForm.render('tarifa_hsMalacate') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tarifa_hsStand') }}
                {{ newOrdenForm.render('tarifa_hsStand') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('tarifa_km') }}
                {{ newOrdenForm.render('tarifa_km') }}
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
</div>
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
                {{ newOrdenForm.label('orden_observacion') }}
                {{ newOrdenForm.render('orden_observacion') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('orden_conformidad') }}
                {{ newOrdenForm.render('orden_conformidad') }}
            </div>
            <div class="col-md-3 form-group">
                {{ newOrdenForm.label('orden_noConformidad') }}
                {{ newOrdenForm.render('orden_noConformidad') }}
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
