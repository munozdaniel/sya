<!-- Titulo -->
<div class="box-header">
    <h3 class="box-title">Listado de Transportes</h3>

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("transporte", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
            <td align="right">
                {{ link_to("transporte/new", "Nuevo Transporte",'class':'btn btn-large btn-danger btn-flat') }}
            </td>
        </tr>
    </table>
</div>
<!-- ./ Titulo -->
{{ content() }}

<div class="box-body">
    <div id="toolbar">
        <label>
            <select class="form-control">
                <option value="">Exportar Pagina</option>
                <option value="all">Exportar Todo</option>
                <option value="selected">Exportar Seleccionados</option>
            </select>
        </label>
        <button id="botonTop" class="btn btn-flat bg-olive">Subir</button>
        <button id="botonBottom" class="btn btn-flat bg-olive">Bajar</button>
    </div>
    <table id="tabla"
           data-show-pagination-switch="true"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-escape="false"{# Para usar html en las celdas#}
           data-show-refresh="true"
           data-toggle="table"
           data-show-columns="true"
           data-search="true"
           data-show-toggle="false"{# Cambia de vista cada celda#}
           data-pagination="true"
           data-reorderable-columns="true"
           data-show-export="true"
           data-click-to-select="true"
           data-toolbar="#toolbar"
           class="table table-bordered table-striped">
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-field="Nro" data-sortable="true">N° Transporte</th>
            <th data-field="dominio" data-sortable="true">Dominio</th>
            <th data-field="interno" data-sortable="true">N° de Interno</th>
            <th data-sortable="true">Editar</th>
            <th  data-sortable="true">Eliminar</th>
            <th  data-sortable="true" style="width: 10px;">EST</th>
        </tr>

        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for transporte in page.items %}
                <tr data-index="{{ transporte.getTransporteId()}}">
                    <td>X</td>
                    <td>{{ transporte.getTransporteId() }}</td>
                    <td>{{ transporte.getTransporteDominio() }}</td>
                    <td>{{ transporte.getTransporteNrointerno() }}</td>

                    {% if admin == 1 %}
                        <td>{{ link_to("transporte/edit/"~transporte.getTransporteId(), "Editar") }}</td>
                        {% if transporte.getTransporteHabilitado() == 1 %}
                            <td>
                                <a href="#confirmarEliminar" role="button" class="enviar-dato" data-toggle="modal"
                                   data-id="{{  transporte.getTransporteId() }}">Eliminar</a>
                            </td>
                        {% else %}
                            <td>{{ link_to("transporte/habilitar/"~transporte.getTransporteId(), "Habilitar") }}</td>
                        {%endif%}
                    {% else %}
                        <td> sin acceso</td>
                        <td> sin acceso</td>
                    {% endif %}
                    {% if transporte.getTransporteHabilitado() == 1 %}
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
                            <p>Recuerde que el transporte eliminado no podrá ser utilizado nuevamente.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ form('transporte/eliminar','method':'POST') }}
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
