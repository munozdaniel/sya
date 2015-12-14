<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Listado de Planillas</h3>

                    <table width="100%">
                        <tr>
                            <td align="left">
                                {{ link_to("planilla/index", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
                            </td>
                            <td align="right">
                                {{ link_to("planilla/new", "CREAR ",'class':'btn btn-flat btn-large btn-danger') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-header -->
                {{ content() }}
                <div class="box-body">
                    <table id="id_planilla" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>N° de Planilla</th>
                            <th>Nombre del Cliente</th>
                            <th>Fecha de Creación</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            <th style="width: 10px;">EST</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% if page.items is defined %}
                            {% for planilla in page.items %}
                                <tr>
                                    <td>{{ planilla.getPlanillaId() }}</td>
                                    <td>{{ planilla.getPlanillaNombrecliente() }}</td>
                                    <td>{{ planilla.getPlanillaFecha() }}</td>

                                    {% if admin == 1 %}
                                    <td>{{ link_to("planilla/edit/"~planilla.getPlanillaId(), "Editar") }}</td>
                                    <td>
                                        <a href="#confirmarEliminar" role="button" class="" data-toggle="modal">Eliminar</a>
                                    </td>
                                    {% else %}
                                    <td> sin acceso </td>
                                    <td> sin acceso </td>
                                    {% endif %}
                                    {% if planilla.getPlanillaHabilitado() == 1 %}
                                        <td class="bg-green-active"><i class="fa fa-check-circle-o"></i></td>
                                    {% else %}
                                        <td class="bg-red-active"><i class="fa fa-remove"></i></td>
                                    {% endif %}
                                </tr>
                            {% endfor %}
                        {% endif %}
                        </tbody>
                        {#
                        <tbody>
                        <tr>
                            <td colspan="2" align="right">
                                <table align="center">
                                    <tr>
                                        <td>{{ link_to("planilla/search", "First") }}</td>
                                        <td>{{ link_to("planilla/search?page="~page.before, "Previous") }}</td>
                                        <td>{{ link_to("planilla/search?page="~page.next, "Next") }}</td>
                                        <td>{{ link_to("planilla/search?page="~page.last, "Last") }}</td>
                                        <td>{{ page.current~"/"~page.total_pages }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        </tbody>#}
                        <tfoot>
                        <tr>
                            <th>N° de Planilla</th>
                            <th>Nombre del Cliente</th>
                            <th>Fecha de Creación</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            <th style="width: 10px;">EST</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


    <!--=========== ConfirmarEliminar ================-->
    <div id="confirmarEliminar" class="modal fade modal-danger">

            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa   fa-hand-stop-o"></i> CONFIRMACIÓN</h4>
                </div>
                <div class="modal-body margin-left-right-one"style="border-left: 0 !important; border-right: 0 !important;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 ">
                            <!-- START SUBSCRIBE HEADING -->
                            <div class="heading">
                                <h2 class="wow fadeInLeftBig">Esta seguro de continuar con la eliminación? </h2>
                                <p>Recuerde que se eliminarán todas las ordenes ligadas a la planilla.</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                    {{ link_to("planilla/delete/"~planilla.getPlanillaId(), "Eliminar", 'type':'button','class':'btn btn-outline') }}
                </div>
            </div>
        </div>
    </div>
    <!--=========== FIN:ConfirmarEliminar ================-->
</section><!-- /.content -->

