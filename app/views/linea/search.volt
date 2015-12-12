
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("linea/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("linea/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Linea</th>
            <th>Linea Of Nombre</th>
            <th>Linea Of CentroCosto</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for linea in page.items %}
        <tr>
            <td>{{ linea.getLineaId() }}</td>
            <td>{{ linea.getLineaNombre() }}</td>
            <td>{{ linea.getLineaCentrocosto() }}</td>
            <td>{{ link_to("linea/edit/"~linea.getLineaId(), "Edit") }}</td>
            <td>{{ link_to("linea/delete/"~linea.getLineaId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("linea/search", "First") }}</td>
                        <td>{{ link_to("linea/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("linea/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("linea/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
