
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("yacimiento/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("yacimiento/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Yacimiento</th>
            <th>Yacimiento Of Destino</th>
            <th>Yacimiento Of EquipoPozo</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for yacimiento in page.items %}
        <tr>
            <td>{{ yacimiento.getYacimientoId() }}</td>
            <td>{{ yacimiento.getYacimientoDestino() }}</td>
            <td>{{ yacimiento.getYacimientoEquipopozo() }}</td>
            <td>{{ link_to("yacimiento/edit/"~yacimiento.getYacimientoId(), "Edit") }}</td>
            <td>{{ link_to("yacimiento/delete/"~yacimiento.getYacimientoId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("yacimiento/search", "First") }}</td>
                        <td>{{ link_to("yacimiento/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("yacimiento/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("yacimiento/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
