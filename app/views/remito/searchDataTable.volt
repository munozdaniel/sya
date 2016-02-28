<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Listado de Remitos <br>
            <small>searchDataTable</small>
        </h3>

        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/index", "<i class='fa fa-search'></i> Buscar Remitos",'class':'btn btn-flat btn-large bg-olive') }}
                </td>
                <td align="right">
                    {{ link_to("remito/nuevoRemito", "<i class='fa fa-plus-square'></i> Agregar Remito",'class':'btn btn-flat btn-large btn-danger') }}
                    {{ link_to("remito/generarExcel", "<i class='fa fa-file'></i> Generar Excel",'class':'btn btn-flat btn-gris') }}
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- /.box-header -->
{{ content() }}
<div class="box box-body">
    {{ link_to("remito/searchDataTable", "First") }}
    {{ link_to("remito/searchDataTable?page="~page.before, "Previous") }}
    {{ link_to("remito/searchDataTable?page="~page.next, "Next") }}
    {{ link_to("remito/searchDataTable?page="~page.last, "Last") }}
    {{ page.current~"/"~page.total_pages }}

    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>NRO</th>
            <th>Remito Sya</th>
            <th>Nombre Planilla</th>
            <th>Dominio</th>
            <th>Tipo Equipo</th>
            <th>Tipo Carga</th>
            <th>DNI</th>
            <th>Origen</th>
            <th>Concatenado</th>
            <th>Tarifa</th>
            <th>ClienteId</th>
            <th>CentroCostoId</th>
            <th>EquipoPozoId</th>
            <th>OperadoraId</th>
            <th>Observacion</th>
            <th>Fecha</th>
            <th>Conformidad</th>
            <th>NoConformidad</th>
            <th>NoConformidad</th>

        </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for remito in page.items %}
                    <tr>

                    <td>{{ remito.getRemitoNroOrden() }}</td>
                    <td>{{ remito.getRemitoNro() }}</td>
                    <td>{{ remito.getPlanilla().getPlanillaNombreCliente() }}</td>
                    <td>{{ remito.getTransporte().getTransporteDominio() }}</td>
                    <td>{{ remito.getTipoequipo().getTipoequipoNombre() }}</td>
                    <td>{{ remito.getTipocarga().getTipocargaNombre() }}</td>
                    <td>{{ remito.getChofer().getChoferNombreCompleto() }}</td>
                    <td>{{ remito.getChofer().getChoferDni() }}</td>
                    <td>{{ remito.getViaje().getViajeOrigen() }}</td>
                    <td>{{ remito.getConcatenado().getConcatenadoNombre() }}</td>
                    <td>{{ remito.getTarifa().getTarifaKm() }}</td>
                    <td>{{ remito.getCliente().getClienteNombre() }}</td>
                    <td>{{ remito.getCentrocosto().getCentrocostoCodigo() }}</td>
                    <td>{{ remito.getEquipopozo().getEquipopozoNombre() }}</td>
                    <td>{{ remito.getOperadora().getOperadoraNombre() }}</td>
                    <td>{{ remito.getRemitoObservacion() }}</td>
                    <td>{{ remito.getRemitoFecha() }}</td>
                    <td>{{ remito.getRemitoConformidad() }}</td>
                    <td>{{ remito.getRemitoNoConformidad() }}</td>
                </tr>
            {% endfor %}
        {% endif %}

        </tbody>
    </table>
    </div>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            'paging':   true,
            'ordering': true,
            'info':     true,
            'colReorder': true,
            stateSave: true,
            fixedHeader: true,
            scrollY:        '80vh',
            scrollX:        'true',
            scrollCollapse: true

        });
        $('#example tbody')
                .on( 'mouseenter', 'td', function () {
                    var colIdx = table.cell(this).index().column;
                    table.colReorder.order( [0 , 1 ,9,10,11,2, 3, 4, 5,6,7,19,20,21,22,8,12,13,14,15,16,17,18,23,24 ], true );
                    $( table.cells().nodes() ).removeClass( 'highlight' );
                    $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
                } );


    } );
</script>