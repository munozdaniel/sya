<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar FRS</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("frs/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("frs", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <label for="frs_codigo">Codigo FRS</label>
    <div class="form-group">
        {{ text_field("frs_codigo", "size" : 30) }}
    </div>
</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("frs_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>