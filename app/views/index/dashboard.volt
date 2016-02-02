<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <i class="fa  fa-dashcube"></i> <ins>Tablero Principal</ins>
        <small>Seleccione una opción para comenzar </small>
    </h1>
    <hr>
</section>

<!-- ===================== Main content =====================-->
<section class="content">
    {{ content() }}
    <div class="row">
        <div class="col-md-12">
            <div class="box-header with-border">
                <i class="fa fa-table"></i>

                <h3 class="box-title">Planillas</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">

                <!-- /.box-header -->
                <div class="box-body">
                    {{ link_to('planilla','
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-list"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-black"><strong>VER TODAS LAS PLANILLAS</strong></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description  text-black">
                                Realiza una busqueda general.
                            </span>
                        </div>
                    </div>
                    ') }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    {{ link_to('planilla/new','
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-plus-square"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-black"><strong>NUEVA PLANILLA</strong></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description  text-black">
                                Formulario de creación.
                            </span>
                        </div>
                    </div>
                    ') }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    {{ link_to('planilla/search','
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-search"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-black"><strong>BUSCAR PLANILLA</strong></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description  text-black">
                                Filtro personalizado.
                            </span>
                        </div>
                    </div>
                    ') }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
        <div class="col-md-12">
            <div class="box-header with-border">
                <i class="fa fa-file-text"></i>
                <h3 class="box-title">Remitos</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    {{ link_to('orden/search','
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-search"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-black"><strong>VER TODOS LOS REMITOS</strong></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description  text-black">
                                Todos los remitos sin filtro.
                            </span>
                        </div>
                    </div>
                    ') }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    {{ link_to('orden/new','
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-plus-square"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-black"><strong>NUEVO REMITO</strong></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description  text-black">
                                Agregar remito a la planilla.
                            </span>
                        </div>
                    </div>
                    ') }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    {{ link_to('orden','
                    <div class="info-box">
                        <span class="info-box-icon bg-light-blue-gradient"><i class="fa fa-plus-square"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text text-black"><strong>BUSCAR REMITO</strong></span>

                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description  text-black">
                                Filtro personalizado.
                            </span>
                        </div>
                    </div>
                    ') }}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
