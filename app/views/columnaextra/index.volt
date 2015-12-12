
{{ content() }}

<div align="right">
    {{ link_to("columnaextra/new", "Create columnaextra") }}
</div>

{{ form("columnaextra/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search columnaextra</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="columnaExtra_id">ColumnaExtra</label>
        </td>
        <td align="left">
            {{ text_field("columnaExtra_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="columnaExtra_nombre">ColumnaExtra Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("columnaExtra_nombre", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="columnaExtra_descripcion">ColumnaExtra Of Descripcion</label>
        </td>
        <td align="left">
            {{ text_field("columnaExtra_descripcion", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
