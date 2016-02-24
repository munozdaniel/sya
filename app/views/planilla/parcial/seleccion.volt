{# Utilizar cabecera existente#}
<fieldset id="pnl_seleccionar" class="panel-border" >
    {{ form('planilla/guardarCabeceraPredefinida','method':'post','id':'form_guardarCabeceraPredefinida') }}
    <legend>Seleccionar Cabecera Existente</legend>
    <div class="col-md-10">
        <div id="cabeceras_error">
            {# Generar alertas #}
        </div>
            <div class="input-group margin">
                <select id="cabecera_id" name="cabecera_id" class="form-control" form="finalizar" required="true">
                    <option value> Seleccione una opción </option>
                </select>
                    <span class="input-group-btn">
                        {{ submit_button('Guardar Cabecera Seleccionada','class':'btn btn-info btn-flat') }}
                    </span>
            </div>
    </div>
            <div class="col-md-12"><hr></div>
    {{ end_form() }}
</fieldset>
<script>
    // PROCESANDO el formulario
    $('#form_guardarCabeceraPredefinida').submit(function (event) {
        $('.help-block').remove();

        //PREPARANDO los datos para enviar
        var datos = {
            'cabecera_id': $('#cabecera_id').val(),
            'planilla_id': $('#planilla_id').val()
        };

        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/planilla/guardarCabeceraPredefinida', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        .done(function (data) {
            if (!data.success) {
                for (var item in data.mensaje) {
                    var elemento = data.mensaje[item];
                    $('#cabeceras_error').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + elemento + '</div>'); // add the actual error message under our input
                }
            } else {
                //Notificar y redireccionar.
                alert("OPERACIÓN EXITOSA, LA PLANILLA SE HA GUARDADO CON EXITO");
                window.location = "index";

            }
        })
        .fail(function (data) {
            // show any errors
            // best to remove for production
            console.log(data);
        });
        event.preventDefault();
    });

</script>