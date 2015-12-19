<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Centro Costo</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("centrocosto/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("centrocosto", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>


<!-- Cuerpo -->
<div class="box-body">
    {#======================================================#}
    <label for="centroCosto_codigo">Codigo</label>
    <div class="form-group">
        {{ text_field("centroCosto_codigo", "size" : 30) }}
    </div>
</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>