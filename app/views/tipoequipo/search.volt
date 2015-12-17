
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("tipoEquipo/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("tipoEquipo/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>TipoEquipo</th>
            <th>TipoEquipo Of Nombre</th>
            <th>TipoEquipo Of Habilitado</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for tipoEquipo in page.items %}
        <tr>
            <td>{{ tipoEquipo.getTipoequipoId() }}</td>
            <td>{{ tipoEquipo.getTipoequipoNombre() }}</td>
            <td>{{ tipoEquipo.getTipoequipoHabilitado() }}</td>
            <td>{{ link_to("tipoEquipo/edit/"~tipoEquipo.getTipoequipoId(), "Edit") }}</td>
            <td>{{ link_to("tipoEquipo/delete/"~tipoEquipo.getTipoequipoId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("tipoEquipo/search", "First") }}</td>
                        <td>{{ link_to("tipoEquipo/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("tipoEquipo/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("tipoEquipo/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
