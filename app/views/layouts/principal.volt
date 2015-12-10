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

        <!-- ======================= MENU SUPERIOR DERECHO =======================-->

        <ul class="nav navbar-nav navbar-right collapse" id="navbar-right">
            <li>
                <a href="#">
                    <span>Agregar Orden</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span>Listar Planilla</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <span>Generar Excel</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span>Filtrar</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /navbar -->


<!-- ======================= ICONO DE LA EMPRESA =======================

<div class="container">
    <div class="page-header">
        <div class="logo"><a href="index.html" title=""><img src="http://placehold.it/190x90" alt=""></a></div>

    </div>
</div>-->

<!-- ======================= FIN: MENU SECUNDARIO SIMPLE ======================= -->


<!-- Page container -->
<div class="page-container container margin-top-section">

    <!-- ======================= MENU PRIMARIO LATERAL IZQUIERDO ======================= -->
    <div class="sidebar collapse">
        <ul class="navigation">
            <li><a href="index.html"><i class="fa fa-laptop"></i>  MENÚ</a></li>
            <li>
                <a href="#" class="expand"><i class="fa fa-align-justify"></i> AGREGAR</a>
                <ul>
                    <li><a href="form_components.html">Agregar Planilla</a></li>
                    <li><a href="form_validation.html">Agregar Orden</a></li>
                    <li><a href="wysiwyg.html">Agregar Transporte</a></li>
                    <li><a href="form_layouts.html">Agregar Viaje</a></li>
                    <li><a href="form_layouts.html">Agregar Tipo de Equipo</a></li>
                    <li><a href="form_layouts.html">Agregar Tipo de Carga</a></li>
                    <li><a href="form_layouts.html">Agregar Chofer</a></li>
                    <li><a href="form_layouts.html">Agregar Tarifa</a></li>
                    <li><a href="form_layouts.html">Agregar Cliente</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="expand"><i class="fa fa-table"></i> LISTADO </a>
                <ul>
                    <li><a href="form_components.html">item 1</a></li>
                    <li><a href="form_validation.html">item 2</a></li>
                    <li><a href="wysiwyg.html">item 3</a></li>
                    <li><a href="form_layouts.html">item 4</a></li>
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