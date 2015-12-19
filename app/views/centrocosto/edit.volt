<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Centro Costo</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("centrocosto/save", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">{{ link_to("centrocosto", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <label for="centroCosto_codigo">Codigo</label>

    <div class="form-group">
        {{ text_field("centroCosto_codigo", "size" : 30) }}
    </div>
</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("centroCosto_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
