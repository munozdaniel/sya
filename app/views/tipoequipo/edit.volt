<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Tipo de Equipo</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->
{{ content() }}
{{ form("tipoequipo/save", "method":"post") }}

<table width="100%">
    <tr>
        {{ link_to("tipoequipo", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        <label for="tipoEquipo_nombre">Nombre del Equipo</label>

        <div class="form-group">
            {{ text_field("tipoEquipo_nombre", "size" : 50,'class':'form-control','required':'','placeholder':'INGRESE EL NOMBRE') }}
        </div>
    </div>
</div><!-- /.Cuerpo -->


<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("tipoEquipo_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>