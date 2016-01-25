<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Cliente</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("cliente/new", "Crear Cliente",'class':'btn btn-large btn-danger btn-flat') }}
    {{ link_to("cliente/search", "Filtro",'class':'btn btn-large btn-success btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("cliente/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">

    {#===============================================#}
    <label for="cliente_id">N° de Cliente</label>

    <div class="form-group">
        {{ text_field("cliente_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="cliente_nombre">Nombre del Cliente</label>

    <div class="form-group">
        {{ text_field("cliente_nombre", "size" : 30) }}
    </div>
    {#===============================================#}
    <label for="cliente_operadora">Operadora</label>

    <div class="form-group">
        {{ text_field("cliente_operadora", "size" : 30) }}
    </div>
    {#===============================================#}
    <label for="cliente_operadora">FRS</label>

    <div class="form-group">
        {{ text_field("cliente_operadora", "size" : 30) }}
    </div>
    {#===============================================#}
    <label for="cliente_operadora">Destino</label>

    <div class="form-group">
        {{ text_field("cliente_operadora", "size" : 30) }}
    </div>
    {#===============================================#}
    <label for="cliente_operadora">Equipo/Pozo</label>

    <div class="form-group">
        {{ text_field("cliente_operadora", "size" : 30) }}
    </div>
    {#===============================================#}
    <label for="cliente_operadora">Linea</label>

    <div class="form-group">
        {{ text_field("cliente_operadora", "size" : 30) }}
    </div>
    {#===============================================#}
    <label for="cliente_operadora">Centro Costo</label>

    <div class="form-group">
        {{ text_field("cliente_operadora", "size" : 30) }}
    </div>
    {#===============================================#}
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("frs_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

<!--
<table>
    <tr>
        <td align="right">
            <label for="cliente_id">Cliente</label>
        </td>
        <td align="left">
            {{ text_field("cliente_id", "type" : "numeric") }}
        </td>
    </tr>
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
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
-->