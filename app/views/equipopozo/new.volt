
{{ form("equipopozo/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("equipopozo", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create equipopozo</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
