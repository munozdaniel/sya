<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Tipo de Carga</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}

{{ form("tipoequipo/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("tipocarga", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <label for="tipoCarga_nombre">Nombre de la Carga</label>

    <div class="form-group">
        {{ text_field("tipoCarga_nombre", "size" : 30) }}
    </div>
    {#==================================================#}
</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
