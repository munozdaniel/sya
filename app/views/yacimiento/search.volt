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
    <table id="tabla_id" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>N° Yacimiento</th>
            <th>Destino</th>
            <th>Editar</th>
            <th>Eliminar</th>
            <th style="width: 10px;">EST</th>
        </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for yacimiento in page.items %}
                <tr>
                    <td>{{ yacimiento.getYacimientoId() }}</td>
                    <td>{{ yacimiento.getYacimientoDestino() }}</td>
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
