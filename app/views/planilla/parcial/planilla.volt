<div class="col-xs-12 col-md-6">
    {{ form("planilla/crear","id":"form_planilla", "method":"post") }}
        {{ hidden_field('planilla_id','value':'','form':'form_guardarCabeceraPredefinida') }}
        <fieldset id="planilla" class="panel-border">
            <legend>Generar Planilla</legend>

            <div id="grupo_planilla" >
                {# Genera alertas #}
            </div>

            <div class="form-group">
                <strong>Fecha:</strong> {{ fechaActual }}
                {{ hidden_field('fechaActual','value':fechaActual) }}
            </div>
            <div class="form-group">
                {#cliente_nombre#}
                {{ selectCliente.label() }}
                {{ selectCliente }}
            </div>
            <!-- radio -->
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="tipo_planilla" id="id_planilla_registro"
                               value="REGISTRO" checked>
                        Planilla de Registro &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="tipo_planilla" id="id_planilla_oncall" value="ONCALL">
                        Planilla On Call
                    </label>
                </div>
                <hr>
                <button id="btn_guardar_planilla" type="submit" class="btn btn-flat btn-lg btn-primary"><i
                            class="fa fa-save"></i> Guardar Planilla
                </button>
            </div>
            {#======================================================================================#}
        </fieldset>
    {{ end_form() }}
</div>
<script>
    /**
     * Realiza una llamada ajax para guardar los datos, luego, permite habilitar los botones para
     * seleccionar el el radio button para la cabecera.
     */
    $(document).ready(function () {
        $('#pnl_cabecera').hide();
        $('#pnl_extra').hide();
        $('#pnl_ordenar').hide();

        // PROCESANDO el formulario
        $('#form_planilla').submit(function (event) {
            $('.help-block').remove(); // remove the error text
            var values = [];
            $.each($("input[name='tipo_planilla']:checked"), function() {
                values.push($(this).val());
            });

            //PREPARANDO los datos para enviar
            var datos = {
                'fechaActual': $('#fechaActual').val(),
                'tipo_planilla': values,
                'cliente_nombre': $('#cliente_nombre').val()
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
                            for (var item in data.mensaje) {
                                var elemento = data.mensaje[item];
                                $('#grupo_planilla').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + elemento + '</div>'); // add the actual error message under our input
                            }
                        } else {
                            // here we will handle errors and validation messages
                            $('#btn_guardar_planilla').prop('disabled', true);//Dehsabilitar boton guardar planilla
                            //$('#pnl_seleccionar').prop('disabled', false);//Habilitar div para seleccionar radio buttons
                            $('#grupo_planilla').append('<div class="help-block  alert-success">&nbsp; Operación Exitosa</div>');
                            document.getElementById('planilla_id').value = data.planilla_id;
                            $('#pnl_cabecera').show();//Habilitar boton editar planilla

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
</script>
{{ partial('planilla/parcial/cabecera') }}
<script>

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
    /*$('input[type=radio][name=opciones]').change(function() {
        if(this.value == 0){
            $("#id_cabeceraExistente").show();
            $("#id_nuevaCabecera").hide();
           *//* $.ajax({
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
                    });*//*
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
    */
</script>