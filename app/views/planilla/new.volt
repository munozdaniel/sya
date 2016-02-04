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
                <button id="btn_guardar_planilla" type="submit" class="btn btn-flat large btn-primary"> <i class="fa fa-save"></i> Guardar Planilla</button>
                <input id="btn_editar_planilla" type="button"  disabled class="btn btn-flat large btn-google pull-right"
                   onclick='editarPlanilla()' value='Editar planilla'/>

            </fieldset>
            </form>
        </div>
        <script>
            /**
             * Realiza una llamada ajax para guardar los datos, si todo sale ok, permite habilitar los botones para
             * continuar con el siguiente paso.
             */
            $(document).ready(function() {

                // PROCESANDO el formulario
                $('#form_planilla').submit(function(event) {
                    $('.help-block').remove(); // remove the error text

                    //PREPARANDO los datos para enviar
                    var datos = {
                        'planilla_nombreCliente'    : $('#planilla_nombreCliente').val()
                    };

                    $.ajax({
                        type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url         : '/sya/planilla/crear', // the url where we want to POST
                        data        : datos, // our data object
                        dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
                    })
                        // using the done promise callback
                            .done(function(data) {

                                // log data to the console so we can see
                                console.log(data);
                                if ( ! data.success) {
                                    if (data.errors.planilla_nombreCliente) {
                                        $('#grupo_planilla').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + data.errors.planilla_nombreCliente + '</div>'); // add the actual error message under our input
                                    }
                                }else{
                                    // here we will handle errors and validation messages
                                    $('#btn_guardar_planilla').prop('disabled', true);
                                    $('#extra').prop('disabled', false);
                                    $('#btn_editar_planilla').prop('disabled', false);
                                    document.getElementById('planilla_id').value=data.planilla_id;
                                    alert("ID: "+data.planilla_id);
                                    $('#grupo_planilla').append('<div class="help-block  alert-success">&nbsp; Operación Exitosa</div>');
                                }
                            })
                            // using the fail promise callback
                            .fail(function(data) {

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
            function editarPlanilla(){
                    $('.help-block').remove(); // remove the error text

                    //PREPARANDO los datos para enviar
                    var datos = {
                        'planilla_nombreCliente'    : $('#planilla_nombreCliente').val(),
                        'planilla_id'    : $('#planilla_id').val()
                    };

                    $.ajax({
                        type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url         : '/sya/planilla/editar', // the url where we want to POST
                        data        : datos, // our data object
                        dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
                    })
                        // using the done promise callback
                            .done(function(data) {

                                // log data to the console so we can see
                                console.log(data);
                                if ( ! data.success) {
                                    if (data.errors.planilla_nombreCliente) {
                                        $('#grupo_planilla').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + data.errors.planilla_nombreCliente + '</div>'); // add the actual error message under our input
                                    }
                                }else{
                                    $('#grupo_planilla').append('<div class="help-block  alert-success">&nbsp; Operación Exitosa</div>');
                                }
                            })
                        // using the fail promise callback
                            .fail(function(data) {
                                // show any errors
                                // best to remove for production
                                console.log(data);
                            });

                    // stop the form from submitting the normal way and refreshing the page
                    event.preventDefault();
            }
            function guardarYGenerarExtra() {

                $('#planilla').prop('disabled', true);
                $('#extra').prop('disabled', false);

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
        <div class="col-xs-12 col-md-12">
            <hr>
        </div>
        <div class="col-xs-12 col-md-12">
            <fieldset id="extra" class="panel-border" disabled>
                <legend>Generar Columnas Extras</legend>
                <div class="form-group">
                    <div class="col-md-4" style="margin-top:40px;">
                        <a id="agregarCampo" class="btn btn-info" href="#">Agregar Campo</a>
                    </div>
                    <div id="contenedor" class="col-md-6">
                        <div class="added">
                            <input type="text" name="columna[]" id="extra_1" placeholder="Columna Extra 1"
                                   class="form-control"/>
                            <a href="#" class="eliminar">[&times;] Eliminar</a>
                        </div>

                    </div>
                </div>

                <a data-toggle="collapse" data-target="#idiomas" class="btn btn-flat large btn-primary"
                   onclick='habilitarOrdenarColumnas()'>
                    <i class="fa fa-save"></i> Guardar Columnas
                </a>
            </fieldset>
        </div>
        <!-- ================================================================================= -->
        <div class="col-xs-12 col-md-12">

            <fieldset id="ordenar" class="panel-border" disabled>
                <legend>Ordenar Columnas</legend>
                <div class="form-group">
                    <div class="col-md-6">
                        <table>
                            <thead>
                            <tr>
                                <th>Film</th>
                                <th>Date</th>
                                <th>Rating</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>The Shawshank Redemption</td>
                                <td>1994</td>
                                <td>9.2</td>
                            </tr>
                            <tr>
                                <td>The Shawshank Redemption</td>
                                <td>1994</td>
                                <td>9.2</td>
                            </tr><tr>
                                <td>The Shawshank Redemption</td>
                                <td>1994</td>
                                <td>9.2</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <thead>
                            <tr>
                                <th>Film</th>
                                <th>Date</th>
                                <th>Rating</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>The Shawshank Redemption</td>
                                <td>1994</td>
                                <td>9.2</td>
                            </tr>
                            <tr>
                                <td>The Shawshank Redemption</td>
                                <td>1994</td>
                                <td>9.2</td>
                            </tr>
                            <tr>
                                <td>The Shawshank Redemption</td>
                                <td>1994</td>
                                <td>9.2</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <a data-toggle="collapse" data-target="#idiomas" class="btn btn-flat large btn-primary"
                   onclick='habilitarGuardar()'>
                    <i class="fa fa-save"></i> Guardar Columnas


                </a>


            </fieldset>
        </div>

    </div>

    <!-- /.box-body -->
    <!-- Footer -->
    <div class="box-footer">

    </div>
</div>

<!-- ====================================== -->
<script>

    function habilitarOrdenarColumnas() {
        $('#extra').prop('disabled', true);
        $('#ordenar').prop('disabled', false);
    }
    function habilitarGuardar() {
        $('#ordenar').prop('disabled', true);
        $('#guardar').prop('disabled', false);
    }
    $('table tbody').sortable({
        helper: fixWidthHelper
    }).disableSelection();

    function fixWidthHelper(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    }
</script>

<script>
    $(function () {
        var sortable = $("#sortable");
        sortable.sortable();
        sortable.disableSelection();
    });
</script>
<script>
    $('#sortable').sortable({
        axis: 'y',
        update: function (event, ui) {
            var data = $(this).sortable('serialize');

            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: 'planilla/ordenar'
            });
        }
    });
</script>

<!-- ====================================== -->
<script>
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
                FieldCount++;
                //agregar campo
                $(contenedor).append('<div><input type="text" name="columna[]" required="" class="form-control" id="extra_' + FieldCount + '" placeholder="Columna Extra ' + FieldCount + '"/><a href="#" class="eliminar">[&times;] Eliminar</a></div>');
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
</script>