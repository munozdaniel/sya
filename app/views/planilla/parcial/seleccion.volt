{# Utilizar cabecera existente#}
<fieldset class="panel-border" >
    {{ form('planilla/guardarCabeceraPredefinida','method':'post','id':'form_guardarCabeceraPredefinida') }}
    <legend>            <a class="btn btn-twitter btn-flat" onclick="volverACabecera()"><i class="fa fa-arrow-left"></i></a>
        Seleccionar Cabecera Existente</legend>
    <div class="col-md-10">
            <div class="input-group margin">
                <select id="cabecera_id" name="cabecera_id" class="form-control autocompletar" style="width:100%" required="" tabindex="-1" aria-hidden="true">
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
    $(function () {
        $(".autocompletar").select2();
    });
</script>
<script>
    function volverACabecera()
    {
        $('.help-block').remove();
        $('#pnl_seleccion').hide(1000);
        $('#pnl_cabecera').show(1000);
    }
    // PROCESANDO el formulario
    $('#form_guardarCabeceraPredefinida').submit(function (event) {
        $('.help-block').remove(); // Limpieza de los mensajes de alerta.

        //PREPARANDO los datos para enviar
        var datos = {
            'cabecera_id': $('#cabecera_id').val(),
            'planilla_id': $('#planilla_id').val()
        };

        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/cabecera/guardarCabeceraPredefinida', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        .done(function (data) {
                console.log(data);
            if (!data.success) {
                $('#mensajes-alertas').append('<div class="help-block  alert-danger"><h4><i class="fa fa-exclamation-triangle"></i> ' + data.mensaje + '</h4></div>'); // add the actual error message under our input
            } else {
                $('#mensajes-alertas').append(data.mensaje); // add the actual error message under our input
                $('#pnl_seleccion').hide(1000);
                $('#mensajes-alertas').show(1000);
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