<!-- Titulo -->
<div class="box-header">

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("orden/index", "<i class='fa fa-sticky-note-o'></i>  Buscar Orden",'class':'btn btn-flat btn-large bg-navy') }}
                {{ link_to("planilla/index", "<i class='fa fa-folder'></i> Buscar Planilla",'class':'btn btn-flat btn-large bg-olive') }}
            </td>
            <td align="right">
                {{ link_to("orden/new", "<i class='fa fa-pencil-square'></i> Agregar Orden ",'class':'btn btn-flat btn-large btn-danger') }}
                {{ link_to("orden/exportarPlanilla/"~planilla.getPlanillaId(), "<i class='fa fa-file-excel-o'></i> Exportar Excel ",'class':'btn btn-flat btn-large btn-success') }}
            </td>
        </tr>
    </table>
    {% if planilla is defined %}
        <h2 class="box-title" >
            <strong><ins>LISTADO DE ORDENES</ins></strong>
<br>
        </h2>
        <div>
            <br>
            <table align="left" width="50%">
                <thead>
                    <tr style="border-bottom: 1px solid;">
                        <th>#</th>
                        <th>Planilla</th>
                        <th>Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ planilla.getPlanillaId() }} </td>
                    <td>{{ planilla.getPlanillaNombrecliente() }}</td>
                    <td>{{ date('d/m/Y',(planilla.getPlanillaFecha()) | strtotime)}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    {% else %}
        <h3 class="box-title">            <strong><ins>LISTADO DE ORDENES</ins></strong>        </h3>
    {% endif %}

</div>
{{ content() }}
<script>
    $(document).ready(function () {
            $('#tabla_id').DataTable( {
                "scrollX": true
            } );
    });
</script>
<div class="box box-primary">
<div class="box-body">
    <table id="tabla_id" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ORDEN</th>
            <th>FECHA</th>
            <th>PERIODO</th>
            <th>DOMINIO</th>
            <th>N° INTERNO</th>
            <th>TIPO EQUIPO</th>
            <th>TIPO CARGA</th>
            <th>DNI</th>
            <th>CHOFER</th>
            <th>FLETERO</th>{#10#}
            <th>CLIENTE</th>
            <th>OPERADORA</th>
            <th>#FRS</th>
            <th>REMITO SYA</th>
            <th>LINEA-PSL</th>
            <th>CENTRO COSTO</th>
            <th>ORIGEN</th>
            <th>DESTINO</th>
            <th>EQUIPO/POZO</th>
            <th>CONCATENADO</th>{#20#}
            <th>HS SERVICIO</th>
            <th>KM</th>
            <th>HS HIDRO</th>
            <th>HS MAL</th>
            <th>HS STAND</th>
            <th>OBSERVACIONES</th>
            <th>CONFORMIDAD RE</th>
            <th>MOT NO CONFORM RE</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for orden in page.items %}
        <tr>
            <td>{{ orden['orden_nro'] }}</td>
            <td>{{ orden['orden_fecha'] }}</td>
            <td>{{ orden['orden_periodo'] }}</td>
            <td>{{ orden['transporte_dominio'] }}</td>
            <td>{{ orden['transporte_nroInterno'] }}</td>
            <td>{{ orden['tipoEquipo_nombre'] }}</td>
            <td>{{ orden['tipoCarga_nombre'] }}</td>
            <td>{{ orden['chofer_dni'] }}</td>
            <td>{{ orden['chofer_nombreCompleto'] }}</td>
            <td>{{ orden['chofer_esFletero'] }}</td>{#10#}
            <td>{{ orden['cliente_nombre'] }}</td>
            <td>{{ orden['operadora_nombre'] }}</td>
            <td>{{ orden['frs_codigo'] }}</td>
            <td>{{ orden['orden_remito'] }}</td>
            <td>{{ orden['linea_nombre'] }}</td>
            <td>{{ orden['centroCosto_codigo'] }}</td>
            <td>{{ orden['viaje_origen'] }}</td>
            <td>{{ orden['yacimiento_destino'] }}</td>
            <td>{{ orden['equipoPozo_nombre'] }}</td>
            <td>{{ orden['viaje_concatenado'] }}</td>
            <td>{{ orden['tarifa_hsServicio'] }}</td>{#10#}
            <td>{{ orden['tarifa_hsKm'] }}</td>
            <td>{{ orden['tarifa_hsHidro'] }}</td>
            <td>{{ orden['tarifa_hsMalacate'] }}</td>
            <td>{{ orden['tarifa_hsStand'] }}</td>
            <td>{{ orden['orden_observaciones'] }}</td>
            <td>{{ orden['orden_conformidad'] }}</td>
            <td>{{ orden['orden_noConformidad'] }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>

</table>
</div>
</div>
