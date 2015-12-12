
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("columnaextra/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("columnaextra/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>ColumnaExtra</th>
            <th>ColumnaExtra Of Nombre</th>
            <th>ColumnaExtra Of Descripcion</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for columnaextra in page.items %}
        <tr>
            <td>{{ columnaextra.getColumnaextraId() }}</td>
            <td>{{ columnaextra.getColumnaextraNombre() }}</td>
            <td>{{ columnaextra.getColumnaextraDescripcion() }}</td>
            <td>{{ link_to("columnaextra/edit/"~columnaextra.getColumnaextraId(), "Edit") }}</td>
            <td>{{ link_to("columnaextra/delete/"~columnaextra.getColumnaextraId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("columnaextra/search", "First") }}</td>
                        <td>{{ link_to("columnaextra/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("columnaextra/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("columnaextra/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
