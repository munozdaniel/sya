<!-- Titulo -->
<div class="box-header">
    <h3 class="box-title">Listado de Choferes</h3>

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("chofer", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
            <td align="right">
                {{ link_to("chofer/new", "Nuevo Chofer",'class':'btn btn-large btn-danger btn-flat') }}
            </td>
        </tr>
    </table>
</div>
<!-- ./ Titulo -->
{{ content() }}
<script>
    $(document).ready(function () {
        $('#tabla_id').DataTable( {
            "scrollX": true
        } );
    });
</script>
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
            <th data-field="nombre" data-sortable="true" data-halign="center" data-align="center">Nombre Completo</th>
            <th data-field="dni" data-sortable="true" data-halign="center" data-align="center">Nro Documento</th>
            <th data-field="fletero" data-sortable="true" data-halign="center" data-align="center">Es Fletero?</th>
            <th data-field="editar" data-sortable="true" data-halign="center" data-align="center">Editar</th>
            <th data-field="eliminar" data-sortable="true" data-halign="center" data-align="center">Eliminar</th>
            <th data-field="estado" style="width: 10px;" data-sortable="true" data-halign="center"
                data-align="center">EST
            </th>
        </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for chofer in page.items %}
                <tr>
                    <td>{{ chofer.getChoferId() }}</td>
                    <td>{{ chofer.getChoferNombrecompleto() }}</td>
                    <td>{{ chofer.getChoferDni() }}</td>
                    <td>{% if chofer.getChoferEsfletero()== 0%} NO {% else %} SI {% endif %}</td>
                    {% if admin == 1 %}
                        <td>{{ link_to("chofer/edit/"~chofer.getChoferId(), "Editar") }}</td>
                            {% if chofer.getChoferHabilitado() == 1 %}
                                <td><a href="#confirmarEliminar" role="button" class="enviar-dato" data-toggle="modal" data-id="{{  chofer.getChoferId() }}">Eliminar</a></td>
                            {% else %}
                                <td>{{ link_to("chofer/habilitar/"~chofer.getChoferId(), "Habilitar") }}</td>
                            {%endif%}
                    {% else %}
                        <td> sin acceso</td>
                        <td> sin acceso</td>
                    {% endif %}
                    {% if chofer.getChoferHabilitado() == 1 %}
                        <td class="bg-green-active"><i class="fa fa-check-circle-o"></i></td>
                    {% else %}
                        <td class="bg-red-active"><i class="fa fa-remove"></i></td>
                    {% endif %}
                </tr>
            {% endfor %}
        {% endif %}
        </tbody>
        {{ link_to("chofer/search", "Primera",'class':'btn btn-flat btn-primary') }}
        {{ link_to("chofer/search?page="~page.before, "Anterior",'class':'btn btn-flat btn-primary') }}
        <a class="btn btn-flat bg-blue-gradient"> {{ page.current~"/"~page.total_pages }} </a>
        {{ link_to("chofer/search?page="~page.next, "Siguiente",'class':'btn btn-flat btn-primary') }}
        {{ link_to("chofer/search?page="~page.last, "Ultima",'class':'btn btn-flat btn-primary') }}
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
                            <p>Recuerde que el Chofer eliminado no podrá ser utilizado nuevamente.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ form('chofer/eliminar','method':'POST') }}
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

