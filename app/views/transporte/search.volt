
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("transporte/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("transporte/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Transporte</th>
            <th>Transporte Of Dominio</th>
            <th>Transporte Of NroInterno</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for transporte in page.items %}
        <tr>
            <td>{{ transporte.getTransporteId() }}</td>
            <td>{{ transporte.getTransporteDominio() }}</td>
            <td>{{ transporte.getTransporteNrointerno() }}</td>
            <td>{{ link_to("transporte/edit/"~transporte.getTransporteId(), "Edit") }}</td>
            <td>{{ link_to("transporte/delete/"~transporte.getTransporteId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("transporte/search", "First") }}</td>
                        <td>{{ link_to("transporte/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("transporte/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("transporte/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
