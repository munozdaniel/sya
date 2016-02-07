<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><strong>CREAR NUEVA PLANILLA</strong></h3>
    </div>
    <!-- /.Titulo -->
    <!-- Formulario -->

    {{ content() }}
    <table width="100%">
        <tr>
            <td align="right">
                {{ link_to("planilla/index", "<i class='fa fa-search'></i> Busqueda Personalizada",'class':'btn btn-flat btn-large bg-olive') }}
            </td>

        </tr>
    </table>
    <!-- Cuerpo -->
    <div class="box-body">
        <div class="col-xs-12 col-md-6">
            {{ form("planilla/crear","id":"form_planilla", "method":"post") }}
            {{ hidden_field('planilla_id','value':'') }}
            <fieldset id="planilla" class="panel-border">
                <legend>Generar Planilla</legend>

                <div id="grupo_planilla" class="form-group">
                    <label for="planilla_nombreCliente">Nombre de la Planilla</label>
                    {{ text_field("planilla_nombreCliente", "size" : 60,'class':'form-control', 'placeholder':'INGRESAR NOMBRE','':'') }}
                </div>
                <button id="btn_guardar_planilla" type="submit" class="btn btn-flat large btn-primary"><i
                            class="fa fa-save"></i> Guardar Planilla
                </button>
                <input id="btn_editar_planilla" type="button" disabled class="btn btn-flat large btn-google pull-right"
                       onclick='editarPlanilla()' value='Editar planilla'/>

            </fieldset>
            </form>
        </div>
        <script>
            /**
             * Realiza una llamada ajax para guardar los datos, si todo sale ok, permite habilitar los botones para
             * continuar con el siguiente paso.
             */
            $(document).ready(function () {

                // PROCESANDO el formulario
                $('#form_planilla').submit(function (event) {
                    $('.help-block').remove(); // remove the error text

                    //PREPARANDO los datos para enviar
                    var datos = {
                        'planilla_nombreCliente': $('#planilla_nombreCliente').val()
                    };

                    $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url: '/sya/planilla/crear', // the url where we want to POST
                        data: datos, // our data object
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                        // using the done promise callback
                            .done(function (data) {

                                // log data to the console so we can see
                                console.log(data);
                                if (!data.success) {
                                    if (data.errors.planilla_nombreCliente) {
                                        $('#grupo_planilla').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + data.errors.planilla_nombreCliente + '</div>'); // add the actual error message under our input
                                    }
                                } else {
                                    // here we will handle errors and validation messages
                                    $('#btn_guardar_planilla').prop('disabled', true);
                                    $('#extra').prop('disabled', false);
                                    $('#btn_editar_planilla').prop('disabled', false);
                                    document.getElementById('planilla_id').value = data.planilla_id;
                                   // alert("ID: " + data.planilla_id);
                                    $('#grupo_planilla').append('<div class="help-block  alert-success">&nbsp; Operación Exitosa</div>');
                                }
                            })
                        // using the fail promise callback
                            .fail(function (data) {

                                // show any errors
                                // best to remove for production
                                console.log(data);
                            });

                    // stop the form from submitting the normal way and refreshing the page
                    event.preventDefault();
                });

            });//Fin: ready
            /**
             * Una vez guardado los datos, es posible editarlos.
             */
            function editarPlanilla() {
                $('.help-block').remove(); // remove the error text

                //PREPARANDO los datos para enviar
                var datos = {
                    'planilla_nombreCliente': $('#planilla_nombreCliente').val(),
                    'planilla_id': $('#planilla_id').val()
                };

                $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: '/sya/planilla/editar', // the url where we want to POST
                    data: datos, // our data object
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true
                })
                    // using the done promise callback
                        .done(function (data) {

                            // log data to the console so we can see
                            console.log(data);
                            if (!data.success) {
                                if (data.errors.planilla_nombreCliente) {
                                    $('#grupo_planilla').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + data.errors.planilla_nombreCliente + '</div>'); // add the actual error message under our input
                                }
                            } else {
                                $('#grupo_planilla').append('<div class="help-block  alert-success">&nbsp; Operación Exitosa</div>');
                            }
                        })
                    // using the fail promise callback
                        .fail(function (data) {
                            // show any errors
                            // best to remove for production
                            console.log(data);
                        });

                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            }

        </script>

        <!-- ================================================================================= -->
        <div class="col-xs-12 col-md-6">
            <div class="box-body" style="margin-top: 25px !important;">
                <dl class="dl-horizontal">
                    <dt>DESCRIPCIÓN</dt>
                    <dd></dd>
                    <dt>Paso 1:</dt>
                    <dd style="text-align: left !important;">Asignar un nombre a la planilla.</dd>
                    <dt>Paso 2:</dt>
                    <dd style="text-align: left !important;">Agregar todas las columnas requeridas.</dd>
                    <dt>Paso 3:</dt>
                    <dd style="text-align: left !important;"> Reordenar las columnas para las planillas Excel.</dd>
                </dl>
            </div>
        </div>
        <!-- ================================================================================= -->
        <div class="col-xs-12 col-md-12">
            <hr>
        </div>
        <!-- ================================================================================= -->
        <div class="col-xs-12 col-md-12">
            {{ form("cabecera/crear","id":"form_columnas", "method":"post") }}
            <fieldset id="extra" class="panel-border">
                <legend>Generar Columnas Extras</legend>
                <div id="grupo_extra" class="form-group col-md-6">
                    <div id="contenedor">
                        <div class="added">
                            <!-- Aca van a ir los inputs dinamicos-->
                            <em>Ingresar las columnas extras correspondientes a la nueva planilla</em>
                        </div>
                        <input type="hidden" id="token" name="<?php echo $this->security->getTokenKey() ?>"
                               value="<?php echo $this->security->getToken() ?>"/>
                    </div>
                </div>
                <div class="col-md-6" style="margin-top: 25px !important;">
                    <a id="agregarCampo" class="btn btn-danger btn-flat" href="#"><i class="fa fa-plus"></i> Agregar Columna Extra</a>
                </div>
                <div class="col-md-12">
                    <button id="btn_guardar_columnas" type="submit" class="btn btn-flat large btn-primary">
                        <i class="fa fa-save"></i> Guardar Columnas
                    </button>
                </div>

            </fieldset>
            </form>
        </div>
        <script>
            /**
             * Permite agregar inputs infinitamente
             */
            $(document).ready(function () {

                var MaxInputs = 8; //Número Maximo de Campos
                var contenedor = $("#contenedor"); //ID del contenedor
                var AddButton = $("#agregarCampo"); //ID del Botón Agregar

                //var x = número de campos existentes en el contenedor
                var x = $("#contenedor div").length + 1;
                var FieldCount = x - 1; //para el seguimiento de los campos

                $(AddButton).click(function (e) {
                    if (x <= MaxInputs) //max input box allowed
                    {
                        //agregar campo
                        $(contenedor).append('<div><input type="text" required name="columna[]"  class="form-control columna" id="extra_' + FieldCount + '" placeholder="Ingrese la columna Extra ' + FieldCount + '"/><a href="#" class="eliminar">[&times;] Eliminar</a></div>');
                        FieldCount++;
                        x++; //text box increment
                    }
                    return false;
                });

                $("body").on("click", ".eliminar", function (e) { //click en eliminar campo
                    if (x > 1) {
                        $(this).parent('div').remove(); //eliminar el campo
                        x--;
                    }
                    return false;
                });
            });
            /**
             * Realiza una llamada ajax para guardar los datos, si todo sale ok, permite habilitar los botones para
             * continuar con el siguiente paso.
             * RECORDAR DARLE PERMISOS ACL
             */

                // PROCESANDO el formulario
            $('#form_columnas').submit(function (event) {
                $('.help-block').remove(); // remove the error text

                var arregloColumnas = document.getElementsByName('columna[]');
                //Convirtiendo el arreglo de inputs a un arreglo de valores de los inputs
                var columnas = [];
                for (var i = 0; i < arregloColumnas.length; i++) {
                    columnas.push(arregloColumnas[i].value);
                }
                //PREPARANDO los datos para enviar
                var datos = {
                    'columna': columnas,
                    'token': $('#token').val()

                };
                $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: '/sya/cabecera/crear', // the url where we want to POST
                    data: datos, // our data object
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true
                })
                    // using the done promise callback
                        .done(function (data) {

                            // log data to the console so we can see
                            console.log(data);
                            if (!data.success) {
                                if (data.mensaje) {
                                    $('#grupo_extra').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + data.mensaje + '</div>'); // add the actual error message under our input
                                }
                            } else {
                                $('#grupo_extra').append('<div class="help-block  alert-success">&nbsp;  ' + data.mensaje + '</div>'); // add the actual error message under our input
                                var arregloColumnas = document.getElementsByName('columna[]');
                                //Vaciando los inputs
                                var columnas = [];
                                for (var i = 0; i < arregloColumnas.length; i++) {
                                    arregloColumnas[i].value='';
                                }
                            }
                        })
                    // using the fail promise callback
                        .fail(function (data) {

                            // show any errors
                            // best to remove for production
                            console.log("FAIL");
                            console.log(data);
                        });

                // stop the form from submitting the normal way and refreshing the page
                event.preventDefault();
            });

        </script>
        <!-- ================================================================================= -->
        <div class="col-xs-12 col-md-12">

            <fieldset id="ordenar" class="panel-border" >
                <legend>Ordenar Columnas</legend>
                <div class="input-group margin col-md-5">
                    <select id="cabecera-list" class="form-control" onchange="cargarTabla()">
                        <option value="">Seleccionar cabecera predefinida</option>
                    </select>

                    <span class="input-group-btn">
                      <a id="btn_cargar_columnas" class="btn btn-info btn-flat" ><i class="fa fa-refresh"></i></a>
                    </span>
                    <input type="hidden" id="token_ordenar" name="<?php echo $this->security->getTokenKey() ?>"
                           value="<?php echo $this->security->getToken() ?>"/>
                </div>

                <script type="text/javascript">
                    // When the document is ready set up our sortable with it's inherant function(s)
                    $(document).ready(function() {
                        $("#listarColumnas").sortable({
                            handle : '.handle',
                            update : function () {
                                var order = $('#listarColumnas').sortable('serialize');
                                $("#info").load("ordenar?"+order);
                            }
                        });
                    });
                </script>
                <pre>
                    <div id="info"><em>El orden asignado se guardará para generar las planillas Excel</em></div>
                </pre>
                <ul id="listarColumnas">
                    <li id="listItem_1"><img src="arrow.png" alt="move" width="16" height="16" class="handle" /><strong>Item 1 </strong>with a link to <a href="http://www.google.co.uk/" rel="nofollow">Google</a></li>
                    <li id="listItem_2"><img src="arrow.png" alt="move" width="16" height="16" class="handle" /><strong>Item 2</strong></li>
                    <li id="listItem_3"><img src="arrow.png" alt="move" width="16" height="16" class="handle" /><strong>Item 3</strong></li>
                    <li id="listItem_4"><img src="arrow.png" alt="move" width="16" height="16" class="handle" /><strong>Item 4</strong></li>
                </ul>

            </fieldset>
        </div>

    </div>

    <!-- /.box-body -->

</div>

<!-- ====================================== -->
<script>
    var cargar = $("#btn_cargar_columnas"); //ID del Botón Agregar

    $(cargar).click(function (e) {
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/cabecera/cargarCabecera', // the url where we want to POST
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        .done(function (data) {
            if(data.success){
                var select=document.getElementById("cabecera-list");
                for(var item in data.mensaje)
                {
                    var columna = data.mensaje[item];
                    // log data to the console so we can see
                    opt = document.createElement("option");
                    opt.value =  columna.valor;
                    opt.text= columna.nombre;
                    select.appendChild(opt);
                }
            }
            //FIXME: Que pasa si  no encuentra cabeceras ???
            console.log(data);
        })
        .fail(function (data) {
            // show any errors
            // best to remove for production
            console.log("FAIL");
            console.log(data);
        });
        event.preventDefault();
    });
    function cargarTabla(){
        var select = document.getElementById("cabecera-list");
        var datos = {
            'cabecera_id': select.value

        };
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/cabecera/buscarColumnas', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
            // using the done promise callback
                .done(function (data) {
                    console.log(data);
                })
            // using the fail promise callback
                .fail(function (data) {
                    // show any errors
                    // best to remove for production
                    console.log("FAIL");
                    console.log(data);
                });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    }
    function habilitarOrdenarColumnas() {
        $('#extra').prop('disabled', true);
        $('#ordenar').prop('disabled', false);
    }
    function habilitarGuardar() {
        $('#ordenar').prop('disabled', true);
        $('#guardar').prop('disabled', false);
    }

</script>
<!-- ====================================== -->
