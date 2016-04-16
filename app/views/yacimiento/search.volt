<!-- Titulo -->
<div class="box-header">
    <h3 class="box-title">Listado de Yacimientos</h3>

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("yacimiento", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
            <td align="right">
                {{ link_to("yacimiento/new", "Nuevo Yacimiento",'class':'btn btn-large btn-danger btn-flat') }}
            </td>
        </tr>
    </table>
</div>
<!-- ./ Titulo -->
{{ content() }}

<div class="box-body">
    <table id="tabla"
           data-escape="false"{# Para usar html en las celdas#}
           data-toggle="table"
           data-cookie="true"
           data-cookie-id-table="tabla"
           data-reorderable-columns="true"
           data-click-to-select="true"
           data-row-style="rowStyle"
           class="table table-bordered table-striped">
        <thead>
        <tr>
            <th data-field="Nro" data-sortable="true">#</th>
            <th data-field="nombre" data-sortable="true" data-halign="center" data-align="center">Destino</th>
            <th data-field="operadora" data-sortable="true" data-halign="center" data-align="center">Operadora</th>
            <th data-field="equipoPozo" data-sortable="true" data-halign="center" data-align="center">Equipo/Pozo</th>
            <th data-field="editar" data-sortable="true" data-halign="center" data-align="center">Editar</th>
            <th data-field="eliminar" data-sortable="true" data-halign="center" data-align="center">Eliminar</th>
            <th data-field="estado" style="width: 10px;" data-sortable="true" data-halign="center"
                data-align="center">EST
        </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for yacimiento in page.items %}
                <tr>
                    <td>{{ yacimiento.getYacimientoId() }}</td>
                    <td>{{ yacimiento.getYacimientoDestino() }}</td>
                    <td>
                        {{ link_to("operadora/search/"~yacimiento.getYacimientoId(), "Ver Operadoras",'class':'btn btn-flat  bg-light-blue-gradient') }}
                        <a href="#agregarOperadora" role="button"
                           class="btn btn-flat bg-light-blue-gradient" data-toggle="modal"
                           onclick="setearHidden({{ yacimiento.getYacimientoId() }})">Agregar Operadora</a>
                    </td>
                    <td>
                        {{ link_to("equipopozo/buscarEPPorYacimiento/"~yacimiento.getYacimientoId(), "Ver Equipo/Pozo",'class':'btn btn-flat  bg-light-blue-gradient') }}
                        <a href="#agregarEP" role="button"
                           class="btn btn-flat bg-light-blue-gradient" data-toggle="modal"
                           onclick="setearHidden({{ yacimiento.getYacimientoId() }})">Agregar Equipo/Pozo</a>
                    </td>
                    {% if admin == 1 %}
                        <td>{{ link_to("yacimiento/edit/"~yacimiento.getYacimientoId(), "Editar") }}</td>
                        <td>
                            {% if yacimiento.getYacimientoHabilitado() == 1 %}
                                <a href="#confirmarEliminar" role="button" class="enviar-dato" data-toggle="modal" data-id="{{  yacimiento.getYacimientoId() }}">Eliminar</a>
                            {% else %}
                                {{ link_to("yacimiento/habilitar/"~yacimiento.getYacimientoId(), "Habilitar") }}
                            {%endif%}
                        </td>
                    {% else %}
                        <td> sin acceso</td>
                        <td> sin acceso</td>
                    {% endif %}
                    {% if yacimiento.getYacimientoHabilitado() == 1 %}
                        <td class="bg-green-active"><i class="fa fa-check-circle-o"></i></td>
                    {% else %}
                        <td class="bg-red-active"><i class="fa fa-remove"></i></td>
                    {% endif %}
                </tr>
            {% endfor %}
        {% endif %}

        </tbody>


    </table>
</div>
<!-- /.box-body -->


<!--=========== ConfirmarEliminar ================-->
<div id="confirmarEliminar" class="modal fade modal-danger">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa   fa-hand-stop-o"></i> CONFIRMACIÓN</h4>
            </div>
            <div class="modal-body margin-left-right-one"
                 style="border-left: 0 !important; border-right: 0 !important;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 ">
                        <!-- START SUBSCRIBE HEADING -->
                        <div class="heading">
                            <h2 class="wow fadeInLeftBig">Esta seguro de continuar con la eliminación? </h2>
                            <p>Recuerde que el Yacimiento eliminado no podrá ser utilizado nuevamente.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ form('yacimiento/eliminar','method':'POST') }}
                <div  id="cuerpo">
                    {{ hidden_field('id','value':'','form') }}
                    {{ submit_button('Eliminar','class':'btn btn-outline') }}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--=========== FIN:ConfirmarEliminar ================-->
<!--=========== Agregar Operadora ================-->
<div id="agregarOperadora" class="modal fade modal-primary">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> INGRESAR DATOS</h4>
            </div>
            <div class="modal-body margin-left-right-one">

                <div class="row">
                    <div class="col-md-12">
                        <div id="mensajes-alertas"></div>

                        {{ form('linea/agregarOperadoraAlYacimiento', "method":"post" ,"id":"guardarOperadora") }}

                        {{ hidden_field('operadora_yacimientoId') }}

                        <label for="operadora_nombre">Nombre de la Operadora</label>

                        <div class="form-group">
                            {{ text_field("operadora_nombre", "size" : 50,'class':'form-control','required':'true','placeholder':'INGRESAR NOMBRE','form':'nuevaOperadora') }}
                        </div>


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ submit_button('AGREGAR','class':'btn btn-outline') }}

                {{ end_form() }}
            </div>
        </div>
    </div>
</div>
<!--=========== FIN:Agregar Operadora ================-->
<script>
    function setearHidden(operadora_yacimientoId) {
        document.getElementById("operadora_yacimientoId").value = operadora_yacimientoId;
    }
    /**
     * Realiza una llamada ajax para guardar los datos de una linea para un cliente seleccionado
     */
    $('#guardarOperadora').submit(function (event) {
        $('.help-block').remove(); // Limpieza de los mensajes de alerta.

        var datos = {
            'operadora_nombre': $('#operadora_nombre').val(),
            'operadora_yacimientoId': $('#operadora_yacimientoId').val()
        };

        $.ajax({
            type: 'POST',
            url: '/sya/operadora/agregarOperadoraAlYacimiento',
            data: datos,
            dataType: 'json',
            encode: true
        })
                .done(function (data) {
                    console.log(data);
                    if (!data.success)
                    {
                        $('#mensajes-alertas').append('<div class="help-block  alert-danger"><h4><i class="fa fa-info-circle"></i> ' + data.mensaje + '</h4></div>');
                    }
                    else
                    {
                        $('#mensajes-alertas').append('<div class="help-block  alert-success"><h4><i class="fa fa-exclamation-triangle"></i> ' + data.mensaje + '<br><small> Puede continuar agregando lineas.</small></h4></div>');
                        document.getElementById("operadora_nombre").value = "";

                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
        event.preventDefault();
    });

</script>