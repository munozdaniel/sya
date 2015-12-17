
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("pagina/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("pagina/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Pagina</th>
            <th>Pagina Of NombreControlador</th>
            <th>Pagina Of NombreAccion</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for pagina in page.items %}
        <tr>
            <td>{{ pagina.getPaginaId() }}</td>
            <td>{{ pagina.getPaginaNombrecontrolador() }}</td>
            <td>{{ pagina.getPaginaNombreaccion() }}</td>
            <td>{{ link_to("pagina/edit/"~pagina.getPaginaId(), "Edit") }}</td>
            <td>{{ link_to("pagina/delete/"~pagina.getPaginaId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("pagina/search", "First") }}</td>
                        <td>{{ link_to("pagina/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("pagina/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("pagina/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
