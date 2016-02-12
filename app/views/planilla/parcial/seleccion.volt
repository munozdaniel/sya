{# Utilizar cabecera existente#}
<fieldset id="pnl_seleccionar" class="panel-border" >
    {{ form('planilla/guardarCabeceraPredefinida','method':'post','id':'form_guardarCabeceraPredefinida') }}
    <legend>Seleccionar Cabecera Existente</legend>
    <div class="col-md-8">
            <div class="input-group margin">
                <select id="cabecera-list" name="cabecera_id" class="form-control" form="finalizar" required="true">
                    <option value> Seleccione una opción </option>
                </select>
                    <span class="input-group-btn">
                        {{ submit_button('Guardar Cabecera Seleccionada','class':'btn btn-info btn-flat') }}
                    </span>
            </div>
    </div>
            <div class="col-md-12"><hr></div>
    </form>
</fieldset>
<script>
    function guardarCabeceraPredefinida() {
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
</script>