<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Yacimiento</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("yacimiento/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("yacimiento", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <label for="yacimiento_destino">Destino</label>

    <div class="form-group">
        {{ text_field("yacimiento_destino", "size" : 30) }}
    </div>
    {#==================================================#}

</div><!-- /. Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
