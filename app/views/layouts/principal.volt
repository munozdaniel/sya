<!-- Navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <div class="hidden-lg pull-right">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-right">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-chevron-down"></i>
                </button>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                    <span class="sr-only">Toggle sidebar</span>
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <!-- ======================= MENU DEL USUARIO ======================= -->
            {{ elemento.getUsuario() }}

        </div>
        <!-- ======================= MENU SUPERIOR DERECHO ======================= -->
        <ul class="nav navbar-nav navbar-right collapse" id="navbar-right">
            <li>
                <a href="#">
                    <i class="fa fa-rotate-right"></i>
                    <span>Actualizaciones</span>
                    <strong class="label label-danger">15</strong>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-comments"></i>
                    <span>Mensajes</span>
                    <strong class="label label-danger">7</strong>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa fa-tasks"></i>
                    <span>Notificaciones</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /navbar -->


<!-- ======================= MENU SECUNDARIO SIMPLE ======================= -->
{#
<div class="container">
    <div class="page-header">
        <div class="logo"><a href="index.html" title=""><img src="images/logo.png" alt=""></a></div>
        <ul class="middle-nav">
            <li><a href="#" class="btn btn-default"><i class="fa fa-comments-o"></i> <span>Support tickets</span></a><div class="label label-info">9</div></li>
            <li><a href="#" class="btn btn-default"><i class="fa fa-bars"></i> <span>Statistics</span></a></li>
            <li><a href="#" class="btn btn-default"><i class="fa fa-male"></i> <span>User list</span></a></li>
            <li><a href="#" class="btn btn-default"><i class="fa fa-money"></i> <span>Billing panel</span></a></li>
        </ul>
    </div>
</div>
#}
<!-- ======================= FIN: MENU SECUNDARIO SIMPLE ======================= -->


<!-- Page container -->
<div class="page-container container margin-top-section">

    <!-- ======================= MENU PRIMARIO LATERAL IZQUIERDO ======================= -->
    <div class="sidebar collapse">
        <ul class="navigation">
            <li><a href="index.html"><i class="fa fa-laptop"></i> Dashboard</a></li>
            <li class="active">
                <a href="#" class="expand" id="second-level"><i class="fa fa-copy"></i> Blank pages <span class="label label-info">6</span></a>
                <ul>
                    <li class="active"><a href="blank_fixed_navbar.html">Fixed navbar</a></li>
                    <li><a href="blank_static_navbar.html">Static navbar</a></li>
                    <li><a href="blank_collapsed_sidebar.html">Collapsed sidebar</a></li>
                    <li><a href="blank_full_width.html">Full width page</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- ======================= FIN: MENU PRIMARIO LATERAL IZQUIERDO ======================= -->


    <!-- Page content -->
    <div class="page-content">

        {{ content() }}

        <!-- Footer -->
        <div class="footer">
            &copy; Copyright 2015. Todos los derechos reservados.
        </div>
        <!-- /footer -->
    </div>
    <!-- /page content -->

</div>
<!-- page container -->