
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("tipoequipo/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("tipoequipo/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>TipoEquipo</th>
            <th>TipoEquipo Of Nombre</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for tipoequipo in page.items %}
        <tr>
            <td>{{ tipoequipo.getTipoequipoId() }}</td>
            <td>{{ tipoequipo.getTipoequipoNombre() }}</td>
            <td>{{ link_to("tipoequipo/edit/"~tipoequipo.getTipoequipoId(), "Edit") }}</td>
            <td>{{ link_to("tipoequipo/delete/"~tipoequipo.getTipoequipoId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("tipoequipo/search", "First") }}</td>
                        <td>{{ link_to("tipoequipo/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("tipoequipo/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("tipoequipo/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
