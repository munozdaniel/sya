<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Tipo de Equipo</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->
{{ content() }}
{{ form("tipoEquipo/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("tipoEquipo", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <label for="tipoEquipo_nombre">Nombre del Equipo</label>
    <div class="form-group">
        {{ text_field("tipoEquipo_nombre", "size" : 30) }}
    </div>
</div><!-- /.Cuerpo -->


<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("tipoEquipo_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>