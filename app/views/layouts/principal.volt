<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>&A</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>s&a</b> ALL SERVICE</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {#elemento.getUsuario() #}
                            {{ image('files/perfil/default.jpg','class':'user-image','alt':'foto de perfil') }}
                            <span class="hidden-xs">Administrador Sya</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                {#elemento.getUsuarioDetalle() #}
                                {{ image('files/perfil/default.jpg','class':'img-circle','alt':'foto de perfil') }}
                                <p>
                                    Nombre de usuario
                                    <small>rol</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <!-- div class="pull-left">
                                    {# link_to('usuarios/verPerfil','Perfil','class':'btn btn-default btn-flat') #}
                                </div-->
                                <div class="pull-right">
                                    {{ link_to('sesion/cerrar','Salir','class':'btn btn-default btn-flat') }}
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">


            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MENÚ DE NAVEGACIÓN</li>
                {#====== ITEM SENCILLO =======#}
                <li>
                    {{ link_to('index/dashboard','<i class="fa fa-laptop"></i> <span>Inicio</span> ') }}
                </li>
                {#====== ITEM ARBOL =======#}
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Formularios</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('planilla/new','<i class="fa fa-circle-o"></i>  Crear Planilla') }}</li>
                        <li>{{ link_to('orden/new','<i class="fa fa-circle-o"></i>  Agregar Orden') }}</li>
                    </ul>
                </li>
                {#====== ITEM ARBOL =======#}
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Tablas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('planilla/buscarOrdenes','<i class="fa fa-circle-o"></i>  Buscar Planilla') }}</li>
                        <li>{{ link_to('planilla/exportarExcel','<i class="fa fa-circle-o"></i>  Exportar Excel') }}</li>
                    </ul>
                </li>
                {#====== ITEM ARBOL =======#}

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-search"></i> <span>Buscar</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('orden','<i class="fa fa-circle-o"></i> Busqueda Personalizada') }}</li>
                    </ul>
                </li>
                {#====== ITEM SENCILLO =======#}
                <li>
                    {{ link_to('index/dashboard','<i class="fa fa-pie-chart"></i> <span>Estadisticas</span> ') }}
                </li>
                {#====== ITEM SENCILLO =======#}
                <li>
                    {{ link_to('archivo','<i class="fa fa-upload"></i> <span>Almacenar en el Servidor</span> ') }}
                </li>
                {#====== ITEM ARBOL =======#}
                <li class="header">ADMINISTRADOR</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa  fa-user"></i>
                        <span>Gestionar</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li>{{ link_to('cliente','<i class="fa fa-circle-o"></i>  Cliente') }}</li>
                        <li>{{ link_to('frs','<i class="fa fa-circle-o"></i>  FRS') }}</li>
                        <li>{{ link_to('operadora','<i class="fa fa-circle-o"></i>  Operadora') }}</li>
                        <li>{{ link_to('centrocosto','<i class="fa fa-circle-o"></i>  Centro Costo') }}</li>
                        <li>{{ link_to('linea','<i class="fa fa-circle-o"></i>  Linea') }}</li>
                        <li>{{ link_to('equipopozo','<i class="fa fa-circle-o"></i>  Equipo/Pozo') }}</li>
                        <li>{{ link_to('yacimiento','<i class="fa fa-circle-o"></i>  Yacimiento') }}</li>
                        <li>{{ link_to('chofer','<i class="fa fa-circle-o"></i>  Chofer') }}</li>
                        <li>{{ link_to('transporte','<i class="fa fa-circle-o"></i>  Transporte') }}</li>
                        <li>{{ link_to('tipoequipo','<i class="fa fa-circle-o"></i>  Tipo Equipo') }}</li>
                        <li>{{ link_to('tipocarga','<i class="fa fa-circle-o"></i>  Tipo Carga') }}</li>
                        <li>{{ link_to('viaje','<i class="fa fa-circle-o"></i>  Viaje') }}</li>
                    </ul>
                </li>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{ content() }}
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong><a href="http://syaallservice.com">S&A All Service</a>.</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active">
                <a href="#calculadora-online" data-toggle="tab">
                    <i class="fa fa-calculator"></i>
                </a>
            </li>
            <li><a href="#gestion-usuarios" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">

            <!-- Stats tab content -->
            <div id="calculadora-online" class="tab-pane active">
                <div class="wrap">
                    <div class="cal">
                        <ul class="ctrls">
                            <li class="close"><a></a></li>
                            <li class="min"><a></a></li>
                            <li class="max"><a></a></li>
                        </ul>
                        <span class="title">REDEANDO</span>
                        <div class="screen"></div>
                        <input type="hidden" class="outcome" value="0" />
                        <ul class="buttons">
                            <li><a class="clear">C</a></li>
                            <li><a class="val" href="-">&plusmn;</a></li>
                            <li><a class="val" href="/">&divide;</a></li>
                            <li><a class="val" href="*">&times;</a></li>
                            <li><a class="val" href="7">7</a></li>
                            <li><a class="val" href="8">8</a></li>
                            <li><a class="val" href="9">9</a></li>
                            <li><a class="val" href="-">-</a></li>
                            <li><a class="val" href="4">4</a></li>
                            <li><a class="val" href="5">5</a></li>
                            <li><a class="val" href="6">6</a></li>
                            <li><a class="val" href="+">+</a></li>
                            <li><a class="val" href="1">1</a></li>
                            <li><a class="val" href="2">2</a></li>
                            <li><a class="val" href="3">3</a></li>
                            <li><a id='igual' class="equal tall">=</a></li>
                            <li><a id='cero' class="val wide shift" href="0">0</a></li>
                            <li><a id='decimal' class="val shift" href=".">.</a></li>
                        </ul>
                    </div></div>
            </div>
            <!-- Settings tab content -->
            <div class="tab-pane" id="gestion-usuarios">
                <form method="post">
                    <h3 class="control-sidebar-heading">Configuración de Usuario</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            {{ link_to('','Buscar usuario <i class="fa fa-toggle-right pull-right"></i>') }}
                        </label>

                        <p>
                            Busca los usuarios por diferentes criterios
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            {{ link_to('','Agregar usuario <i class="fa fa-toggle-right pull-right"></i>') }}
                        </label>

                        <p>
                            Ingresa un nuevo usuario al sistema.
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            {{ link_to('','Agregar permisos <i class="fa fa-toggle-right pull-right"></i>') }}
                        </label>

                        <p>
                            Vincula las paginas con los roles.
                        </p>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            {{ link_to('','Asignar rol <i class="fa fa-toggle-right pull-right"></i>') }}
                        </label>

                        <p>
                            Vincula al usuario con un rol especifico.
                        </p>
                    </div>
                    <!-- /.form-group -->

                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
