{{ form('planilla/finalizar','id':'finalizar','method':'post') }}
<fieldset id="ordenar" class="panel-border" disabled>

    <legend>Ordenar Columnas <small>(opcional)</small></legend>
    <div class="input-group margin col-md-5">
        <select id="cabecera-list" class="form-control" onchange="cargarTabla()" form="finalizar" required="true">
            <option value> Seleccione una opción </option>
        </select>
        <span class="input-group-btn">
          <a id="btn_cargar_columnas" class="btn btn-info btn-flat"><i class="fa fa-refresh"></i></a>
        </span>
        <input type="hidden" id="token_ordenar" name="<?php echo $this->security->getTokenKey() ?>"
               value="<?php echo $this->security->getToken() ?>"/>
    </div>

    <script type="text/javascript">
        // Guarda el nuevo orden de las columnas
        $(document).ready(function () {
            $("#ul_columnas").sortable({
                handle: '.handle',
                update: function () {
                    var order = $('#ul_columnas').sortable('serialize');
                    $("#info").load("ordenar?" + order);
                }
            });
        });
    </script>

    <div class="contenedor-lista">
        <ol id="ul_columnas">
            <!--li id="listItem_1">
                <a class="handle">
                    <strong>Item 1 </strong>
                </a>
            </li-->
        </ol>
    </div>
    <pre>
        <div id="info"><em>El orden asignado se guardará para generar las planillas Excel</em></div>
    </pre>
    <div align="center">
        {{ submit_button('FINALIZAR LA CREACIÓN DE LA PLANILLA','class':'btn btn-flat btn-lg btn-primary') }}
        </form>
    </div>
</fieldset>
<!-- ====================================== -->
<script>
    $('#link_finalizar').bind('click', function (e) {
        e.preventDefault();
    });
    var cargar = $("#btn_cargar_columnas"); //ID del Botón Agregar

    $(cargar).click(function (e) {
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
        event.preventDefault();
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
    function cargarTabla() {
        var select = document.getElementById("cabecera-list");
        var datos = {
            'cabecera_id': select.value

        };
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/cabecera/buscarColumnas', // the url where we want to POST
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
            // using the done promise callback
                .done(function (data) {
                    console.log(data);
                    $('#ul_columnas').empty();
                    var ul = document.getElementById("ul_columnas");
                    for (var item in data.mensaje) {
                        var columna = data.mensaje[item];

                        var li = document.createElement("li");
                        var a = document.createElement("a");
                        a.setAttribute("class", 'handle');
                        a.appendChild(document.createTextNode(columna.nombre));
                        li.appendChild(a);
                        li.setAttribute("id", 'listItem_' + columna.id);
                        ul.appendChild(li);
                    }
                })
            // using the fail promise callback
                .fail(function (data) {
                    // show any errors
                    // best to remove for production
                    console.log("FAIL");
                    console.log(data);
                });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    }
    function habilitarOrdenarColumnas() {
        $('#extra').prop('disabled', true);
        $('#ordenar').prop('disabled', false);
    }
    function habilitarGuardar() {
        $('#ordenar').prop('disabled', true);
        $('#guardar').prop('disabled', false);
    }

</script>