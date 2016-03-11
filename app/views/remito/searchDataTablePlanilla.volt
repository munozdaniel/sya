{#=============================================================================================================#}
<section id="seccion-busqueda">


    <!-- /.Titulo -->
    <!-- Formulario -->
    {{ content() }}
    {# =================================== PLANILLA ================================== #}
    {#Campos Ocultos#}
    {#Fin Campos Ocultos#}
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Seleccionar Planilla <br>
                <small> Para comenzar la busqueda personalizada</small>
            </h3>

        </div>
        <fieldset id="fielset-buscar-planilla" class="panel-border">
            <br>
            <br>
            <div class="container" align="center">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        {{ formulario.render() }}

                    </div>
                    <div class="col-md-2">
                    <span class="input-group-btn"><br>
                        <a id="confirmarPlanilla"
                           class="btn btn-flat btn-info pull-left" title="CARGA CABECERA"><i class="fa fa-2x fa-check-circle-o"></i>.
                        </a>
                    </span>
                    </div>
                </div>
                <hr>
            </div>
        </fieldset>
    </div>
    {{ form('id':'form-buscarRemitos' ,"method":"post") }}
    {{ submit_button(" BUSCAR REMITOS",'id':'submit','class':'btn btn-lg btn-flat btn-primary', 'disabled':'') }}

    {{ end_form() }}

</section>