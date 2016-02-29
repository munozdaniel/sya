<div class="box box-primary">
    <div class="box-header">
        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/searchDataTable", "<i class='fa fa-search'></i> Busqueda de Remitos",'class':'btn btn-flat btn-large bg-olive') }}
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
    <a href="#" class="btn btn-soundcloud pull-left " onClick ="$('#example').tableExport({type:'excel',escape:'false'});">EXPORTAR PAGINA</a><br>


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

    </table>
    </section>

<script>
    $(document).ready(function() {
        // this is the id of the form
        $("#form-buscarRemitos").submit(function(e) {
            $('#seccion-busqueda').hide();
            $('#seccion-tabla').show();
            var Data = $("#form-buscarRemitos").serializeArray();


            /**======================= DATATABLE ===========================*/
            var posiciones = [];
            {% for col in columnas %}
            posiciones.push({{ col['columna_posicion']}}) ;
            {% endfor %}
            console.log( $( this ).serialize());
            var table = $('#example').DataTable({
                "processing": true,
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5'
                ],
                'paging':   true,
                'ordering': true,
                'info':     true,
                stateSave: false,
                fixedHeader: true,
                scrollY:        '80vh',
                scrollX:        'true',
                scrollCollapse: true,
                "columns": [
                    { "data": "remito_id" },
                    { "data": "remito_nro" },
                    { "data": "remito_nroOrden" },
                    { "data": "remito_tipo" },
                    { "data": "remito_planillaId" },
                    { "data": "remito_id" },
                    { "data": "remito_nro" },
                    { "data": "remito_nroOrden" },
                    { "data": "remito_tipo" },
                    { "data": "remito_planillaId" },
                    { "data": "remito_id" },
                    { "data": "remito_nro" },
                    { "data": "remito_nroOrden" },
                    { "data": "remito_tipo" },
                    { "data": "remito_planillaId" },
                    { "data": "remito_planillaId" },
                    { "data": "remito_planillaId" },
                    { "data": "remito_planillaId" },
                    { "data": "remito_conformidad" }
                ],
                colReorder: {

                    order: [2,9,0 , 1 ,10,11, 3, 4, 5,6,7,8,12,13,14,15,16,17,18 ]
                },
                ajax:{
                    'url':'busquedaAjax',
                    'type':'POST',
                    'data': Data,
                    dataType: 'json'
                },
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var $nRow = $(nRow);
                    if ( aData['remito_planillaId'] == 27 )
                    {console.log("es uno");
                        $nRow.css({"background-color":"rgba(221, 75, 57, 0.6)"});
                    }else{
                        console.log(aData['remito_planillaId']);
                    }
                }
            });

            /** =========================== FIN: DATATABLE =================================*/
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });




    } );
</script>