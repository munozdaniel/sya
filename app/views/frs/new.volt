<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear FRS</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}

{{ form("frs/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("frs", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6">
        <label for="frs_codigo">Codigo FRS</label>

        <div class="form-group">
            {{ text_field("frs_codigo", "size" : 50,'class':'form-control','placeholder':'INGRESE EL CODIGO') }}
        </div>
    </div>
    {#==================================================#}
    <div class="col-md-6">
        <label for="frs_codigo">Codigo FRS</label>

        <div class="form-group">
            {{ operadoras }}
        </div>
    </div>
</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
