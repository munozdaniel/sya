
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("tipocarga/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("tipocarga/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>TipoCarga</th>
            <th>TipoCarga Of Nombre</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for tipocarga in page.items %}
        <tr>
            <td>{{ tipocarga.getTipocargaId() }}</td>
            <td>{{ tipocarga.getTipocargaNombre() }}</td>
            <td>{{ link_to("tipocarga/edit/"~tipocarga.getTipocargaId(), "Edit") }}</td>
            <td>{{ link_to("tipocarga/delete/"~tipocarga.getTipocargaId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("tipocarga/search", "First") }}</td>
                        <td>{{ link_to("tipocarga/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("tipocarga/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("tipocarga/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
