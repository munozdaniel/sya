<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <ins>Tablero Principal</ins>
    </h1>
</section>

<!-- ===================== Main content =====================-->
<section class="content">
    {{ content() }}
    <div class="row">
        <div align="center">
            {{ image('image/logo-portada.png','width':'420','height':'152') }}
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Planillas</h3>

                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding" style="display: block;">
                    <ul class="nav nav-pills nav-stacked">
                        <li>{{ link_to("planilla/search",'<i class="fa fa-circle-o text-light-blue"></i> Ver todas las planillas <span class="label label-primary pull-right">'~ cantidadPlanillas ~'</span>') }}</li>
                        <li>{{ link_to("planilla/new",'<i class="fa fa-circle-o text-light-blue"></i> Nueva planilla') }}</li>
                        <li>{{ link_to("planilla/index",'<i class="fa fa-circle-o text-light-blue"></i> Búsqueda Personalizada') }}</li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <div class="col-md-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Remitos</h3>

                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding" style="display: block;">
                    <ul class="nav nav-pills nav-stacked">
                        <li>{{ link_to("remito/nuevoRemitoPorPlanilla",'<i class="fa fa-circle-o text-yellow"></i> Nuevo remito') }}</li>
                        <li>{{ link_to("remito/buscarRemitoPorPlanilla",'<i class="fa fa-circle-o text-yellow"></i> Buscar remitos por planilla') }}</li>
                        <li>{{ link_to("remito/buscarRemitoPorNro",'<i class="fa fa-circle-o text-yellow"></i> Buscar Remito por NRO') }}</li>
                        <li>{{ link_to("remito/buscarRemitoEntreFechas",'<i class="fa fa-circle-o text-yellow"></i> Buscar Remitos entre fechas') }}</li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <div class="col-md-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Cabecera</h3>

                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding" style="display: block;">
                    <ul class="nav nav-pills nav-stacked">
                        <li>{{ link_to("cabecera/reordenar",'<i class="fa fa-circle-o text-red"></i>  Reordenar columnas ') }}</li>
                        <li>{{ link_to("columna/agregarExtra",'<i class="fa fa-circle-o text-red"></i>  Agregar columna extra') }}</li>
                        <li>{{ link_to("columna/editar",'<i class="fa fa-circle-o text-red"></i> Habilitar/Deshabilitar columnas') }}</li>

                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>

</section>
