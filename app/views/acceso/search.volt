
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("acceso/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("acceso/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Acceso</th>
            <th>Rol</th>
            <th>Pagina</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for acceso in page.items %}
        <tr>
            <td>{{ acceso.getAccesoId() }}</td>
            <td>{{ acceso.getRolId() }}</td>
            <td>{{ acceso.getPaginaId() }}</td>
            <td>{{ link_to("acceso/edit/"~acceso.getAccesoId(), "Edit") }}</td>
            <td>{{ link_to("acceso/delete/"~acceso.getAccesoId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("acceso/search", "First") }}</td>
                        <td>{{ link_to("acceso/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("acceso/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("acceso/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
