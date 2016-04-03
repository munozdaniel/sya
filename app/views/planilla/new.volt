<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">CREAR NUEVA PLANILLA<br></h3>
        <table width="100%">
            <tr>
                <td align="left">
                    {{ link_to("index/dashboard", "<i class='fa fa-home'></i> Volver al Tablero Principal",'class':'btn btn-flat btn-google') }}
                </td>
            </tr>
        </table>
    </div>
</div>
{#=============================================================================================================#}
<div class="box box-primary">
    {{ content() }}
    <!-- Cuerpo -->
    <div class="box-body">
        <div class="form-group">
            <div class="col-sm-12">
                <div id="mensajes-alertas">
                    {# Genera alertas #}
                </div>
            </div>
        </div>        <div id="pnl_planilla" class="col-xs-12 col-md-12">
            {{ partial('planilla/parcial/planilla') }}
        </div>
        <div id="pnl_cabecera"  class="col-xs-12 col-md-12">
            {{ partial('planilla/parcial/cabecera') }}
        </div>
        <!-- ================================================================================= -->
        <div class="col-xs-12 col-md-12">
            <hr>
        </div>
        <!-- ================================================================================= -->
        <div id="id_nuevaCabecera">
            <div id="pnl_extra" class="col-xs-12 col-md-12">
               {{ partial('planilla/parcial/extra') }}
            </div>

        </div>
        <!-- ================================================================================= -->
        <div id="id_cabeceraExistente" class="col-xs-12 col-md-12 ocultar">
            {{ partial('planilla/parcial/seleccion') }}
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- ====================================== -->
