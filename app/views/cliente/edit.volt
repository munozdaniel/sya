<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Cliente</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("cliente/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("cliente", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <label for="linea_nombre">Nombre de la Linea</label>
    <div class="form-group">
        {{ text_field("cliente_nombre", "size" : 30) }}
    </div>
</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("cliente_id") }}
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
            <label for="cliente_habilitado">Cliente Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("cliente_habilitado", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_equipoPozoId">Cliente Of EquipoPozoId</label>
        </td>
        <td align="left">
            {{ text_field("cliente_equipoPozoId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_centroCostoId">Cliente Of CentroCostoId</label>
        </td>
        <td align="left">
            {{ text_field("cliente_centroCostoId", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
