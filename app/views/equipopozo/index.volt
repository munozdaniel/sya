
{{ content() }}

<div align="right">
    {{ link_to("equipopozo/new", "Create equipopozo") }}
</div>

{{ form("equipopozo/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search equipopozo</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="equipoPozo_id">EquipoPozo</label>
        </td>
        <td align="left">
            {{ text_field("equipoPozo_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="equipoPozo_nombre">EquipoPozo Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("equipoPozo_nombre", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="equipoPozo_habilitado">EquipoPozo Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("equipoPozo_habilitado", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
