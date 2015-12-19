
{{ content() }}

<div align="right">
    {{ link_to("yacimiento/new", "Create yacimiento") }}
</div>

{{ form("yacimiento/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search yacimiento</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="yacimiento_id">Yacimiento</label>
        </td>
        <td align="left">
            {{ text_field("yacimiento_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="yacimiento_destino">Yacimiento Of Destino</label>
        </td>
        <td align="left">
            {{ text_field("yacimiento_destino", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="yacimiento_equipoPozo">Yacimiento Of EquipoPozo</label>
        </td>
        <td align="left">
            {{ text_field("yacimiento_equipoPozo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="yacimiento_habilitado">Yacimiento Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("yacimiento_habilitado", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
