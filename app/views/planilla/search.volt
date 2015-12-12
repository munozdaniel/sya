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
                        </tr>
                        </thead>
                        <tbody>
                        {% if page.items is defined %}
                            {% for planilla in page.items %}
                                <tr>
                                    <td>{{ planilla.getPlanillaId() }}</td>
                                    <td>{{ planilla.getPlanillaNombrecliente() }}</td>
                                    <td>{{ planilla.getPlanillaFecha() }}</td>
                                    <td>{{ link_to("planilla/edit/"~planilla.getPlanillaId(), "Editar") }}</td>
                                    <td>{{ link_to("planilla/delete/"~planilla.getPlanillaId(), "Eliminar") }}</td>
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
</section><!-- /.content -->