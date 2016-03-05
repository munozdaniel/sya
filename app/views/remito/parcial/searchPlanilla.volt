<div class="box-header">
    <h3 class="box-title">Seleccionar Planilla <br> <small> Obtener todos los remitos de una planilla </small></h3>

</div>

<!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form('id':'form-buscarRemitos' ,"method":"post") }}
{# =================================== PLANILLA ================================== #}
{#Campos Ocultos#}
{#Fin Campos Ocultos#}
<div class="box box-primary">


    <fieldset id="fielset-buscar-planilla" class="panel-border">
        <legend>Seleccionar Planilla</legend>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="form-group">
                        <label>Nombre de la planilla</label>
                        {{ formulario.render() }}
                        <span class="input-group-btn">
                            {{ submit_button(" BUSCAR REMITOS",'id':'submit','class':'btn btn-flat btn-primary ') }}
                        </span>
                    </div><!-- /.form-group -->
                </div>
            </div>
        </div>
    </fieldset>
</div>

{{ end_form() }}
<script>
    $(function () {
        $(".autocompletar").select2();
    });
</script>