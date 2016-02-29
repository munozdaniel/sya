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
                    {{ link_to("remito/generarExcel/json=", "<i class='fa fa-file'></i> Generar Excel",'class':'btn btn-flat btn-gris') }}
                </td>
            </tr>
        </table>
    </div>
</div>
{#=============================================================================================================#}
<form id="myform" method="post">


<div align="center">
    <h1>Search remito</h1>
</div>
            <label for="remito_id">Remito</label>
            {{ text_field("remito_id", "type" : "numeric") }}
            <label for="remito_nro">Remito Of Nro</label>
            {{ text_field("remito_nro", "type" : "numeric") }}
            <label for="remito_planillaId">Remito Of PlanillaId</label>
            {{ text_field("remito_planillaId", "type" : "numeric") }}
        <div class="submit">
            <input type="submit" id="btn" name="btn" class="btn" value="Submit" />
        </div>


</form>

{#=============================================================================================================#}
<!-- /.box-header -->
{{ content() }}
<div class="box box-body">
    <a href="#" class="btn btn-soundcloud pull-left " onClick ="$('#example').tableExport({type:'excel',escape:'false'});">EXPORTAR PAGINA</a><br>
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

    </table>
    </div>

<script>
    $(document).ready(function() {
        // this is the id of the form
        $("#myform").submit(function(e) {

            var Data = $("#myform").serializeArray();


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