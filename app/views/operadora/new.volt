<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Operadora</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("operadora/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("operadora", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <label for="operadora_nombre">Operadora</label>

    <div class="form-group">
        {{ text_field("operadora_nombre", "size" : 30) }}
    </div>
    {#==================================================#}

</div><!-- /. Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>

