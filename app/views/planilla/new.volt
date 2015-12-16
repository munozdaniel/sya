<div class="box-header with-border">
    <h3 class="box-title">Crear planilla</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->

{{ content() }}
{{ form("planilla/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("planilla", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <label for="planilla_nombreCliente">Nombre de la Planilla</label>

    <div class="form-group">
        {{ text_field("planilla_nombreCliente", "size" : 30) }}
    </div>
</div><!-- /.box-body -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
