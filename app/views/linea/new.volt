<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Linea</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}

{{ form("linea/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("linea", "Búsqueda Personalizada",'class':'btn btn-flat  btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        <label for="linea_nombre">Nombre de la Linea</label>

        <div class="form-group">
            {{ text_field("linea_nombre", "size" : 50,'class':'form-control','placeholder':'INGRESAR EL NOMBRE') }}
        </div>

        {#==================================================#}
        <label for="linea_nombre">Nombre del Cliente</label>

        <div class="form-group">
            {{ cliente }}
        </div>
    </div>
</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
{{ end_form() }}
<script>
$(function () {
$(".autocompletar").select2();

});
</script>
