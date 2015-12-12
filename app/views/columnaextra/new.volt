
{{ form("columnaextra/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("columnaextra", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create columnaextra</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
