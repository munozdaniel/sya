<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><strong>CREAR NUEVA PLANILLA</strong></h3>
    </div>
    <!-- /.Titulo -->
    <!-- Formulario -->

    {{ content() }}
    <table width="100%">
        <tr>
            <td align="right">
                {{ link_to("planilla/index", "<i class='fa fa-search'></i> Busqueda Personalizada",'class':'btn btn-flat btn-large bg-olive') }}
            </td>
        </tr>
    </table>
    <!-- Cuerpo -->
    <div class="box-body">
        <!-- =================================================================================
        <div class="col-xs-12 col-md-12">
            <div class="box-body" style="margin-top: 25px !important;">
                <dl class="dl-horizontal">
                    <dt>DESCRIPCIÓN</dt>
                    <dd></dd>
                    <dt>Paso 1:</dt>
                    <dd style="text-align: left !important;">Asignar un nombre a la planilla.</dd>
                    <dt>Paso 2:</dt>
                    <dd style="text-align: left !important;">Agregar todas las columnas requeridas.</dd>
                    <dt>Paso 3:</dt>
                    <dd style="text-align: left !important;"> Reordenar las columnas para las planillas Excel.</dd>
                </dl>
            </div>
        </div>-->
        {{ partial('planilla/parcial/planilla') }}

        <!-- ================================================================================= -->
        <div class="col-xs-12 col-md-12">
            <hr>
        </div>
        <!-- ================================================================================= -->
        <div id="id_nuevaCabecera">
            <div class="col-xs-12 col-md-12">
               {{ partial('planilla/parcial/extra') }}
            </div>
            <!-- ================================================================================= -->
            <div class="col-xs-12 col-md-12">
             {{ partial('planilla/parcial/ordenar') }}
            </div>
        </div>
        <!-- ================================================================================= -->
        <div id="id_cabeceraExistente" class="col-xs-12 col-md-12 ocultar">
            {{ partial('planilla/parcial/seleccion') }}
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- ====================================== -->
