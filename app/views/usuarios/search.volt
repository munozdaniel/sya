
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("usuarios/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("usuarios/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Usuario Of Nick</th>
            <th>Usuario Of NombreCompleto</th>
            <th>Usuario Of Contrasenia</th>
            <th>Usuario Of Sector</th>
            <th>Usuario Of Email</th>
            <th>Usuario Of Activo</th>
            <th>Usuario Of FechaCreacion</th>
            <th>Usuario Of Imagen</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for usuario in page.items %}
        <tr>
            <td>{{ usuario.getUsuarioId() }}</td>
            <td>{{ usuario.getUsuarioNick() }}</td>
            <td>{{ usuario.getUsuarioNombrecompleto() }}</td>
            <td>{{ usuario.getUsuarioContrasenia() }}</td>
            <td>{{ usuario.getUsuarioSector() }}</td>
            <td>{{ usuario.getUsuarioEmail() }}</td>
            <td>{{ usuario.getUsuarioActivo() }}</td>
            <td>{{ usuario.getUsuarioFechacreacion() }}</td>
            <td>{{ usuario.getUsuarioImagen() }}</td>
            <td>{{ link_to("usuarios/edit/"~usuario.getUsuarioId(), "Edit") }}</td>
            <td>{{ link_to("usuarios/delete/"~usuario.getUsuarioId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("usuarios/search", "First") }}</td>
                        <td>{{ link_to("usuarios/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("usuarios/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("usuarios/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
