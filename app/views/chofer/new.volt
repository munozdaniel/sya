
{{ form("chofer/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("chofer", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create chofer</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
