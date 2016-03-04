<div id="pnl_cabecera"  class="col-xs-12 col-md-6">
    <fieldset class="panel-border">
        <legend>Seleccionar Cabecera</legend>
        <div id="id_paneles" class="col-md-12">
            {{ hidden_field('id_cabecera_input','value':'') }}
            <div id="cabecera_mje">
                {# Genera alertas#}
            </div>
            <div class="form-group ">
                <div class="radio">
                    <label >
                        <input type="radio" name="opciones" id="rbt_nuevaCabecera" value="1" checked="">
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
            <br>
            <hr>
            <br>
            <br>
            <input id="btn_generar_columnas" type="button" class="btn btn-flat btn-lg btn-block btn-primary"
                   onclick='generarColumnas()' value='FINALIZAR LA CREACIÓN DE LA PLANILLA'/>

        </div>
    </fieldset>
</div>
<script>
    /**
     * Verifica que radio button esta seleccionado:
     * Nueva cabecera: Se cargan nuevas columnas basicas a la bd.
     * Utilizar Cabecera Existente: Selecciona una cabecera ya creada.
     */
    function generarColumnas()
    {
        /*================================ NUEVA CABECERA ========================*/
        if($("input[name='opciones']:checked").val()==1)
        {
            $("#id_cabeceraExistente").hide();
            $("#id_nuevaCabecera").show();
            $('.help-block').remove(); // remove the error text
            var datos = {
                'planilla_id': $('#planilla_id').val()
            };
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: '/sya/cabecera/crearColumnasBasicas', // the url where we want to POST
                data: datos, // our data object
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
                    .done(function (data) {
                        if (!data.success)
                        {
                            for (var item in data.mensaje) {
                                var elemento = data.mensaje[item];
                                $('#cabecera_mje').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + elemento + '</div>'); // add the actual error message under our input
                            }
                        }else{
                            $('#cabecera_mje').append('<div class="help-block  alert-success">&nbsp; LA CABECERA FUE CREADA CON EXITO. <br> &nbsp; Si desea puede agregar y/o reordenar las columnas</div>'); // add the actual error message under our input
                            $('#planilla').prop('disabled', true);
                            $('#cabecera').prop('disabled', true);
                            $('#extra').prop('disabled', false);
                            $('#pnl_cabecera').prop('disabled', true);
                            $('#btn_generar_columnas').prop('disabled', true);
                            //$('#ordenar').prop('disabled', false);
                            $('#pnl_extra').show();
                            //$('#pnl_ordenar').show();
                            document.getElementById('id_cabecera_input').value = data.cabecera_id;

                           // cargarTablaReordenable(data.columnas);
                        }
                    })
                    .fail(function (data) {
                        // show any errors
                        // best to remove for production
                        console.log("FAIL");
                        console.log(data);
                    });
        }
        else
        {
            /*================================ CABECERA CARGADAS ========================*/

            $("#id_cabeceraExistente").show();
            $("#id_nuevaCabecera").hide();
            todasLasCabeceras();

        }
    }
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
                    if (data.success)
                    {
                        llenarComboBoxCabecera(data.cabeceras);
                        $('#extra').prop('disabled', false);//Habilitar panel extra
                        $('#ordenar').prop('disabled', false);//Habilitar panel columnas para ordenar
                        $('#planilla').prop('disabled', false);//Deshabilitar panel planilla
                        $('#cabecera_mje').append('<div class="help-block  alert-success">&nbsp; Por favor, seleccione la cabecera a utilizar</div>'); // add the actual error message under our input

                    }
                    else
                    {
                        for (var item in data.mensaje) {
                            var elemento = data.mensaje[item];
                            $('#cabecera_mje').append('<div class="help-block  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + elemento + ' <br> Por favor, cree una nueva cabecera.</div>'); // add the actual error message under our input
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
    }
    /**
     * Muestra una lista con todas las columnas. Permite que sean reordenables.
     */
    function cargarTablaReordenable(columnas) {

        $('#ul_columnas').empty();

        var ul = document.getElementById("ul_columnas");
        var i = 0;
        for(var item in columnas)
        {
            var elemento = columnas[item];
            var li = document.createElement("li");
            li.setAttribute('value',elemento['columna_id']);
            li.setAttribute("id", 'listItem_' + elemento['columna_id']);
            var a = document.createElement("a");
            a.setAttribute("class", 'handle');
            a.appendChild(document.createTextNode(elemento['columna_nombre']));
            li.appendChild(a);
            ul.appendChild(li);
            i++;

        }
    }
    /**
     * Opcion 2: LLena el combo box con los nombres de las cabeceras.
     */
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
</script>