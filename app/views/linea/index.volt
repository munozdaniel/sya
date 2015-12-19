<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Linea</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("linea/new", "Crear Linea",'class':'btn btn-large btn-danger btn-flat') }}
</div>
{{ content() }}
{{ form("linea/search", "method":"post", "autocomplete" : "off") }}
<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <label for="linea_id">N° de Linea</label>

    <div class="form-group">
        {{ text_field("linea_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="linea_nombre">Nombre de la Linea</label>

    <div class="form-group">
        {{ text_field("linea_nombre", "size" : 30) }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("linea_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>

<table>
    <tr>
        <td align="right">
            <label for="linea_id">Linea</label>
        </td>
        <td align="left">
            {{ text_field("linea_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="linea_nombre">Linea Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("linea_nombre", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="linea_centroCosto">Linea Of CentroCosto</label>
        </td>
        <td align="left">
            {{ text_field("linea_centroCosto", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="linea_habilitado">Linea Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("linea_habilitado", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
