
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("remito/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("remito/new", "Create ") }}
        </td>
    </tr>
</table>


<table id="remitoTabla" class="table table-bordered hover " cellspacing="0" width="100%">
    <thead>

    <tr>
        <th>ORDEN</th>
        <th>REMITO</th>
        <th>PATENTE</th>
        <th>N° INTERNO</th>
        <th>TIPO DE EQUIPO</th>
        <th>TIPO DE CARGA</th>
        <th>DNI</th>
        <th>CHOFER</th>
        <th>FECHA</th>
        <th>CLIENTE</th>
        <th>ORIGEN</th>
        <th>DESTINO</th>
        <th>EQUIPO/POZO</th>
        <th>CONCATENADO</th>
        <th>OPERADORA</th>
        <th>LINEA-PSL</th>
        <th>CENTRO COSTO</th>
        <th>OBSERVACIONES</th>
        <th>KM</th>
        <th>HS HIDRO</th>
        <th>HS MALACATE</th>
        <th>HS SERVICIO</th>
        <th>HS STAND</th>
        <th>CONFORMIDAD RE</th>
        <th>MOT NO CONFORM RE</th>
    </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
        {% for remito in page.items %}
            <tr>
                <td>{{ remito.getRemitoNroOrden() }}</td>
                <td>{{ remito.getRemitoNro() }}</td>
                <td>{{ remito.getTransporte().getTransporteDominio() }}</td>
                <td>{{ remito.getTransporte().getTransporteNroInterno() }}</td>
                <td>{{ remito.getTipoequipo().getTipoequipoNombre() }}</td>
                <td>{{ remito.getTipocarga().getTipocargaNombre() }}</td>
                <td>{{ remito.getChofer().getChoferDni() }}</td>
                <td>{{ remito.getChofer().getChoferNombreCompleto() }}</td>
                <td>{{ remito.getRemitoFecha() }}</td>
                <td>{{ remito.getCliente().getClienteNombre() }}</td>
                <td>{{ remito.getViaje().getViajeOrigen() }}</td>
                <td>{{ remito.getEquipopozo().getYacimiento().getYacimientoDestino() }}</td>
                <td>{{ remito.getEquipopozo().getEquipopozoNombre() }}</td>
                <td>{{ remito.getConcatenado().getConcatenadoNombre() }}</td>
                <td>{{ remito.getRemitoOperadoraid() }}</td>
                <td>{{ remito.getCentrocosto().getLinea().getLineaNombre() }}</td>
                <td>{{ remito.getCentrocosto().getCentrocostoCodigo() }}</td>
                <td>{{ remito.getRemitoObservacion() }}</td>
                <td>{{ remito.getTarifa().getTarifaKm() }}</td>
                <td>{{ remito.getTarifa().getTarifaHshidro() }}</td>
                <td>{{ remito.getTarifa().getTarifaHsmalacate() }}</td>
                <td>{{ remito.getTarifa().getTarifaHsservicio() }}</td>
                <td>{{ remito.getTarifa().getTarifaHsstand() }}</td>
                <td>{{ remito.getRemitoConformidad() }}</td>
                <td>{{ remito.getRemitoNoconformidad() }}</td>
            </tr>
        {% endfor %}
    {% endif %}
    </tbody>

</table>
{{ link_to("remito/search", "First") }}
{{ link_to("remito/search?page="~page.before, "Previous") }}
{{ link_to("remito/search?page="~page.next, "Next") }}
{{ link_to("remito/search?page="~page.last, "Last") }}
{{ page.current~"/"~page.total_pages }}

<script>
    var editor; // use a global for the submit and return data rendering in the examples
    $(document).ready(function () {
        editor = new $.fn.dataTable.Editor();

        var table = $('#remitoTabla').DataTable({
            'paging': true,
            'ordering': true,
            'info': true,
            fixedHeader: true,
            scrollX: 'true',
            processing: true,
            colReorder:true,
            select: {
                style: 'multi'
            }, buttons: [
                { extend: "create", editor: editor },
                { extend: "edit",   editor: editor },
                { extend: "remove", editor: editor }
            ]
        });
        table.on('xhr', function (e, settings, json) {
            console.log('Ajax event occurred. Returned data: ', json);

        });
        table.on( 'draw.dt', function ( e, settings ) {
            console.log( 'Column width recalculated in table' );
            table.colReorder.order([1, 2, 9, 10, 11, 0, 3, 4, 5, 6, 7, 19, 20, 21, 22, 8, 12, 13, 14, 15, 16, 17, 18, 23, 24], true);
        });
        table.on('mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;
            $(table.cells().nodes()).removeClass('highlight');
            $(table.column(colIdx).nodes()).addClass('highlight');
        });


    });
</script>