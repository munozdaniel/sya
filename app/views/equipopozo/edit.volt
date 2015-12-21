<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Equipo/Pozo</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->
{{ content() }}
{{ form("equipopozo/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("equipopozo", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <label for="equipoPozo_nombre">Nombre</label>
    <div class="form-group">
        {{ text_field("equipoPozo_nombre", "size" : 30) }}
    </div>
</div><!-- /.Cuerpo -->


<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("equipoPozo_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
