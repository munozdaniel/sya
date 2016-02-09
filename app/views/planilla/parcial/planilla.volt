<div class="col-xs-12 col-md-6">
    {{ form("planilla/crear","id":"form_planilla", "method":"post") }}
        {{ hidden_field('planilla_id','value':'','form':'finalizar') }}
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
                            $('#btn_guardar_planilla').prop('disabled', true);//Dehsabilitar boton guardar planilla
                            $('#extra').prop('disabled', false);//Habilitar paso 2
                            $('#ordenar').prop('disabled', false);//Habilitar paso 3
                            $('#btn_editar_planilla').prop('disabled', false);//Habilitar boton editar planilla
                            document.getElementById('planilla_id').value = data.planilla_id;
                            $('#grupo_planilla').append('<div class="help-block  alert-success">&nbsp; Operación Exitosa</div>');
                            //Recargar combo con cabeceras
                            llenarComboBoxCabecera(data.cabeceras);
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