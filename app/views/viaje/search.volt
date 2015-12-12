
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("viaje/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("viaje/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Viaje</th>
            <th>Viaje Of Origen</th>
            <th>Viaje Of Concatenado</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for viaje in page.items %}
        <tr>
            <td>{{ viaje.getViajeId() }}</td>
            <td>{{ viaje.getViajeOrigen() }}</td>
            <td>{{ viaje.getViajeConcatenado() }}</td>
            <td>{{ link_to("viaje/edit/"~viaje.getViajeId(), "Edit") }}</td>
            <td>{{ link_to("viaje/delete/"~viaje.getViajeId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("viaje/search", "First") }}</td>
                        <td>{{ link_to("viaje/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("viaje/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("viaje/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
