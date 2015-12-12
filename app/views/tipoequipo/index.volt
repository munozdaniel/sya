
{{ content() }}

<div align="right">
    {{ link_to("tipoequipo/new", "Create tipoequipo") }}
</div>

{{ form("tipoequipo/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search tipoequipo</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="tipoEquipo_id">TipoEquipo</label>
        </td>
        <td align="left">
            {{ text_field("tipoEquipo_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tipoEquipo_nombre">TipoEquipo Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("tipoEquipo_nombre", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
