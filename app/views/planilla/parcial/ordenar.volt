<div id="pnl_ordenar">
    {{ form('planilla/finalizar','id':'finalizar','method':'post') }}
        <fieldset id="ordenar" class="panel-border" disabled>

            <legend>Ordenar Columnas <small>(opcional)</small></legend>
                <input type="hidden" id="token_ordenar" name="<?php echo $this->security->getTokenKey() ?>"
                       value="<?php echo $this->security->getToken() ?>"/>
            <div class="col-md-12">
                <a class="btn btn-flat large btn-primary" onclick='cargarTabla()'>  <i class="fa fa-refresh"></i> Cargar columnas</a>
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
            <div class="col-md-12">
            <div class="contenedor-lista">
                <ol id="ul_columnas">
                    <!--li id="listItem_1">
                        <a class="handle">
                            <strong>Item 1 </strong>
                        </a>
                    </li-->
                </ol>
            </div>
            </div>
            <pre>
                <div id="info"><em>El orden asignado se guardará para generar las planillas Excel</em></div>
            </pre>
            <div align="center">
                {{ submit_button('FINALIZAR LA CREACIÓN DE LA PLANILLA','class':'btn btn-flat btn-lg btn-primary') }}
            </div>
        </fieldset>
    {{ end_form() }}
</div>
<!-- ====================================== -->
<script>
    $('#link_finalizar').bind('click', function (e) {
        e.preventDefault();
    });

    function cargarTablaOriginal() {
        var datos = {
            'cabecera_id': $("#cabecera_id").val()

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
    function cargarTabla(arreglo) {

        console.log("ARREGLO: "+arreglo);
        var ul = document.getElementById("ul_columnas");
        var arregloCabecera = arreglo.split("-");
        for(var i in arregloCabecera)
        {
            console.log("arregloCabecera : "+arregloCabecera);
            console.log("i: "+i);
            var li = document.createElement("li");
            var a = document.createElement("a");
            a.setAttribute("class", 'handle');
            a.appendChild(document.createTextNode(arregloCabecera[i]));
            li.appendChild(a);
            li.setAttribute("id", 'listItem_' + i);
            ul.appendChild(li);
        }
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