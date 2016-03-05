
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">ELIMINAR COLUMNAS
            <br>
            <small> Seleccione la planilla luego seleccione las columnas a eliminar </small>
        </h2>

    </div>
    {{ content() }}
    <div id="mensajes"></div>
    {{ form("columna/eliminarSeleccionados","id":"form-extras", "method":"post") }}
    <fieldset id="fielset-buscar-planilla" class="panel-border">
        <legend>SYA</legend>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="form-group">
                        <label>Nombre de la planilla</label>
                        {{ formulario.render() }}
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="cabecera"></div>

                </div>
           </div>
            <div class="row">
                <hr>
                <div class="col-md-6 col-md-offset-4">

                {{ submit_button('ELIMINAR SELECCIONADOS','class':'btn btn-lg btn-primary') }}
                </div>
            </div>

        </div>
    </fieldset>
    {{ end_form() }}
</div>

<script>

    $(function () {
        $(".autocompletar").select2();

    });
    function cargarColumnas()
    {
        var datos = {
            'planilla_id': document.getElementById("planilla_id").value
        };
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '/sya/columna/obtenerIdColumnas',
            data: datos, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        .done(function (data) {
            //console.log(data);
            $('#cabecera').empty();
            $('#mensajes').empty();
            if (!data.success)
            {
                $('#mensajes').append('<div class="help-block  alert-danger">&nbsp;' +
                ' <i class="fa fa-exclamation-triangle"></i> Por favor, seleccione una planilla que contenga columnas extras. </div>'); // add the actual error message under our input
            }else{
                var ppal = document.getElementById("cabecera");
                for(var item in data.columnas)
                {
                    //console.log(col);
                    var col = data.columnas[item];
                    var checkbox  = document.createElement('input');
                    checkbox.type = "checkbox";
                    checkbox.name = "columnas[]";
                    checkbox.value = col['columna_id'];//El nombre de la columna es unique
                    //checkbox.id = col;
                    checkbox.setAttribute('class','minimal-red');
                    var label = document.createElement('label');
                    label.appendChild(checkbox);
                    label.appendChild(document.createTextNode(" "+col['columna_nombre']));
                    var colmd = document.createElement("div");
                    colmd.setAttribute('class','col-md-3');
                    colmd.appendChild(label);
                    ppal.appendChild(colmd);

                }
                $('#submit').prop('disabled', false);
                //Le da estilo a los checkbox
                $('input[type=\"checkbox\"].minimal-red, input[type=\"radio\"].minimal-red').iCheck({
                    checkboxClass: 'icheckbox_minimal-red',
                    radioClass: 'iradio_minimal-red'
                });
            }

        })
        .fail(function (data) {
            console.log("recuperarColumnas");
            console.log(data);
        });
    }
</script>