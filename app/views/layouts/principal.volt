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

            <ul class="nav navbar-nav navbar-left-custom">
                <li class="user dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="http://placehold.it/500" alt="">
                        <span>Eugene Kopyov</span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                        <li><a href="#"><i class="fa fa-tasks"></i> Tasks</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                        <li><a href="#"><i class="fa fa-mail-forward"></i> Logout</a></li>
                    </ul>
                </li>
                <li><a class="nav-icon sidebar-toggle"><i class="fa fa-bars"></i></a></li>
            </ul>
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
<!-- ======================= FIN: MENU SECUNDARIO SIMPLE ======================= -->


<!-- Page container -->
<div class="page-container container">

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
        <!-- ======================= BARRA SUPERIOR DEL CONTENIDO ======================= -->

        <!-- Page title -->
        <div class="page-title">
            <h5><i class="fa fa-bars"></i> Fixed navbar <small>Blank page</small></h5>


            <div class="btn-group">
                <a href="#" class="btn btn-link btn-lg btn-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i><span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li><a href="#">One more line</a></li>
                </ul>
            </div>

        </div>
        {{ content() }}
        <!-- /page title -->
        <!-- Footer -->
        <div class="footer">
            &copy; Copyright 2011. All rights reserved. It's Brain admin theme by <a href="#" title="">Eugene Kopyov</a>
        </div>
        <!-- /footer -->


    </div>
    <!-- /page content -->

</div>
<!-- page container -->