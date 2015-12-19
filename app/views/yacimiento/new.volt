
{{ form("yacimiento/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("yacimiento", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create yacimiento</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
