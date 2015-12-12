
{{ content() }}

<div align="right">
    {{ link_to("linea/new", "Create linea") }}
</div>

{{ form("linea/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search linea</h1>
</div>

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
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
