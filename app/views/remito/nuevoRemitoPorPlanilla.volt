
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">AGREGAR REMITO A PLANILLA<br></h3>

        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/buscarRemitoPorPlanilla", "<i class='fa fa-search'></i> Realizar nueva búsqueda",'class':'btn btn-flat btn-google') }}
                </td>

                <td align="right">
                    {{ link_to("remito/nuevoRemitoPorPlanilla", "<i class='fa fa-search'></i> Agregar Remito",'class':'btn btn-flat btn-primary') }}
                </td>

            </tr>
        </table>
    </div>
</div>
{#=============================================================================================================#}
<section id="seccion-busqueda">
    {{ content() }}
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Seleccionar Planilla <br>
            </h3>

        </div>
        {{ form('remito/nuevo','id':'form-buscarRemitos' ,"method":"POST") }}

        <fieldset id="fielset-buscar-planilla" class="panel-border">
            <br>
            <br>
            <div class="container" align="center">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        {{ formulario.render() }}

                    </div>

                </div>
                <hr>
            </div>
        </fieldset>
    </div>
    {{ submit_button(" GENERAR FORMULARIO",'id':'submit','class':'btn btn-lg btn-flat btn-primary') }}

    {{ end_form() }}

</section>

<script>
    $(function () {
        $(".autocompletar").select2();
    });
</script>