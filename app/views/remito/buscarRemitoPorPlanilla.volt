
<div class="box box-primary">
    <div class="box-header">
        <div class="col-md-12">
        <h3 class="box-title">BUSCAR REMITOS POR PLANILLA <br></h3>

        </div>


        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/buscarRemitoPorPlanilla", "<i class='fa fa-search'></i> Seleccionar otra planilla",'class':'btn btn-flat btn-google') }}
                </td>
            </tr>
        </table>
        <div class="col-md-6 col-md-offset-3">
            {{ text_field('planilla_nombreCliente','value':'','readOnly':'true','class':'form-control','style':'text-align:center;') }}
        </div>
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
                    <div class="col-md-4">
                    <span class="input-group-btn">
                        {{ form('id':'form-buscarRemitos' ,"method":"post") }}
                        {{ submit_button(" INICIAR BÚSQUEDA",'id':'submit','class':'btn btn-flat btn-primary pull-left','style':'display:none;') }}
                        {{ end_form() }}
                        <a id="confirmarPlanilla"
                           class="btn btn-flat btn-primary pull-left" title="CARGAR CABECERA"><i
                                    class="fa fa-2x fa-refresh  fa-spin"></i>
                        </a>

                    </span>
                    </div>
                </div>
                <hr>
            </div>
        </fieldset>
    </div>


</section>

{#=============================================================================================================#}
<!-- /.box-header -->
{{ content() }}
<section id="seccion-tabla" class="box box-body ocultar">

    <div class="col-md-12">

    <a class="btn btn-flat btn-twitter" onclick="habilitarBusqueda()"> BÚSQUEDA PERSONALIZADA</a>

    <div id="mensajes"></div>

        <div id="body-buscador" class="row ocultar" >

        </div>

    <hr>
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr id="tr-cabecera">
            {# Se agregan al seleccionar la planilla #}

        </tr>
        </thead>

    </table>
    </div>
</section>

<script>
    function habilitarBusqueda()
    {
        $('#body-buscador').toggle(2000);
    }
    function filterGlobal() {
        $('#example').DataTable().search(
                $('#global_filter').val(),
                $('#global_smart').prop('checked')
        ).draw();
    }

    function filterColumn(i) {
        $('#example').DataTable().column(i).search(
                $('#col' + i + '_filter').val(),
                $('#col' + i + '_smart').prop('checked')
        ).draw();
    }
    var posiciones = null, claves = null;
    /**************** select autocomplete *******************/
    $(function () {
        $(".autocompletar").select2();
    });
    /**************** obtener un arreglo con todas las posiciones de las columans ordenadas *******************/
    $("#confirmarPlanilla").click(function () {

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
                    if (!data.success) {
                        $('#mensajes').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> Hubo un problema, la planilla no tiene las columnas definidas.</div>'); // add the actual error message under our input
                    } else {
                        $('#mensajes').append('<div id="load" class="help-block  alert-info">&nbsp; CARGANDO DATOS, POR FAVOR ESPERE UNOS MINUTOS </div>'); // add the actual error message under our input
                        document.getElementById("planilla_nombreCliente").value=data.planilla_nombreCliente;

                        posiciones = data.columnas;
                        claves = data.claves;//Recupera las claves que van armar las columnas.
                        //Creamos la cabecera de la tabla.
                        var tr = document.getElementById("tr-cabecera");
                        //Creamos el buscador global.
                        var body = document.getElementById("body-buscador");
                        var i = 0;

                        for (var item in data.claves) {
                            var col = data.claves[item]['data'];
                            var th = document.createElement("th");
                            th.appendChild(document.createTextNode(col));
                            tr.appendChild(th);

                            //Creando el buscador


                            var div_b = document.createElement("div");
                            div_b.setAttribute('id', 'filter_col' + (i + 1));
                            div_b.setAttribute('data-column', i);
                            div_b.setAttribute('class', 'col-md-3');
                            var label_b = document.createElement("label");
                            label_b.appendChild(document.createTextNode(col));
                            label_b.setAttribute('style','display:block;')
                            div_b.appendChild(label_b);

                            var input_b = document.createElement("INPUT");
                            input_b.setAttribute('type', 'text');
                            input_b.setAttribute('class', 'column_filter');
                            input_b.setAttribute('id', "col" + i + "_filter");
                            div_b.appendChild(input_b);
                            var check_b = document.createElement("INPUT");
                            check_b.setAttribute("type", 'checkbox');
                            check_b.setAttribute("id", 'col' + i);
                            check_b.setAttribute("checked", 'checked');
                            check_b.setAttribute("class", 'column_filter');
                            check_b.setAttribute("style", 'display:none;');
                            div_b.appendChild(check_b);

                            body.appendChild(div_b);
                            i = i + 1;
                        }
                        $('#submit').prop('disabled', false);
                        $('#submit').show(1000);
                        $('#confirmarPlanilla').hide(1000);

                    }

                })
                .fail(function (data) {
                    console.log("recuperarColumnas");
                    console.log(data);
                });

    });
    // ************************************************************************************
    $("#form-buscarRemitos").submit(function (e) {
        var datos = {
            'remito_planillaId': document.getElementById("remito_planillaId").value
        };

        $('#seccion-busqueda').hide();
        $('#seccion-tabla').show();

        /**======================= DATATABLE ===========================*/
        console.log(claves);

        var prueba = {'data': 'remito_conformidad'};

        var table = $('#example').DataTable({
            "processing": true,
            dom: 'Bfrtip',
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {
                    text: 'Recargar',
                    action: function ( e, dt, node, config ) {
                        table.ajax.reload();
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Exportar Todo',
                    filename: document.getElementById("planilla_nombreCliente").value,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: document.getElementById("planilla_nombreCliente").value,
                    text: 'Exportar Seleccionados',
                    exportOptions: {
                        modifier: {
                            selected: true
                        },
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text:"Columnas",
                    collectionLayout: 'fixed four-column'
                }
            ],
            select: {
                style: 'multi'
            },
            'paging': true,
            'ordering': true,
            'info': true,
            stateSave: false,
            fixedHeader: true,
            scrollY: '80vh',
            scrollX: false,
            scrollCollapse: true,
            "columns": claves,
            ajax: {
                'url': 'buscarRemitosPorPlanillaIdAjax',
                'type': 'POST',
                'data': datos,
                dataType: 'json'
            },
            colReorder: {
                order: posiciones
            },
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Búsqueda General:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
        //Busqueda personaliza
        $('input.global_filter').on('keyup click', function () {
            filterGlobal();
        });

        $('input.column_filter').on('keyup click', function () {
            filterColumn($(this).parents('div').attr('data-column'));
        });
        //Evento al finalizar la carga de la tabla
        $('#example').on( 'draw.dt', function () {
           $("#load").hide();
        } );
        function recargar() {
            table.ajax.reload();
        }

        /** =========================== FIN: DATATABLE =================================*/
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });


</script>
{{ partial('remito/parcial/guardarPdfEscaneado') }}
