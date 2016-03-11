<div class="box box-primary">
    <div class="box-header">
        <h3>BUSQUEDA PERSONALIZADA
            <br><small>Para obtener todos los remitos solo haga click en buscar sin ingresar datos en el formulario</small>
        </h3>
        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/searchDataTable", "<i class='fa fa-search'></i> Nueva Busqueda",'class':'btn btn-flat btn-large bg-olive') }}
                </td>

            </tr>
        </table>
    </div>
</div>
{#=============================================================================================================#}
<section id="seccion-busqueda">
    {{ partial("remito/parcial/input") }}
</section>

{#=============================================================================================================#}
<!-- /.box-header -->
{{ content() }}
<section id="seccion-tabla" class="box box-body ocultar">


    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ORDEN</th>
            <th>REMITO</th>
            <th>PATENTE</th>
            <th>NRO INTERNO</th>
            <th>TIPO EQUIPO</th>

            <th>TIPO CARGA</th>
            <th>DNI</th>
            <th>CHOFER</th>
            <th>FECHA</th>
            <th>CLIENTE</th>

            <th>ORIGEN</th>
            <th>DESTINO</th>
            <th>EQUIPO/POZO</th>
            <th>CONCATENADO</th>
            <th>OPERADORA</th>

            <th>LINEA</th>
            <th>CENTRO DE COSTO</th>
            <th>OBSERVACIONES</th>
            <th>KM</th>
            <th>HS HIDRO</th>

            <th>HS MALACATE</th>
            <th>HS STAND</th>
            <th>CONFORMIDAD RE</th>
            <th>MOT NO CONFORM RE</th>

        </tr>
        </thead>

    </table>
    </section>

<script>
    $(document).ready(function() {
        // ************************************************************************************
        $("#form-buscarRemitos").submit(function(e) {
            var datos = {
                'remito_planillaId': document.getElementById("remito_planillaId").value
            };

            $('#seccion-busqueda').hide();
            $('#seccion-tabla').show();

            /**======================= DATATABLE ===========================*/
            console.log(claves);

            var prueba = {'data':'remito_conformidad'};

            var table = $('#example').DataTable({
                "processing": true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend:'excelHtml5',
                        text: 'EXPORTAR TODO'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'EXPORTAR SELECCIONADOS',
                        exportOptions: {
                            modifier: {
                                selected: true
                            }
                        }
                    }
                ],
                select: {
                    style: 'multi'
                },
                'paging':   true,
                'ordering': true,
                'info':     true,
                stateSave: false,
                fixedHeader: true,
                scrollY:        '80vh',
                scrollX:        'true',
                scrollCollapse: true,
                "columns": claves,

                ajax:{
                    'url':'buscarRemitosPorPlanillaIdAjax',
                    'type':'POST',
                    'data': datos,
                    dataType: 'json'
                },
                colReorder: {

                    order: posiciones
                },
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            /** =========================== FIN: DATATABLE =================================*/
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });




    } );
</script>