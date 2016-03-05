<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Buscar Remitos <br></h3>

        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("index/dashboard", "<i class='fa fa-home'></i> Pagina Principal",'class':'btn btn-flat  bg-olive') }}
                </td>
                <td align="right">
                    {{ link_to("remito/buscarRemitoPorPlanilla", "<i class='fa fa-search'></i> Realizar nueva búsqueda",'class':'btn btn-flat btn-google') }}
                </td>

            </tr>
        </table>
    </div>
</div>
{#=============================================================================================================#}
<section id="seccion-busqueda">


    <!-- /.Titulo -->
    <!-- Formulario -->
    {{ content() }}
    {# =================================== PLANILLA ================================== #}
    {#Campos Ocultos#}
    {#Fin Campos Ocultos#}
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Seleccionar Planilla <br>
                <small> Obtener todos los remitos de una planilla</small>
            </h3>

        </div>
        <fieldset id="fielset-buscar-planilla" class="panel-border">
            <br>
            <br>
            <div class="container" align="center">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        {{ formulario.render() }}

                    </div>
                    <div class="col-md-2">
                    <span class="input-group-btn"><br>
                        <a id="confirmarPlanilla"
                           class="btn btn-flat btn-info pull-left"><i class="fa fa-2x fa-check-circle-o"></i>.
                        </a>
                    </span>
                    </div>
                </div>
                <hr>
            </div>
        </fieldset>
    </div>
    {{ form('id':'form-buscarRemitos' ,"method":"post") }}
    {{ submit_button(" BUSCAR REMITOS",'id':'submit','class':'btn btn-lg btn-flat btn-primary', 'disabled':'') }}

    {{ end_form() }}

</section>

{#=============================================================================================================#}
<!-- /.box-header -->
{{ content() }}
<section id="seccion-tabla" class="box box-body ocultar">
    <div id="mensajes"></div>

    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr id="tr-cabecera">
            {# Se agregan al seleccionar la planilla #}
        </tr>
        </thead>

    </table>

</section>

<script>
        var posiciones = null, claves = null;
        /**************** select autocomplete *******************/
        $(function () {
            $(".autocompletar").select2();
        });
        /**************** obtener un arreglo con todas las posiciones de las columans ordenadas *******************/
        $( "#confirmarPlanilla" ).click(function()
        {
            $('#mensajes').empty();
            $('#tr-cabecera').empty();
            var datos = {
            'planilla_id': document.getElementById("remito_planillaId").value
             };
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '/sya/columna/obtenerColumnas',
                data: datos, // our data object
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
                    .done(function (data) {
                        console.log(data);
                        if (!data.success)
                        {
                            $('#mensajes').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> Hubo un problema, la planilla no tiene las columnas definidas.</div>'); // add the actual error message under our input
                        }else{
                            $('#mensajes').append('<div class="help-block ">&nbsp; Por favor espere unos minutos para la carga de datos.</div>'); // add the actual error message under our input
                            posiciones = data.columnas;
                            claves = data.claves;//Recupera las claves que van armar las columnas.
                            //Creamos la cabecera de la tabla.
                            var tr = document.getElementById("tr-cabecera");
                            for(var item in data.claves)
                            {
                                var col = data.claves[item]['data'];
                                var th = document.createElement("th");
                                th.appendChild(document.createTextNode(col));
                                tr.appendChild(th);
                            }
                            $('#submit').prop('disabled', false);

                        }

                    })
                    .fail(function (data) {
                        console.log("recuperarColumnas");
                        console.log(data);
                    });

        });
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
                },
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var $nRow = $(nRow);
                    if ( aData['remito_pdf'] == "" ||  aData['remito_pdf'] == null )
                    {
                        $nRow.css({"color":"red"});
                    }
                }
            });

            /** =========================== FIN: DATATABLE =================================*/
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });





</script>