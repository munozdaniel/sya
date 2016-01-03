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
        {{ clienteForm.render('cliente_nombre',['autofocus':'']) }}

    </div>
    <div class="col-md-4 form-group">
        {{ clienteForm.label('cliente_operadoraID') }}
        {{ clienteForm.render('cliente_operadoraID') }}
        <a href="#nuevaOperadora" role="button" data-toggle="modal"><i class="fa  fa-plus-circle"></i> Agregar</a>
    </div>
    <div class="col-md-4 form-group">
        {{ clienteForm.label('cliente_frsId') }}
        {{ clienteForm.render('cliente_frsId') }}
        <a href="#nuevoFrs" role="button" data-toggle="modal"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('equipoPozo_yacimiento') }}
        {{ clienteForm.render('equipoPozo_yacimiento') }}
        <a href="#nuevoYacimiento" role="button" data-toggle="modal"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('cliente_equipoPozo') }}
        {{ clienteForm.render('cliente_equipoPozo') }}
        <a href="#nuevoEquipoPozo" role="button" data-toggle="modal"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('centroCosto_linea') }}
        {{ clienteForm.render('centroCosto_linea') }}
        <a href="#nuevaLinea" role="button" data-toggle="modal"><i class="fa  fa-plus-circle"></i> Agregar</a>

    </div>
    <div class="col-md-6 form-group">
        {{ clienteForm.label('cliente_centroCosto') }}
        {{ clienteForm.render('cliente_centroCosto') }}
        <a href="#nuevoCentroCosto" role="button" data-toggle="modal"><i class="fa  fa-plus-circle"></i> Agregar</a>

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
