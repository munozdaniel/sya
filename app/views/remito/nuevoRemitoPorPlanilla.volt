<div class="box box-primary">
    <div class="box-header">
        <h3>AGREGAR REMITO
            <small>
                <br> Seleccione la planilla a la cual desea agregar un remito.
            </small>
        </h3>
        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("remito/searchDataTable", "<i class='fa fa-search'></i> Busqueda de Remitos",'class':'btn btn-flat btn-large bg-olive') }}
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
        {{ form('remito/generarFormularioNuevo','id':'form-buscarRemitos' ,"method":"POST") }}

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