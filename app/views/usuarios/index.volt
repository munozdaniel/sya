
{{ content() }}

<div align="right">
    {{ link_to("usuarios/new", "Create usuarios") }}
</div>

{{ form("usuarios/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search usuarios</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="usuario_id">Usuario</label>
        </td>
        <td align="left">
            {{ text_field("usuario_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_nick">Usuario Of Nick</label>
        </td>
        <td align="left">
            {{ text_field("usuario_nick", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_nombreCompleto">Usuario Of NombreCompleto</label>
        </td>
        <td align="left">
            {{ text_field("usuario_nombreCompleto", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_contrasenia">Usuario Of Contrasenia</label>
        </td>
        <td align="left">
            {{ text_field("usuario_contrasenia", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_sector">Usuario Of Sector</label>
        </td>
        <td align="left">
            {{ text_field("usuario_sector", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_email">Usuario Of Email</label>
        </td>
        <td align="left">
            {{ text_field("usuario_email", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_activo">Usuario Of Activo</label>
        </td>
        <td align="left">
            {{ text_field("usuario_activo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_fechaCreacion">Usuario Of FechaCreacion</label>
        </td>
        <td align="left">
            {{ text_field("usuario_fechaCreacion", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="usuario_imagen">Usuario Of Imagen</label>
        </td>
        <td align="left">
            {{ text_field("usuario_imagen", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
