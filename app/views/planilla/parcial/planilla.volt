<div class="col-xs-12 col-md-6">
    {{ form("planilla/crear","id":"form_planilla", "method":"post") }}
        {{ hidden_field('planilla_id','value':'','form':'form_guardarCabeceraPredefinida') }}
        <fieldset id="planilla" class="panel-border">
            <legend>Generar Planilla</legend>

            <div id="grupo_planilla" class="form-group">
                <label for="planilla_nombreCliente">Nombre de la Planilla</label>
                {{ text_field("planilla_nombreCliente", "size" : 60,'class':'form-control', 'placeholder':'INGRESAR NOMBRE') }}
            </div>
            <div id="id_paneles" class="col-md-12 ocultar">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input type="radio" name="opciones" id="rbt_nuevaCabecera" value="1" checked="" onchange="cambiarPanel()">
                            Nueva Cabecera
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="opciones" id="rbt_cabeceraExistente" value="0">
                            Utilizar Cabecera existente
                        </label>
                    </div>
                </div>

                <hr>

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
                            $('#btn_editar_planilla').prop('disabled', false);//Habilitar boton editar planilla
                            $('#id_paneles').show();//Habilitar boton editar planilla
                            $('#pnl_seleccionar').prop('disabled', false);//Habilitar div para seleccionar radio buttons
                            document.getElementById('planilla_id').value = data.planilla_id;
                            $('#grupo_planilla').append('<div class="help-block  alert-success">&nbsp; Operación Exitosa</div>');
                            //Recargar combo con cabeceras
                           // llenarComboBoxCabecera(data.cabeceras);
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
    /*Cuando cambian los radio buttons, habilita un panel o el otro.*/
    $('input[type=radio][name=opciones]').change(function() {
        if(this.value == 0){
            $("#id_cabeceraExistente").show();
            $("#id_nuevaCabecera").hide();
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '/sya/cabecera/cargarCabecera', // the url where we want to POST
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
                    .done(function (data) {
                        if (data.success)
                            llenarComboBoxCabecera(data.mensaje);
                        //FIXME: Que pasa si  no encuentra cabeceras ???
                        console.log(data);
                    })
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log("FAIL");
                        console.log(data);
                    });
        }else{
            $("#id_cabeceraExistente").hide();
            $("#id_nuevaCabecera").show();

        }
    });
    function llenarComboBoxCabecera(cabeceras)
    {
        $('#cabecera-list').empty();

        var select = document.getElementById("cabecera-list");
        var optEmpty = document.createElement("option");
        optEmpty.text="Seleccione una opción";
        optEmpty.value="";
        select.appendChild(optEmpty);
        for (var item in cabeceras) {
            var columna = cabeceras[item];
            // log data to the console so we can see
            var opt = document.createElement("option");
            opt.value = columna.valor;
            opt.text = columna.nombre;
            select.appendChild(opt);
        }
    }

</script>