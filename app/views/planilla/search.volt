<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Listado de Planillas</h3>

        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("planilla/index", "<i class='fa fa-search'></i> Busqueda Personalizada",'class':'btn btn-flat btn-large bg-olive') }}
                </td>
                <td align="right">

                    {{ link_to("planilla/new", "<i class='fa fa-plus-square'></i> Nueva Planilla ",'class':'btn btn-flat btn-large btn-danger') }}
                </td>
            </tr>
        </table>
    </div>
    <!-- /.box-header -->
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
               data-toolbar="#toolbar"
               data-show-columns="true"
               data-search="true"
               data-show-toggle="false"{# Cambia de vista cada celda#}
               data-pagination="true"
               data-reorderable-columns="true"
               data-show-export="true"
               data-click-to-select="true"
               data-row-style="rowStyle"
               class="table table-bordered table-striped">
            <thead>
            <tr>

                <th data-field="state" data-checkbox="true"></th>
                <th data-field="Nro" data-sortable="true">#</th>
                <th data-field="dominio" data-sortable="true">Nombre de Planilla</th>
                <th data-field="interno" data-sortable="true">Fecha de Creación</th>
                <th data-sortable="true" align="center">Ordenes</th>
                <th data-sortable="true" data-halign="center" data-align="center">Administrar</th>
            </tr>

            </thead>
            <tbody>
            {% if page.items is defined %}
                {% for planilla in page.items %}
                    <tr>
                        <td>X</td>
                        <td>{{ planilla.getPlanillaId() }}</td>
                        <td>{{ planilla.getPlanillaNombrecliente() }}</td>
                        <td>{{ planilla.getPlanillaFecha() }}</td>
                        <td>{{ link_to("orden/verOrdenes/"~planilla.getPlanillaId(), "Ver Ordenes",'class':'btn-flat btn btn-block btn-github') }}</td>

                        {% if admin == 1 %}
                            {% if planilla.getPlanillaHabilitado() == 1 %}
                                <td class="">
                                    {{ link_to("planilla/edit/"~planilla.getPlanillaId(), "<i class='fa fa-pencil'></i>",'class':'btn btn-flat  bg-light-blue-gradient','title':'EDITAR') }}
                                    <a href="#confirmarEliminar" role="button"
                                       class="enviar-dato btn bg-red-gradient btn-flat" title="ELIMINAR"
                                       data-toggle="modal" data-id="{{ planilla.getPlanillaId() }}"><i
                                                class='fa fa-trash'></i></a>
                                </td>
                            {% else %}
                                <td class="alert-danger">
                                    {{ link_to("planilla/habilitar/"~planilla.getPlanillaId(), "<ins>HABILITAR</ins>",'class':' font-white','title':'HABILITAR') }}
                                </td>
                            {% endif %}

                        {% else %}
                            <td>
                                <a class="btn btn-flat bg-gray" title="SIN ACCESO"><i
                                            class='fa fa-exclamation-circle'></i></a>
                            </td>

                        {% endif %}


                    </tr>
                {% endfor %}
            {% endif %}
            </tbody>
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

                                <p>Recuerde que la planilla eliminada no podrá ser utilizada nuevamente.</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                    {{ form('planilla/eliminar','method':'POST') }}
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

</div>