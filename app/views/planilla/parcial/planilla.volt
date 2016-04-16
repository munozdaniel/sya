{{ form("planilla/crear","id":"form_planilla", "method":"post",'class':'form-horizontal') }}
    {{ hidden_field('planilla_id','value':'','form':'form_guardarCabeceraPredefinida') }}
    <fieldset id="planilla" class="panel-border">
        <legend>Generar Planilla</legend>


        <div class="form-group">
            <label class="control-label col-sm-2" for="fechaActual">FECHA: </label>

            <div class="col-sm-6">
                {{ text_field('fechaActual','value':fechaActual,'readonly':'true','class':'form-control','style':'text-align: right !important; font-weight:bold;') }}
            </div>
        </div>
        <div class="form-group">
            {#cliente_nombre#}
            {{ selectCliente.label({'class':'col-sm-2 control-label'}) }}
            <div class="col-sm-6">
                {{ selectCliente }}
            </div>
        </div>
        <!-- radio -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="radio">
                    <label>
                        <input type="radio" name="tipo_planilla" id="id_planilla_registro"
                               value="0" checked>
                        Planilla de Registro Mensual
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="tipo_planilla" id="id_planilla_oncall" value="1">
                        Planilla On Call - 1er Quincena
                    </label>
                    <br>
                    <label>
                        <input type="radio" name="tipo_planilla" id="id_planilla_oncall" value="2">
                        Planilla On Call - 2da Quincena
                    </label>
                </div>
            </div>
            <hr>

        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button id="btn_guardar_planilla" type="submit" class="btn btn-flat btn-lg btn-primary btn-block"><i
                            class="fa fa-save"></i> Guardar Planilla
                </button>
            </div>
        </div>
        {#======================================================================================#}
    </fieldset>
{{ end_form() }}
<script>
    /**
     * Realiza una llamada ajax para guardar los datos, luego, permite habilitar los botones para
     * seleccionar el el radio button para la cabecera.
     */
    $(document).ready(function () {
        //Escondemos
        $('#pnl_cabecera').hide();
        $('#pnl_seleccion').hide();

        // PROCESANDO el formulario
        $('#form_planilla').submit(function (event) {
            $('.help-block').remove(); // Limpieza de los mensajes de alerta.
            var values = [];
            $.each($("input[name='tipo_planilla']:checked"), function () {
                values.push($(this).val());
            });

            //PREPARANDO los datos para enviar
            var datos = {
                'fechaActual': $('#fechaActual').val(),
                'tipo_planilla': values,
                'cliente_nombre': $('#cliente_nombre').val(),
                'cliente_id': $('#cliente_id').val()
            };

            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '/sya/planilla/crear', // the url where we want to POST
                data: datos, // our data object
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
                    .done(function (data) {
                        //console.log(data);
                        if (!data.success) {
                            for (var item in data.mensaje) {
                                var elemento = data.mensaje[item];
                                $('#mensajes-alertas').append('<div class="help-block  alert-danger"><h4><i class="fa fa-exclamation-triangle"></i> ' + elemento + '</h4></div>'); // add the actual error message under our input
                            }
                        } else {
                            // here we will handle errors and validation messages
                            $('#btn_guardar_planilla').prop('disabled', true);//Dehsabilitar boton guardar planilla
                            $('#mensajes-alertas').append('<div class="help-block  alert-success"><h4>Operación Exitosa, la planilla se ha generado correctamente. </h4><h4> Por favor seleccione la cabecera a utilizar.</h4></div>');
                            document.getElementById('planilla_id').value = data.planilla_id;
                            $('#pnl_planilla').hide(1000);
                            $('#pnl_cabecera').show(1000);
                        }
                    })
                    .fail(function (data) {
                        console.log(data);
                    });
            event.preventDefault();
        });

    });//Fin: ready
</script>

