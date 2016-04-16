
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">HABILITAR/DESHABILITAR COLUMNAS
            <br>
            <small> Seleccione la cabecera y luego marque las columnas a editar. </small>
        </h2>
    </div>
    {{ content() }}
    <div id="mensajes"></div>
    {{ form("columna/guardarEditar","id":"form-extras", "method":"post") }}
    <fieldset id="fielset-buscar-planilla" class="panel-border">
        <legend>SYA</legend>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="form-group">
                        <label>Nombre de la cabecera</label>
                        {{ formulario.render() }}
                        <a onclick="cargarColumnas()" class="btn btn-primary btn-flat"> Buscar columnas</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="cabecera"></div>

                </div>
            </div>
            <div class="row">
                <hr>
                <div class="col-md-6 col-md-offset-3">

                    {{ submit_button('HABILITAR/DESHABILITAR SELECCIONADOS','class':'btn btn-lg btn-primary btn-flat') }}
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
            'cabecera_id': document.getElementById("cabecera_id").value
        };
        $.ajax({
            type: 'POST',
            url: '/sya/columna/obtenerColumnasNombreId',
            data: datos,
            dataType: 'json',
            encode: true
        })
                .done(function (data) {
                    console.log(data);
                    $('#cabecera').empty();
                    $('#mensajes').empty();
                    if (!data.success)
                    {
                        $('#mensajes').append('<div class="help-block  alert-danger">&nbsp;' +
                        ' <i class="fa fa-exclamation-triangle"></i> '+ data.mensaje +'</div>'); // add the actual error message under our input
                    }else{
                        var ppal = document.getElementById("cabecera");
                        document.getElementById("cabecera_id").value = data.cabecera_id;
                        for(var item in data.columnas)
                        {
                            //console.log(col);
                            var col = data.columnas[item];
                            var checkbox  = document.createElement('input');
                            checkbox.type = "checkbox";
                            checkbox.name = "columnas[]";
                            checkbox.value = col['columna_id'];//El nombre de la columna es unique
                            //checkbox.id = col;
                            if(col['columna_habilitado']==1)
                                checkbox.setAttribute('checked','true');
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