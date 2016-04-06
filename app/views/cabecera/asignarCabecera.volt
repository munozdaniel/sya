<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">ASIGNAR CABECERA</h3>

        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/buscarRemitoPorPlanilla", "<i class='fa fa-search'></i> Seleccionar otra planilla",'class':'btn btn-flat btn-google') }}
                </td>

                <td align="right">
                    {{ link_to("remito/nuevoRemitoPorPlanilla", "<i class='fa fa-search'></i> Agregar Remito",'class':'btn btn-flat btn-primary') }}
                </td>

            </tr>
        </table>
    </div>
</div>
{#=============================================================================================================#}

{# Utilizar cabecera existente#}
<fieldset class="panel-border" >
    {{ form('planilla/guardarCabeceraPredefinida','method':'post','id':'form_guardarCabeceraPredefinida') }}
    {{ hidden_field('planilla_id','value':planilla.getPlanillaId()) }}
    <legend>Seleccionar Cabecera Existente</legend>
    <div class="col-md-10">
        <div id="mensajes-alertas"></div>
        <div id="boton" class="input-group margin">
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
    window.onload=function() {
        todasLasCabeceras();
    };
    function todasLasCabeceras(){
        datos = {
            'cliente_nombre': $('#cliente_nombre').val()
        };
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/cabecera/todasLasCabeceras', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                .done(function (data) {
                    //console.log(data);
                    if (data.success)
                    {
                        llenarComboBoxCabecera(data.cabeceras);
                        $('#extra').prop('disabled', false);//Habilitar panel extra
                        $('#ordenar').prop('disabled', false);//Habilitar panel columnas para ordenar
                        $('#planilla').prop('disabled', false);//Deshabilitar panel planilla
                        $('#mensajes-alertas').append('<div class="help-block  alert-success"><h4> Por favor, seleccione la cabecera a utilizar </h4></div>'); // add the actual error message under our input

                    }
                    else
                    {
                        for (var item in data.mensaje) {
                            var elemento = data.mensaje[item];
                            $('#mensajes-alertas').append('<div class="help-block  alert-danger"><h4> <i class="fa fa-exclamation-triangle"></i> ' + elemento + ' <br> Por favor, cree una nueva cabecera.</h4></div>'); // add the actual error message under our input
                        }
                    }
                    //FIXME: Que pasa si  no encuentra cabeceras ???
                })
                .fail(function (data) {
                    console.log("FAIL");
                    console.log(data);
                });
    }
    function llenarComboBoxCabecera(cabeceras)
    {
        $('#cabecera_id').empty();

        var select = document.getElementById("cabecera_id");
        var optEmpty = document.createElement("option");
        optEmpty.text="Seleccione una opción";
        optEmpty.value="";
        select.appendChild(optEmpty);
        for(var item in cabeceras)
        {

            var elemento = cabeceras[item];
            // log data to the console so we can see
            var opt = document.createElement("option");
            opt.value = elemento['cabecera_id'];
            opt.text = elemento['nombreCliente'];
            select.appendChild(opt);
        }
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
                        $('#mensajes-alertas').append("<div class='alert alert-success'>OPERACIÓN EXITOSA, REDIRECCIONANDO ... </div>"); // add the actual error message under our input
                        $('#boton').hide(1000);
                        setTimeout ("redireccionar()", 2000); //tiempo expresado en milisegundos

                    }
                })
                .fail(function (data) {
                    // show any errors
                    // best to remove for production
                    console.log(data);
                });
        event.preventDefault();
    });
    function redireccionar(){
        window.location="/sya/planilla/view/"+{{ planilla.getPlanillaId() }};
    }
</script>