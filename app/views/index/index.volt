<section>
    <div class="login-box">

        <div class="login-logo">
            {{ image('image/logo.png','alt':'logo sya') }}
        </div><!-- /.login-logo -->

        <div class="login-box-body" style="border: solid #CACACA;">
            <p class="login-box-msg">Identificarse para iniciar sesión</p>

            {{ form('sesion/validar','method':'post') }}
                {{ content() }}
                <div class="form-group has-feedback">
                    <input id="sesion_nombre" name="sesion_nombre" type="text" class="form-control" placeholder="Nombre de Usuario">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="sesion_contrasena" name="sesion_contrasena" type="password" class="form-control" placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <!-- <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-xs-4 pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar</button>
                    </div><!-- /.col -->
                </div>
            </form>

            <div class="social-auth-links text-center">
                <a href="#recuperarDatos" role="button" class="" data-toggle="modal">Olvidó su contraseña?</a>
            </div><!-- /.social-auth-links -->

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

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
