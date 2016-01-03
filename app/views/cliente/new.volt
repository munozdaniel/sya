<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Ingresar el CLIENTE</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("cliente/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("cliente", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class=" box-body">

    <div class="col-md-4 form-group">
        {{ clienteForm.label('cliente_nombre') }}
        {{ clienteForm.render('cliente_nombre',['autofocus':'','required':'']) }}

    </div>
    <div class="col-md-4 form-group">
        {{ clienteForm.label('operadora_nombre') }}
        {{ clienteForm.render('operadora_nombre') }}
        <a href="#nuevaOperadora" role="button" data-toggle="modal" tabindex="100"><i class="fa  fa-plus-circle"></i> Agregar</a>
    </div>
    <div class="col-md-4 form-group">
        {{ clienteForm.label('frs_codigo') }}
        {{ clienteForm.render('frs_codigo') }}
        <a href="#nuevoFrs" role="button" data-toggle="modal"  tabindex="101"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('yacimiento_destino') }}
        {{ clienteForm.render('yacimiento_destino') }}
        <a href="#nuevoYacimiento" role="button" data-toggle="modal" tabindex="102"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('equipoPozo_nombre') }}
        {{ clienteForm.render('equipoPozo_nombre') }}
        <a href="#nuevoEquipoPozo" role="button" data-toggle="modal" tabindex="103"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('linea_nombre') }}
        {{ clienteForm.render('linea_nombre') }}
        <a href="#nuevaLinea" role="button" data-toggle="modal" tabindex="104"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('centroCosto_codigo') }}
        {{ clienteForm.render('centroCosto_codigo') }}
        <a href="#nuevoCentroCosto" role="button" data-toggle="modal" tabindex="105"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-4 form-group">
        {{ clienteForm.render('equipoPozo_lineaScript') }}
    </div>
    <div class="col-md-4 form-group">
        {{ clienteForm.render('centroCosto_lineaScript') }}
    </div>
    {#===============================================#}
</div><!-- /. Cuerpo -->
<!-- Footer -->

<div class="box-footer">
    <div class="col-md-12">

        {{ submit_button('GUARDAR','id':'submit','class':'btn btn-large btn-primary btn-flat') }}
    </div>
</div>
</form>
{{ partial('cliente/parcial/mOperadora') }}
{{ partial('cliente/parcial/mFrs') }}