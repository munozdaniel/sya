
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("orden/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("orden/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Orden Of Planilla</th>
            <th>Orden Of Periodo</th>
            <th>Orden Of Transporte</th>
            <th>Orden Of TipoEquipo</th>
            <th>Orden Of TipoCarga</th>
            <th>Orden Of Chofer</th>
            <th>Orden Of Cliente</th>
            <th>Orden Of Viaje</th>
            <th>Orden Of Tarifa</th>
            <th>Orden Of ColumnaExtra</th>
            <th>Orden Of Observacion</th>
            <th>Orden Of Fecha</th>
            <th>Orden Of FechaCreacion</th>
            <th>Orden Of Conformidad</th>
            <th>Orden Of NoConformidad</th>
            <th>Orden Of CreadoPor</th>
            <th>Orden Of Habilitado</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for orden in page.items %}
        <tr>
            <td>{{ orden.getOrdenId() }}</td>
            <td>{{ orden.getOrdenPlanilla() }}</td>
            <td>{{ orden.getOrdenPeriodo() }}</td>
            <td>{{ orden.getOrdenTransporte() }}</td>
            <td>{{ orden.getOrdenTipoequipo() }}</td>
            <td>{{ orden.getOrdenTipocarga() }}</td>
            <td>{{ orden.getOrdenChofer() }}</td>
            <td>{{ orden.getOrdenCliente() }}</td>
            <td>{{ orden.getOrdenViaje() }}</td>
            <td>{{ orden.getOrdenTarifa() }}</td>
            <td>{{ orden.getOrdenColumnaextra() }}</td>
            <td>{{ orden.getOrdenObservacion() }}</td>
            <td>{{ orden.getOrdenFecha() }}</td>
            <td>{{ orden.getOrdenFechacreacion() }}</td>
            <td>{{ orden.getOrdenConformidad() }}</td>
            <td>{{ orden.getOrdenNoconformidad() }}</td>
            <td>{{ orden.getOrdenCreadopor() }}</td>
            <td>{{ orden.getOrdenHabilitado() }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/delete/"~orden.getOrdenId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("orden/search", "First") }}</td>
                        <td>{{ link_to("orden/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("orden/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("orden/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
