
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("cliente/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("cliente/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Cliente Of Nombre</th>
            <th>Cliente Of Operadora</th>
            <th>Cliente Of Frs</th>
            <th>Cliente Of Linea</th>
            <th>Cliente Of Yacimiento</th>
            <th>Cliente Of Habilitado</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for cliente in page.items %}
        <tr>
            <td>{{ cliente.getClienteId() }}</td>
            <td>{{ cliente.getClienteNombre() }}</td>
            <td>{{ cliente.getClienteOperadora() }}</td>
            <td>{{ cliente.getClienteFrs() }}</td>
            <td>{{ cliente.getClienteLinea() }}</td>
            <td>{{ cliente.getClienteYacimiento() }}</td>
            <td>{{ cliente.getClienteHabilitado() }}</td>
            <td>{{ link_to("cliente/edit/"~cliente.getClienteId(), "Edit") }}</td>
            <td>{{ link_to("cliente/delete/"~cliente.getClienteId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("cliente/search", "First") }}</td>
                        <td>{{ link_to("cliente/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("cliente/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("cliente/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
