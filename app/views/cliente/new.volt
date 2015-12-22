<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Cliente</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}

{{ form("cliente/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("cliente", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    {#======================================================#}
    {{ formCliente.label('cliente_nombre') }}
    <div class="form-group">
        {{ formCliente.render('cliente_nombre') }}
    </div>
    {#======================================================#}
    {{ formCliente.label('cliente_operadora') }}
    <div class="form-group">
        {{ formCliente.render('cliente_operadora') }}
    </div>
    {#======================================================#}
    {{ formCliente.label('yacimiento_destino') }}
    <div class="form-group">
        {{ formCliente.render('yacimiento_destino') }}
    </div>
    {#======================================================#}
    {{ formCliente.label('equipoPozo_nombre') }}
    <div class="form-group">
        {{ formCliente.render('equipoPozo_nombre') }}
    </div>
    {#======================================================#}
    {{ formCliente.label('linea_nombre') }}
    <div class="form-group">
        {{ formCliente.render('linea_nombre') }}
    </div>
    {#======================================================#}
    {{ formCliente.label('centroCosto_codigo') }}
    <div class="form-group">
        {{ formCliente.render('centroCosto_codigo') }}
    </div>

</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>

<table>
    <tr>
        <td align="right">
            <label for="cliente_nombre">Cliente Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("cliente_nombre", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_operadora">Cliente Of Operadora</label>
        </td>
        <td align="left">
            {{ text_field("cliente_operadora", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_frs">Cliente Of Frs</label>
        </td>
        <td align="left">
            {{ text_field("cliente_frs", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_linea">Cliente Of Linea</label>
        </td>
        <td align="left">
            {{ text_field("cliente_linea", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_yacimiento">Cliente Of Yacimiento</label>
        </td>
        <td align="left">
            {{ text_field("cliente_yacimiento", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_habilitado">Cliente Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("cliente_habilitado", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
