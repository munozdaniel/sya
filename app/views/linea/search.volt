<!-- Titulo -->
<div class="box-header">
    <h3 class="box-title">Listado de Lineas</h3>

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("linea/index", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
            <td align="right">
                {{ link_to("linea/new", "Nueva Linea",'class':'btn btn-flat btn-large btn-danger') }}
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
            <th data-field="nombre" data-sortable="true" data-halign="center" data-align="center">Nombre</th>
            <th data-field="cliente" data-sortable="true" data-halign="center" data-align="center">Cliente</th>
            <th data-field="cc" data-sortable="true" data-halign="center" data-align="center">Centro Costo</th>
            <th data-field="editar" data-sortable="true" data-halign="center" data-align="center">Editar</th>
            <th data-field="eliminar" data-sortable="true" data-halign="center" data-align="center">Eliminar</th>
            <th data-field="estado" style="width: 10px;" data-sortable="true" data-halign="center"
                data-align="center">EST
        </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for linea in page.items %}
                <tr>
                    <td>{{ linea.getLineaId() }}</td>
                    <td>{{ linea.getLineaNombre() }}</td>
                    <td><a class="btn btn-flat bg-gray btn-block">{{ linea.getCliente().getClienteNombre() }}</a> </td>
                    <td>
                        {{ link_to('centrocosto/buscarCCPorLinea/'~linea.getLineaId(),
                        'Ver los Centros de Costo','class':'btn bg-light-blue-gradient btn-flat') }}
                        <a href="#agregarLinea" role="button"
                           class="btn btn-flat bg-light-blue-gradient" data-toggle="modal"
                           onclick="setearHiddenClienteId({{ linea.getLineaId() }})">Agregar Centro de Costo</a>
                    </td>
                    {% if admin == 1 %}
                        <td>{{ link_to("linea/edit/"~linea.getLineaId(), "Editar") }}</td>
                        <td>
                            {% if linea.getLineaHabilitado() == 1 %}
                                <a href="#confirmarEliminar" role="button" class="enviar-dato" data-toggle="modal" data-id="{{  linea.getLineaId() }}">Eliminar</a>
                            {% else %}
                                {{ link_to("linea/habilitar/"~linea.getLineaId(), "Habilitar") }}
                            {%endif%}
                        </td>
                    {% else %}
                        <td> sin acceso</td>
                        <td> sin acceso</td>
                    {% endif %}
                    {% if linea.getLineaHabilitado() == 1 %}
                        <td class="bg-green-active"><i class="fa fa-check-circle-o"></i></td>
                    {% else %}
                        <td class="bg-red-active"><i class="fa fa-remove"></i></td>
                    {% endif %}
                </tr>
            {% endfor %}
        {% endif %}

        </tbody>
        {{ link_to("linea/search", "Primera",'class':'btn btn-flat btn-primary') }}
        {{ link_to("linea/search?page="~page.before, "Anterior",'class':'btn btn-flat btn-primary') }}
        <a class="btn btn-flat bg-blue-gradient"> {{ page.current~"/"~page.total_pages }} </a>
        {{ link_to("linea/search?page="~page.next, "Siguiente",'class':'btn btn-flat btn-primary') }}
        {{ link_to("linea/search?page="~page.last, "Ultima",'class':'btn btn-flat btn-primary') }}
        <hr>
    </table>
</div>


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
                            <p>Recuerde que la Linea eliminada no podrá ser utilizado nuevamente.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ form('linea/eliminar','method':'POST') }}
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

<!--=========== Agregar Linea ================-->
<div id="agregarLinea" class="modal fade modal-primary">

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

                        {{ form('linea/agregarCCALinea', "method":"post" ,"id":"guardarLinea") }}

                        {{ hidden_field('centroCosto_lineaId') }}

                        <label for="centroCosto_codigo">Nombre del Centro de Costo</label>

                        <div class="form-group">
                            {{ text_field("centroCosto_codigo", "size" : 50,'class':'form-control','required':'true','placeholder':'INGRESAR EL CODIGO') }}
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
<!--=========== FIN:Agregar Linea ================-->
<script>
    function setearHiddenClienteId(linea_id) {
        document.getElementById("centroCosto_lineaId").value = linea_id;
    }
    /**
     * Realiza una llamada ajax para guardar los datos de una linea para un cliente seleccionado
     */
    $('#guardarLinea').submit(function (event) {
        $('.help-block').remove(); // Limpieza de los mensajes de alerta.

        var datos = {
            'centroCosto_lineaId': $('#centroCosto_lineaId').val(),
            'centroCosto_codigo': $('#centroCosto_codigo').val()
        };

        $.ajax({
            type: 'POST',
            url: '/sya/centrocosto/agregarCCALinea',
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
                        document.getElementById("centroCosto_codigo").value = "";

                    }
                })
                .fail(function (data) {
                    console.log(data);
                });
        event.preventDefault();
    });

</script>