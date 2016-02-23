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
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Remito.remito_nroOrden" checked/>ORDEN<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Remito.remito_nro" checked/>REMITO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Transporte.transporte_dominio" checked/>PATENTE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Transporte.nroInterno" checked/>N° INTERNO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Tipoequipo.tipoEquipo_nombre" checked/>TIPO DE EQUIPO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Tipocarga.tipoCarga_nombre" checked/>TIPO DE CARGA<br/>
    </div>
    <div class="col-md-3">
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Chofer.chofer_dni" checked/>DNI<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Chofer.chofer_nombre" checked/>CHOFER<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Remito.remito_fecha" checked/>FECHA<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Cliente.cliente_nombre" checked/>CLIENTE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Viaje.viaje_origen" checked/>ORIGEN<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Yacimiento.yacimiento_destino" checked/>DESTINO<br/>
    </div>
    <div class="col-md-3">
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Equipopozo.equipoPozo_nombre" checked/>EQUIPO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Concatenado.concatenado_nombre" checked/>CONCATENADO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Operadora.operadora_nombre" checked/>OPERADORA<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Linea.linea_nombre" checked/>LINEA-PSL<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Centrocosto.centroCosto_codigo" checked/>CENTRO COSTO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Remito.remito_observaciones" checked/>OBSERVACIONES<br/>
    </div>
    <div class="col-md-3">
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Tarifa.tarifa_km" checked/>KM<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Tarifa.tarifa_hsHidro" checked/>HS HIDRO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Tarifa.tarifa_hsMalacate" checked/>HS MALACATE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Tarifa.tarifa_hsStand" checked/>HS DE ESPERA<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Tarifa.tarifa_hsServicio" checked/>HS TOTAL SERVICIO<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Remito.remito_conformidad" checked/>CONFORMIDAD RE<br/>
        <input type="checkbox" name="col_basicas[]" class="columnas_basicas" value="Remito.remito_noConformidad" checked/>MOT NO CONFORM RE<br/>
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
            'planilla_id': $('#planilla_id').val(),
            'columnasBasicas':values
        };

        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/planilla/guardarColumnasBasicas', // the url where we want to POST
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
                        $('#pnl_seleccionar').prop('disabled', true);//Deshabilitar paso 2
                        $('#extra').prop('disabled', false);//Habilitar paso 3
                        $('#ordenar').prop('disabled', false);//Habilitar paso 4
                        //Cargar la cabecera_id para agregarle las columnas extras
                        //document.getElementById('cabecera_id').value = data.cabecera_id;
                        cargarTablaOriginal(data.cabeceraText);
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