<fieldset id="pnl_seleccionar" class="panel-border" disabled>
    <legend>Seleccionar Columnas Básicas</legend>
    {{ hidden_field('cabecera_id','value':'') }}

    <div class="col-md-2">
        <input type="radio" id="chk_seleccionar" onClick="seleccionarTodos(this)" /> Seleccionar todos<br/>
    </div>
    <div class="col-md-3">
        <input type="radio" id="chk_deseleccionar" onClick="deseleccionarTodos(this)" /> No seleccionar todos<br/>
    </div>
    <div class="col-md-12"><hr></div>
    <div class="col-md-3">
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="ORDEN" checked/>ORDEN<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="REMITO" checked/>REMITO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="PATENTE" checked/>PATENTE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="N° INTERNO" checked/>N° INTERNO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="TIPO DE EQUIPO" checked/>TIPO DE EQUIPO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="TIPO DE CARGA" checked/>TIPO DE CARGA<br/>
    </div>
    <div class="col-md-3">
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="DNI" checked/>DNI<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="CHOFER" checked/>CHOFER<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="FECHA" checked/>FECHA<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="CLIENTE" checked/>CLIENTE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="ORIGEN" checked/>ORIGEN<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="DESTINO" checked/>DESTINO<br/>
    </div>
    <div class="col-md-3">
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="EQUIPO" checked/>EQUIPO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="CONCATENADO" checked/>CONCATENADO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="OPERADORA" checked/>OPERADORA<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="LINEA-PSL" checked/>LINEA-PSL<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="CENTRO COSTO" checked/>CENTRO COSTO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="OBSERVACIONES" checked/>OBSERVACIONES<br/>
    </div>
    <div class="col-md-3">
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="KM" checked/>KM<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="HS HIDRO" checked/>HS HIDRO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="HS MALACATE" checked/>HS MALACATE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="HS DE ESPERA" checked/>HS DE ESPERA<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="HS TOTAL SERVICIO" checked/>HS TOTAL SERVICIO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="CONFORMIDAD RE" checked/>CONFORMIDAD RE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="MOT NO CONFORM RE" checked/>MOT NO CONFORM RE<br/>
    </div>
    <div class="col-md-12">
        <hr>
        <input id="btn_agregar_basicas" type="button"  class="btn btn-flat large btn-primary "
               onclick='agregarColumnasBasicas()' value='Guardar Cabecera'/>
    </div>

</fieldset>
<script language="JavaScript">
    function seleccionarTodos(source) {
        checkboxes = document.getElementsByName('col_basicas[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
        document.getElementById("chk_deseleccionar").checked = false;


    }
    function deseleccionarTodos(source) {
        checkboxes = document.getElementsByName('col_basicas[]');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = !source.checked;
        }
        document.getElementById("chk_seleccionar").checked = false;
    }
    /**
     * Permite guardar las columnas seleccionadas en el groupCheckbox y guardarlas en una cabecera nueva.
     */
    function agregarColumnasBasicas() {
        $('.block-columnas').remove(); // remove the error text

        //Los datos para crear una cabecera y asignarselo a la planilla.
        //FIXME: al ordenar se deberia pisar la cabecera de la planilla por la que se haya seleccionado.
        var values = new Array();
        $.each($("input[name='col_basicas[]']:checked"), function() {
            values.push($(this).val());
        });
        var datos = {
            'planilla_nombreCliente': $('#planilla_nombreCliente').val(),
            'planilla_id': $('#planilla_id').val(),
            'columnasBasicas':values
        };

        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/cabecera/guardarCabeceraBasica', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
            // using the done promise callback
                .done(function (data) {
                    // log data to the console so we can see
                    //console.log(data);
                    if (!data.success) {
                        for(var item in data.mensaje) {
                            $('#grupo_planilla').append('<div class="block-columnas  alert-danger">&nbsp; <i class="fa fa-exclamation-triangle"></i> ' + data.mensaje[item] + '</div>'); // add the actual error message under our input
                        }
                    } else {
                        $('#grupo_planilla').append('<div class="block-columnas  alert-success">&nbsp; Operación Exitosa</div>');
                        //Habilitar columnas extras y ordenar columnas.
                        $('#extra').prop('disabled', false);//Habilitar paso 2
                        $('#ordenar').prop('disabled', false);//Habilitar paso 3
                        //Cargar la cabecera_id para agregarle las columnas extras
                        document.getElementById('cabecera_id').value = data.cabecera_id
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