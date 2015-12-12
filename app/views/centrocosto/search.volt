
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("centrocosto/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("centrocosto/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>CentroCosto</th>
            <th>CentroCosto Of Codigo</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for centrocosto in page.items %}
        <tr>
            <td>{{ centrocosto.getCentrocostoId() }}</td>
            <td>{{ centrocosto.getCentrocostoCodigo() }}</td>
            <td>{{ link_to("centrocosto/edit/"~centrocosto.getCentrocostoId(), "Edit") }}</td>
            <td>{{ link_to("centrocosto/delete/"~centrocosto.getCentrocostoId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("centrocosto/search", "First") }}</td>
                        <td>{{ link_to("centrocosto/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("centrocosto/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("centrocosto/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
