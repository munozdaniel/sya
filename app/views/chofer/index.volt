
{{ content() }}

<div align="right">
    {{ link_to("chofer/new", "Create chofer") }}
</div>

{{ form("chofer/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search chofer</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="chofer_id">Chofer</label>
        </td>
        <td align="left">
            {{ text_field("chofer_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="chofer_nombreCompleto">Chofer Of NombreCompleto</label>
        </td>
        <td align="left">
            {{ text_field("chofer_nombreCompleto", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="chofer_dni">Chofer Of Dni</label>
        </td>
        <td align="left">
            {{ text_field("chofer_dni", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="chofer_esFletero">Chofer Of EsFletero</label>
        </td>
        <td align="left">
            {{ text_field("chofer_esFletero", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
