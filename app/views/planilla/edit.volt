{{ content() }}
{{ form("planilla/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("planilla", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit planilla</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="planilla_nombreCliente">Planilla Of NombreCliente</label>
        </td>
        <td align="left">
            {{ text_field("planilla_nombreCliente", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="planilla_fecha">Planilla Of Fecha</label>
        </td>
        <td align="left">
                {{ text_field("planilla_fecha", "type" : "date") }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
