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
            {{ link_to("cliente/index", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class=" box-body">
    <div class="col-md-6 col-md-offset-3">
        <label>Nombre del cliente</label>
        {{ text_field('cliente_nombre','class':'form-control','required':'','placeholder':'INGRESE EL NOMBRE') }}
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
