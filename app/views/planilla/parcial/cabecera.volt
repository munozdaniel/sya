    <fieldset class="panel-border">
        <legend>Seleccionar Cabecera</legend>
        <div id="id_paneles" class="col-md-12">
            {{ hidden_field('id_cabecera_input','value':'') }}
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="radio">
                        <label >
                            <input type="radio" name="opciones" id="rbt_nuevaCabecera" value="1" checked="">
                            Crear una nueva cabecera.
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="opciones" id="rbt_cabeceraExistente" value="0">
                            Utilizar cabecera existente.
                        </label>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <hr>
                    <input id="btn_generar_columnas" type="button" class="btn btn-flat btn-lg btn-block btn-primary"
                           onclick='generarColumnas()' value='FINALIZAR LA CREACIÓN DE LA PLANILLA' style="text-align: center !important;"/>
                </div>
            </div>


        </div>
    </fieldset>
<script>
    /**
     * Verifica que radio button esta seleccionado:
     * Nueva cabecera: Se cargan nuevas columnas basicas a la bd.
     * Utilizar Cabecera Existente: Selecciona una cabecera ya creada.
     */
    function generarColumnas()
    {
        $('.help-block').remove();
        /*================================ NUEVA CABECERA ========================*/
        if($("input[name='opciones']:checked").val()==1)
        {
            $("#id_cabeceraExistente").hide();
            $("#id_nuevaCabecera").show();
            var datos = {
                'planilla_id': $('#planilla_id').val()
            };
            $.ajax({
                type: 'POST',
                url: '/sya/cabecera/crearColumnasBasicas',
                data: datos,
                dataType: 'json',
                encode: true
            })
                    .done(function (data) {
                        if (!data.success)
                        {
                            for (var item in data.mensaje) {
                                var elemento = data.mensaje[item];
                                $('#mensajes-alertas').append('<div class="help-block alert-danger"><h4> <i class="fa fa-exclamation-triangle"></i> ' + elemento + '</h4></div>'); // add the actual error message under our input
                            }
                        }else{

                            $('#mensajes-alertas').append('' +
                            '<div class="help-block">' +
                            '<h4> Operación Exitosa, la planilla se encuentra configurada correctamente.</h4>' +
                            ' <br>' +
                            ' <ul class="list-unstyled ">Si desea personalizar la cabecera puede: ' +
                            '<li>{{ link_to('cabecera/reordenar','Reordenar las Columnas') }}</li>' +
                            '<li>{{ link_to('cabecera/extra','Agregar Columnas Extras') }}</li>' +
                            '<li>{{ link_to('cabecera/extra','Habilitar/Eliminar Columnas') }}</li>' +
                            '</ul>' +
                            '<small>* Es necesario tener permisos de administrador.</small></div>'); // add the actual error message under our input
                            $('#extra').prop('disabled', false);
                            $('#pnl_cabecera').hide(1000);
                           // $('#pnl_extra').show(1000);

                            document.getElementById('id_cabecera_input').value = data.cabecera_id;
                        }
                    })
                    .fail(function (data) {
                        console.log("FAIL");
                        console.log(data);
                    });
        }
        else
        {
            /*================================ CABECERA CARGADAS ========================*/

            $('#pnl_cabecera').hide(1000);
            $('#pnl_seleccion').show(1000);
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
    /**
     * Muestra una lista con todas las columnas. Permite que sean reordenables.

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
    } */
</script>