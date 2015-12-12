
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("chofer/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("chofer/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Chofer</th>
            <th>Chofer Of NombreCompleto</th>
            <th>Chofer Of Dni</th>
            <th>Chofer Of EsFletero</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for chofer in page.items %}
        <tr>
            <td>{{ chofer.getChoferId() }}</td>
            <td>{{ chofer.getChoferNombrecompleto() }}</td>
            <td>{{ chofer.getChoferDni() }}</td>
            <td>{{ chofer.getChoferEsfletero() }}</td>
            <td>{{ link_to("chofer/edit/"~chofer.getChoferId(), "Edit") }}</td>
            <td>{{ link_to("chofer/delete/"~chofer.getChoferId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("chofer/search", "First") }}</td>
                        <td>{{ link_to("chofer/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("chofer/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("chofer/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
