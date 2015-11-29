<!-- Page container -->
<section class="full-width">
    <div class="page-container container">

        <!-- Page content -->
        <div class="page-content">


            <!-- Login wrapper -->
            <div class="login-wrapper">
                {{ form('index/validar','method':'post') }}
                    {{ content() }}
                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title"><i class="fa fa-user"></i> Bienvenido</h6>
                        </div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                <label>Usuario</label>
                                <input id="sesion_nombre" name="sesion_nombre" type="text" class="form-control" placeholder="Nombre de Usuario">
                                <i class="fa fa-user form-control-feedback"></i>
                            </div>

                            <div class="form-group has-feedback">
                                <label>Contraseña</label>
                                <input id="sesion_contrasena" name="sesion_contrasena" type="password" class="form-control" placeholder="Contraseña">
                                <i class="fa fa-lock form-control-feedback"></i>
                            </div>

                            <div class="row form-actions">
                                <div class="col-xs-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="styled">
                                            Recordarme
                                        </label>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-bars"></i>
                                        Iniciar Sesión
                                    </button>
                                </div>
                                <div class="col-xs-12">
                                    <hr>
                                    <!-- Button HTML (to Trigger Modal) -->
                                    <a href="#recuperarDatos" role="button" class="btn btn-block btn-primary" data-toggle="modal">Olvidó su contraseña?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /login wrapper -->

        </div>
        <!-- /page content -->

    </div>
    <!--=========== RecuperarContraseña ================-->
    <div id="recuperarDatos" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-envelope-o"></i> RECUPERAR CONTRASEÑA</h4>
                </div>
                <div class="modal-body margin-left-right-one"style="border-left: 0 !important; border-right: 0 !important;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 ">
                            <!-- START SUBSCRIBE HEADING -->
                            <div class="heading">
                                <h2 class="wow fadeInLeftBig">Olvidaste tu contraseña o tu usuario? </h2>
                                <p>La contraseña de inicio de sesión evita el acceso no autorizado al Sistema. Si no recuerda su contraseña de inicio de sesión, ingrese
                                    su dirección de correo provista por el equipo de desarrollo, y automáticamente se le enviarán los datos a su casilla de mensajes.</p>
                            </div>
                            <!--  FORM -->
                            {{ form('index/recuperar',"class":"subscribe_form") }}
                            <div class="subscrive_group wow fadeInUp">
                                {{ email_field('sesion_email','class':'form-control subscribe_mail','placeholder':'INGRESE SU CORREO ELECTRONICO') }}
                                <hr>
                                {{ submit_button('class':' btn-warning btn-lg btn-block','value':'SOLICITAR') }}
                            </div>
                            {{ end_form() }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-lg" data-dismiss="modal"> CERRAR  <i class="fa  fa-sign-out pull-right"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!--=========== FIN:RecuperarContraseña ================-->
</section>
<!-- page container -->