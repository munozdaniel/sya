{{ content() }}
{{ form("archivo/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("archivo", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit archivo</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="archivo_carpeta">Archivo Of Carpeta</label>
        </td>
        <td align="left">
            {{ text_field("archivo_carpeta", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="archivo_nombre">Archivo Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("archivo_nombre", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="archivo_fechaCreacion">Archivo Of FechaCreacion</label>
        </td>
        <td align="left">
                {{ text_field("archivo_fechaCreacion", "type" : "date") }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
