<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Listado de Planillas</h3>

        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("index", "<i class='fa fa-home'></i> Tablero Principal",'class':'btn btn-flat btn-large btn-danger') }}
                </td>
                <td align="right">
                    {{ link_to("planilla/index", "<i class='fa fa-search'></i> Busqueda Personalizada",'class':'btn btn-flat btn-large bg-olive') }}
                    {{ link_to("planilla/new", "<i class='fa fa-plus-square'></i> Nueva Planilla ",'class':'btn btn-flat btn-large btn-danger') }}
                </td>
            </tr>
        </table>
    </div>
    <!-- /.box-header -->
    {{ content() }}

    <div class="box-body">
        <table id="tabla"
               data-show-pagination-switch="true"
               data-page-list="[10, 25, 50, 100, ALL]"
               data-escape="false"{# Para usar html en las celdas#}
               data-show-refresh="true"
               data-toggle="table"
               data-show-columns="true"
               data-cookie="true"
               data-cookie-id-table="tabla"
               data-search="true"
               data-pagination="true"
               data-reorderable-columns="true"
               data-click-to-select="true"
               data-row-style="rowStyle"
               class="table table-bordered table-striped">
            <thead>
            <tr>

                <th data-field="state" data-checkbox="true"></th>
                <th data-field="Nro" data-sortable="true">#</th>
                <th data-field="dominio" data-sortable="true" data-halign="center" >Nombre de Planilla</th>
                <th data-field="interno" data-sortable="true" data-halign="center" data-align="center">Fecha de Creación</th>
                <th data-field="estado" data-sortable="true" data-halign="center" data-align="left">Estado</th>
                <th data-field="cabecera" data-sortable="true" data-halign="center" data-align="center">Administración</th>
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
                        <td>{# Estado: Habilitado?Cabecera?Finalizado?OK #}
                            {% if planilla.getPlanillaHabilitado()==0 %}
                                <a class="btn btn-flat btn-block "><i class="fa fa-stas"></i> DESHABILITADA </a>
                            {% elseif  planilla.getCabecera() == null%}
                                <a class="btn btn-flat btn-block "><i class="fa fa-sas-caso"></i> SIN CABECERA</a>
                            {% elseif planilla.getPlanillaFinalizada() %}
                                <a class="btn btn-flat btn-block "><i class="fa fa-stopas-circle-o"></i> CERRADA</a>
                            {% else %}
                                <a class="btn btn-flat btn-block  "><i class="fa fa-stop-cirascle-o"></i> HABILITADA</a>
                            {% endif %}
                        </td>
                        <td> {{ link_to('planilla/view/'~planilla.getPlanillaId(),'<i class="fa fa-desktop"></i> ABRIR',
                            'class':'btn btn-flat   bg-light-blue-gradient btn-block','title':'Abrir para administrar la planilla') }}
                        </td>
                    </tr>
                {% endfor %}
            {% endif %}
            </tbody>
        </table>
    </div>


    <!--=========== ConfirmarEliminar ================-->
    <div id="confirmarEliminar" class="modal fade modal-danger ">

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

    <!--=========== Administrar Columnas ================-->
    <div id="administrar_columnas" class="modal fade modal-primary">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa   fa-hand-stop-o"></i> ADMINISTRAR COLUMNAS</h4>
                </div>
                <div class="modal-body margin-left-right-one"
                     style="border-left: 0 !important; border-right: 0 !important;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 ">
                            <!-- START SUBSCRIBE HEADING -->
                            <div class="heading">
                                <h2 class="wow fadeInLeftBig">Seleccione la opción que desee para administrar las columnas de la planilla</h2>
                                <p></p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                    {{ form('equipopozo/eliminar','method':'POST') }}
                    <div  id="cuerpo">
                        {{ hidden_field('id','value':'','form') }}
                        {{ submit_button('Eliminar','class':'btn btn-outline') }}
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--=========== FIN:Administrar Columnas ================-->

</div>