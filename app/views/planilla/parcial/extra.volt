<div id="pnl_extra">
    {{ form("cabecera/crear","id":"form_columnas", "method":"post") }}
        <fieldset id="extra" class="panel-border" disabled>
            <legend>Agregar Columnas Extras <small>(opcional)</small></legend>
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
                <a id="agregarCampo" class="btn btn-danger btn-flat" href="#"><i class="fa fa-plus"></i> Agregar
                    Columna Extra</a>
            </div>
            <div class="col-md-12">
                <button id="btn_guardar_columnas" type="submit" class="btn btn-flat large btn-primary">
                    <i class="fa fa-save"></i> Guardar Columnas
                </button>
            </div>

        </fieldset>
    {{ end_form() }}
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
            'token': $('#token').val(),
            'cabecera_id': $('#id_cabecera_input').val()
        };
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/cabecera/agregarExtra', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
            // using the done promise callback
                .done(function (data) {

                    // log data to the console so we can see
                    console.log(data);
                    if (!data.success) {
                        for (var item in data.mensaje) {
                            var elemento = data.mensaje[item];
                            $('#grupo_extra').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + elemento + ' <br> Por favor, cree una nueva cabecera.</div>'); // add the actual error message under our input
                        }
                    } else {
                        $('#grupo_extra').append('<div class="help-block  alert-success">&nbsp;  OPERACION EXITOSA</div>'); // add the actual error message under our input
                        var arregloColumnas = document.getElementsByName('columna[]');
                        //Vaciando los inputs
                        var columnas = [];
                        for (var i = 0; i < arregloColumnas.length; i++) {
                            arregloColumnas[i].value = '';
                        }
                        cargarTablaReordenable(data.columnas);//Las columnas que entran como parametro
                        console.log(data.columnas);
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