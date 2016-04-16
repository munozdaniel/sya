{#=============================================================================================================#}
<div class=" box-">
    <!-- Cuerpo -->
    <div class="box-body">
        <div class="form-group">
            <div class="col-sm-12">
                <div id="mensajes-alertas">
                    {# Genera alertas #}
                    {{ content() }}
                </div>
            </div>
        </div>
        <div id="pnl_planilla" class="col-xs-12 col-md-12">
            {# Datos de la planilla. btm: Eliminar, Editar #}
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active">
                        <h3 class="widget-user-username">{{ planilla.getPlanillaNombreCliente() }}</h3>
                    </div>

                    <div class="col-md-12">

                        <div class="nav-tabs-custom">


                            <div class="tab-content">
                                {{ link_to("index/dashboard", "<i class='fa fa-home'></i> Tablero Principal",
                                'class':'btn btn-flat btn-google pull-left') }}
                                {{ link_to("planilla/search", "<i class='fa fa-list'></i> Ver todas las planillas",
                                'class':'btn btn-flat bg-olive pull-left') }}<br>

                                <div class="tab-pane active" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <br>
                                            <span class="username">
                                                <a href="#">INFORMACIÓN GENERAL</a>
                                                <a href="#" class="pull-right btn-box-tool">
                                                    {% if planilla.getPlanillaHabilitado() == 1 %}
                                                        <a href="#confirmarEliminar" role="button" class="enviar-dato pull-right btn btn-flat bg-red-gradient" data-toggle="modal" data-id="{{  planilla.getPlanillaId() }}"><i class="fa fa-remove"></i></a>
                                                    {% else %}
                                                        {{ link_to('planilla/habilitar/'~planilla.getPlanillaId(),'<i class="fa fa-check-square-o"></i>  ','class':' pull-right btn btn-flat bg-green-gradient','title':'HABILITAR PLANILLA') }}
                                                    {% endif %}
                                                    {{ link_to('planilla/edit/'~planilla.getPlanillaId(),'<i class="fa fa-pencil"></i>  ','class':'pull-right btn btn-flat bg-light-blue-gradient','title':'EDITAR PLANILLA') }}
                                                </a>
                                            </span>
                                            <hr>

                                            <div class="row invoice-info">

                                                <div class="col-sm-8 invoice-col">
                                                    <dl class="dl-horizontal">
                                                        <dt>Nombre de la Planilla</dt>
                                                        <dd class="text-align-left">{{ planilla.getPlanillaNombreCliente() }}</dd>
                                                        <dt>Fecha de Creación</dt>
                                                        <dd class="text-align-left">{{ planilla.getPlanillaFecha() }}</dd>
                                                        <dt>Contiene Cabecera</dt>
                                                        <dd class="text-align-left">{% if planilla.getCabecera() != null  %}SI{% else %}NO{% endif %}</dd>
                                                        <dt>Cantidad de Remitos</dt>
                                                        <dd class="text-align-left">{{ planilla.getCantidadDeRemitos(planilla.getPlanillaId()) }}</dd>
                                                        <dt>Habilitada</dt>
                                                        <dd class="text-align-left">{% if planilla.getPlanillaHabilitado() == 0 %}NO{% else %}SI{% endif %}</dd>

                                                    </dl>
                                                </div>
                                                <div class="col-sm-12 invoice-col" align="left">
                                                    {% if planilla.getPlanillaHabilitado() == 0 %}
                                                        <div class="callout callout-danger">
                                                            <h4>Advertencia</h4>
                                                            <p>La planilla no se encuentra habilitada.</p>
                                                        </div>
                                                    {% else %}
                                                        <div class="col-sm-12 invoice-col">
                                                            {% if planilla.getPlanillaFinalizada() == 1 %}
                                                                <div class="callout callout-warning">
                                                                    <h4>Advertencia</h4>

                                                                    <p>La planilla no permite agregar nuevos remitos.</p>
                                                                </div>
                                                            {% elseif planilla.getPlanillaHabilitado() == 1 OR planilla.getCabecera()!=null %}
                                                                {{ link_to('remito/agregar/'~planilla.getPlanillaId(),'Agregar Remito','class':'btn btn-flat bg-light-blue-gradient','title':'AGREGAR UN NUEVO REMITO') }}
                                                            {% endif %}
                                                        </div>
                                                    {% endif %}
                                                </div>
                                            </div>
                                            <div class="row invoice-info">

                                                <!-- /.col -->
                                                <div class="col-sm-12 invoice-col" align="left">
                                                    <hr>
                                                <span class="username">
                                                    <a href="#">CABECERA</a>
                                               </span>
                                                    {% if planilla.getPlanillaArmada() == 0 %}
                                                        <div class="callout callout-danger">
                                                            <h4>Advertencia</h4>

                                                            <p>La planilla no tiene asignado una cabecera.</p>
                                                            {% if planilla.getPlanillaHabilitado() != 0 %}
                                                                {{ link_to('cabecera/asignarCabecera/'~planilla.getPlanillaId(),'Asignar Cabecera','class':'btn btn-flat bg-red-gradient','SELECCIONAR UNA CABECERA') }}
                                                                {{ link_to('cabecera/nuevaCabecera/'~planilla.getPlanillaId(),'Nueva Cabecera','class':'btn btn-flat bg-red-gradient','AGREGAR UNA NUEVA CABECERA') }}
                                                            {% endif %}
                                                        </div>
                                                    {% else %}
                                                        <div class="col-md-12">
                                                            {{ link_to('cabecera/quitar/'~planilla.getPlanillaId(),'<i class="fa fa-remove"></i>  ','class':'pull-right btn btn-flat bg-red-gradient','title':'QUITAR CABECERA') }}
                                                            <p>{{ planilla.getCabecera().getCabeceraNombre() }}</p>

                                                        </div>

                                                    {% endif %}
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-12 invoice-col" align="left">
                                                    <hr>
                                                    <span class="username">
                                                        <a href="#">COLUMNAS</a>
                                                    </span>

                                                    {% if planilla.getCabecera() == null %}
                                                        <div class="callout callout-danger">
                                                            <h4>Advertencia</h4>

                                                            <p>Para poder trabajar con las columnas la planilla deberá tener asignada una cabecera.</p>
                                                        </div>
                                                    {% else %}
                                                        <div class="col-md-3">
                                                            <p><strong><ins>Operaciones</ins></strong></p>
                                                            {% if planilla.getPlanillaHabilitado() != 0 %}

                                                            {{ link_to('cabecera/reordenar','Reordenar','class':'btn btn-flat bg-light-blue-gradient btn-block','title':'REORDENAR LAS COLUMNAS') }}
                                                            <hr>
                                                            {{ link_to('columna/agregarExtra/'~planilla.getPlanillaId(),'Agregar Extra','class':'btn btn-flat bg-light-blue-gradient btn-block','title':'AGREGAR UNA COLUMNA EXTRA A LA CABECERA') }}
                                                            <hr>
                                                            {{ link_to('columna/editar/'~planilla.getPlanillaId(),'Habilitar/Deshabilitar','class':'btn btn-flat bg-light-blue-gradient btn-block','title':'HABILITAR/DESHABILITAR UNA COLUMNA') }}
                                                            {% endif %}

                                                        </div>
                                                        <div class="col-md-6" align="center" >

                                                            <p><strong><ins>Habilitadas</ins></strong></p>
                                                            <ol>
                                                                    {% for columna in planilla.getCabecera().getTodasLasColumnasHabilitadas(planilla.getPlanillaCabeceraId()) %}
                                                                            <div class="col-md-6" style="background-color: rgba(178, 178, 178, 0.16)">
                                                                        <li>{{ columna.getColumnaNombre() }}</li>
                                                                            </div>
                                                                    {% endfor %}
                                                                </ol>
                                                        </div>
                                                        <div class="col-md-3" >

                                                                <p><strong><ins>Deshabilitadas</ins></strong></p>
                                                                <ol>

                                                                    {% for columna in planilla.getCabecera().getTodasLasColumnasDeshabilitadas(planilla.getPlanillaCabeceraId()) %}
                                                                        <li class="text-danger">{{ columna.getColumnaNombre() }}</li>
                                                                    {% endfor %}

                                                                </ol>
                                                        </div>
                                                    {% endif %}
                                                </div>
                                                <!-- /.col -->

                                            </div>
                                        </div>
                                        <!-- /.user-block -->
                                    </div>
                                    <!-- /.post -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- ====================================== -->


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
                {{ end_form() }}
            </div>
        </div>
    </div>
</div>
<!--=========== FIN:ConfirmarEliminar ================-->