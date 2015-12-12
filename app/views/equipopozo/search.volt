
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("equipopozo/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("equipopozo/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>EquipoPozo</th>
            <th>EquipoPozo Of Nombre</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for equipopozo in page.items %}
        <tr>
            <td>{{ equipopozo.getEquipopozoId() }}</td>
            <td>{{ equipopozo.getEquipopozoNombre() }}</td>
            <td>{{ link_to("equipopozo/edit/"~equipopozo.getEquipopozoId(), "Edit") }}</td>
            <td>{{ link_to("equipopozo/delete/"~equipopozo.getEquipopozoId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("equipopozo/search", "First") }}</td>
                        <td>{{ link_to("equipopozo/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("equipopozo/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("equipopozo/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
