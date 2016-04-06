<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">CREAR NUEVA CABECERA</h3>

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
<div id="mensajes-alertas"></div>
{{ hidden_field('planilla_id','value':planilla.getPlanillaId()) }}
<script>
    window.onload=function() {
        generarColumnas();
    };
    function generarColumnas() {
        $('.help-block').remove();
        /*================================ NUEVA CABECERA ========================*/
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
                    if (!data.success) {
                        for (var item in data.mensaje) {
                            var elemento = data.mensaje[item];
                            $('#mensajes-alertas').append('<div class="help-block alert-danger"><h4> <i class="fa fa-exclamation-triangle"></i> ' + elemento + '</h4></div>'); // add the actual error message under our input
                        }
                    } else {

                        $('#mensajes-alertas').append('' +
                        '<div class="help-block">' +
                        '<h4> Operación Exitosa, la planilla se encuentra configurada correctamente.</h4>' +
                        '<small>* Es necesario tener permisos de administrador.</small></div>'+ // add the actual error message under our input
                        '<small> Redireccionando...</small></div>'); // add the actual error message under our input
                        redireccionar();

                    }
                })
                .fail(function (data) {
                    console.log("FAIL");
                    console.log(data);
                });

    }
    function redireccionar(){
        window.location="/sya/planilla/view/"+{{ planilla.getPlanillaId() }};
    }
</script>