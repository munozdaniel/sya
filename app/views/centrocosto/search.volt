<!-- Titulo -->
<div class="box-header">
    <h3 class="box-title">Listado Centro Costo</h3>

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("centrocosto/index", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
            <td align="right">
                {{ link_to("centrocosto/new", "Nuevo Centro de Costo",'class':'btn btn-flat btn-large btn-danger') }}
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
            <th data-field="codigo" data-sortable="true" data-halign="center" data-align="center">Codigo</th>
            <th data-field="linea" data-sortable="true" data-halign="center" data-align="center">Linea</th>
            <th data-field="editar" data-sortable="true" data-halign="center" data-align="center">Editar</th>
            <th data-field="eliminar" data-sortable="true" data-halign="center" data-align="center">Eliminar</th>
            <th data-field="estado" style="width: 10px;" data-sortable="true" data-halign="center"
                data-align="center">EST
            </th>
        </tr>

        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for centrocosto in page.items %}
                <tr>
                    <td>{{ centrocosto.getCentrocostoId() }}</td>
                    <td>{{ centrocosto.getCentrocostoCodigo() }}</td>
                    <td>{{ link_to('linea/buscarLineaPorId/?linea_id='~centrocosto.getLinea().getLineaId(),""~centrocosto.getLinea().getLineaNombre(),'class':'btn btn-flat bg-light-blue-gradient btn-block') }}</td>
                    {% if admin == 1 %}
                        <td>{{ link_to("centrocosto/edit/"~centrocosto.getCentrocostoId(), "Editar") }}</td>
                        <td>
                            {% if centrocosto.getCentrocostoHabilitado() == 1 %}
                                <a href="#confirmarEliminar" role="button" class="enviar-dato" data-toggle="modal"
                                   data-id="{{ centrocosto.getCentrocostoId() }}">Eliminar</a>
                            {% else %}
                                {{ link_to("centrocosto/habilitar/"~centrocosto.getCentrocostoId(), "Habilitar") }}
                            {% endif %}
                        </td>
                    {% else %}
                        <td> sin acceso</td>
                        <td> sin acceso</td>
                    {% endif %}
                    {% if centrocosto.getCentrocostoHabilitado() == 1 %}
                        <td class="bg-green-active"><i class="fa fa-check-circle-o"></i></td>
                    {% else %}
                        <td class="bg-red-active"><i class="fa fa-remove"></i></td>
                    {% endif %}
                </tr>
            {% endfor %}
        {% endif %}
        </tbody>
        {{ link_to("centrocosto/search", "Primera",'class':'btn btn-flat btn-primary') }}
        {{ link_to("centrocosto/search?page="~page.before, "Anterior",'class':'btn btn-flat btn-primary') }}
        <a class="btn btn-flat bg-blue-gradient"> {{ page.current~"/"~page.total_pages }} </a>
        {{ link_to("centrocosto/search?page="~page.next, "Siguiente",'class':'btn btn-flat btn-primary') }}
        {{ link_to("centrocosto/search?page="~page.last, "Ultima",'class':'btn btn-flat btn-primary') }}
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

                            <p>Recuerde que el Centro Costo eliminado no podrá ser utilizado nuevamente.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ form('centrocosto/eliminar','method':'POST') }}
                <div id="cuerpo">
                    {{ hidden_field('id','value':'','form') }}
                    {{ submit_button('Eliminar','class':'btn btn-outline') }}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--=========== FIN:ConfirmarEliminar ================-->
