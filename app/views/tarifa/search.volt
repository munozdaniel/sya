
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("tarifa/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("tarifa/new", "Create ") }}
        </td>
    </tr>
</table>

<table class="browse" align="center">
    <thead>
        <tr>
            <th>Tarifa</th>
            <th>Tarifa Of HoraInicial</th>
            <th>Tarifa Of HoraFinal</th>
            <th>Tarifa Of HsServicio</th>
            <th>Tarifa Of HsHidro</th>
            <th>Tarifa Of HsMalacate</th>
            <th>Tarifa Of HsStand</th>
            <th>Tarifa Of Km</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for tarifa in page.items %}
        <tr>
            <td>{{ tarifa.getTarifaId() }}</td>
            <td>{{ tarifa.getTarifaHorainicial() }}</td>
            <td>{{ tarifa.getTarifaHorafinal() }}</td>
            <td>{{ tarifa.getTarifaHsservicio() }}</td>
            <td>{{ tarifa.getTarifaHshidro() }}</td>
            <td>{{ tarifa.getTarifaHsmalacate() }}</td>
            <td>{{ tarifa.getTarifaHsstand() }}</td>
            <td>{{ tarifa.getTarifaKm() }}</td>
            <td>{{ link_to("tarifa/edit/"~tarifa.getTarifaId(), "Edit") }}</td>
            <td>{{ link_to("tarifa/delete/"~tarifa.getTarifaId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("tarifa/search", "First") }}</td>
                        <td>{{ link_to("tarifa/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("tarifa/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("tarifa/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
