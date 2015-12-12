{{ content() }}
{{ form("equipopozo/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("equipopozo", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit equipopozo</h1>
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
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
