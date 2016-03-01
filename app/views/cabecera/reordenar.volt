<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><strong>REORDENAR COLUMNAS</strong></h3>
    </div>
    <!-- /.Titulo -->
    <!-- Formulario -->

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("index/dashboard", "<i class='fa fa-home'></i> Tablero Principal",'class':'btn btn-flat btn-large bg-olive') }}
            </td>
            <td align="right">
                {{ link_to("cabecera/reordenar", "<i class='fa fa-home'></i> Reordenar otra planilla",'class':'btn btn-flat btn-large btn-google') }}
            </td>
        </tr>
    </table>
    <div class="box-body">
        <div class="col-md-12">
            {{ content() }}
            <div id="cabecera_mje"></div>
        </div>
        <fieldset id="fielset-buscar-planilla" class="panel-border">
            <legend>Seleccionar Planilla</legend>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        {{ formulario.label('planilla_nombreCliente') }}
                        <div class="input-group">
                            {{ formulario.render('planilla_nombreCliente') }}
                            <span class="input-group-btn">
                                <a onclick="generarColumnas()" class="btn btn-primary btn-flat">BUSCAR COLUMNAS</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        {#===============================================================#}
        <fieldset id="fielset-mostrar-columnas" class="panel-border ocultar">
            <legend>Ordenar Columnas</legend>
            <div class="container">
                <div class="row row-centered">
                    <div class="col-md-6 col-centered col-fixed">
                        <div class="contenedor-lista">
                            <ol id="ul_columnas">
                                <!--li id="listItem_1">
                                    <a class="handle">
                                        <strong>Item 1 </strong>
                                    </a>
                                </li-->
                            </ol>
                        </div>
                        <pre>
                            <div id="info"><em>El orden asignado se guardará para generar las planillas Excel</em></div>
                        </pre>
                    </div>
                </div>
            </div>
        </fieldset>
        <script type="text/javascript">
            // Guarda el nuevo orden de las columnas
            $(document).ready(function () {
                $("#ul_columnas").sortable({
                    handle: '.handle',
                    update: function () {
                        var order = $('#ul_columnas').sortable('serialize');
                        //console.log(order);
                        $("#info").load("ordenar?" + order);//llama a cabecera/ordenarAction
                    }
                });
            });
            /*=====================================================================================================*/
            /*=====================================================================================================*/

            /**
             * Verifica que radio button esta seleccionado:
             * Nueva cabecera: Se cargan nuevas columnas basicas a la bd.
             * Utilizar Cabecera Existente: Selecciona una cabecera ya creada.
             */
            function generarColumnas() {
                $('.help-block').remove(); // remove the error text
                var datos = {
                    'planilla_id': $('#planilla_id').val()
                };
                $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: '/sya/cabecera/buscarColumnasPorPlanilla', // the url where we want to POST
                    data: datos, // our data object
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true
                })
                        .done(function (data) {
                            console.log(data);
                            if (!data.success) {
                                for (var item in data.mensaje) {
                                    var elemento = data.mensaje[item];
                                    $('#cabecera_mje').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + elemento + '</div>');
                                }
                            } else {
                                $('#cabecera_mje').append('<div class="help-block  alert-success">&nbsp; LA CABECERA FUE CREADA CON EXITO. <br> &nbsp; Si desea puede reordenar las columnas</div>'); // add the actual error message under our input
                                cargarTablaReordenable(data.columnas);
                                $("#fielset-buscar-planilla").hide(1000);
                                $("#fielset-mostrar-columnas").show(1500);
                            }
                        })
                        .fail(function (data) {
                            // show any errors
                            // best to remove for production
                            console.log("FAIL");
                            console.log(data);
                        });
            }
            /*=====================================================================================================*/
            /*=====================================================================================================*/

            /**
             * Muestra una lista con todas las columnas. Permite que sean reordenables.
             */
            function cargarTablaReordenable(columnas) {

                $('#ul_columnas').empty();

                var ul = document.getElementById("ul_columnas");
                var i = 0;
                for (var item in columnas) {
                    var elemento = columnas[item];
                    var li = document.createElement("li");
                    li.setAttribute('value', elemento['columna_id']);
                    li.setAttribute("id", 'listItem_' + elemento['columna_id']);
                    var a = document.createElement("a");
                    a.setAttribute("class", 'handle');
                    a.appendChild(document.createTextNode(elemento['columna_nombre']));
                    li.appendChild(a);
                    ul.appendChild(li);
                    i++;

                }
            }
        </script>

    </div>
</div>