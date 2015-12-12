
{{ form("linea/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("linea", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create linea</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
