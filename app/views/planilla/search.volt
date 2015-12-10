
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("planilla/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("planilla/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Planilla</th>
            <th>Planilla Of NombreCliente</th>
            <th>Planilla Of Fecha</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for planilla in page.items %}
        <tr>
            <td>{{ planilla.getPlanillaId() }}</td>
            <td>{{ planilla.getPlanillaNombrecliente() }}</td>
            <td>{{ planilla.getPlanillaFecha() }}</td>
            <td>{{ link_to("planilla/edit/"~planilla.getPlanillaId(), "Edit") }}</td>
            <td>{{ link_to("planilla/delete/"~planilla.getPlanillaId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("planilla/search", "First") }}</td>
                        <td>{{ link_to("planilla/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("planilla/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("planilla/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
