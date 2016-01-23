<!-- Titulo -->
<div class="box-header">
    <h3 class="box-title">Listado de Lineas</h3>

    <table width="100%">
        <tr>
            <td align="left">
                {{ link_to("orden/index", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
            <td align="right">
                {{ link_to("orden   /new", "CREAR ",'class':'btn btn-flat btn-large btn-danger') }}
            </td>
        </tr>
    </table>
</div>
{{ content() }}

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
            <th>REMITO</th>
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
            <th>Editar</th>
            <th>Eliminar</th>{#30#}
            <th style="width: 10px;">EST</th>
         </tr>
    </thead>
    <tbody>
    {% if page.items is defined %}
    {% for orden in page.items %}
        <tr>
            <td>{{ orden.getOrdenId() }}</td>
            <td>{{ orden.getOrdenPlanillaid() }}</td>
            <td>{{ orden.getOrdenPeriodo() }}</td>
            <td>{{ orden.getOrdenTransporteid() }}</td>
            <td>{{ orden.getOrdenTipoequipoid() }}</td>
            <td>{{ orden.getOrdenTipocargaid() }}</td>
            <td>{{ orden.getOrdenChoferid() }}</td>
            <td>{{ orden.getOrdenViajeid() }}</td>
            <td>{{ orden.getOrdenConcatenadoid() }}</td>
            <td>{{ orden.getOrdenTarifaid() }}</td>{#10#}
            <td>{{ orden.getOrdenContenidoextraid() }}</td>
            <td>{{ orden.getOrdenClienteid() }}</td>
            <td>{{ orden.getOrdenFrsid() }}</td>
            <td>{{ orden.getOrdenCentrocostoid() }}</td>
            <td>{{ orden.getOrdenEquipopozoid() }}</td>
            <td>{{ orden.getOrdenObservacion() }}</td>
            <td>{{ orden.getOrdenFecha() }}</td>
            <td>{{ orden.getOrdenFechacreacion() }}</td>
            <td>{{ orden.getOrdenConformidad() }}</td>
            <td>{{ orden.getOrdenNoconformidad() }}</td>{#10#}
            <td>{{ orden.getOrdenCreadopor() }}</td>
            <td>{{ orden.getOrdenHabilitado() }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/edit/"~orden.getOrdenId(), "Edit") }}</td>
            <td>{{ link_to("orden/delete/"~orden.getOrdenId(), "Delete") }}</td>{#10#}
            <td>{{ link_to("orden/delete/"~orden.getOrdenId(), "Delete") }}</td>
        </tr>
    {% endfor %}
    {% endif %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="2" align="right">
                <table align="center">
                    <tr>
                        <td>{{ link_to("orden/search", "First") }}</td>
                        <td>{{ link_to("orden/search?page="~page.before, "Previous") }}</td>
                        <td>{{ link_to("orden/search?page="~page.next, "Next") }}</td>
                        <td>{{ link_to("orden/search?page="~page.last, "Last") }}</td>
                        <td>{{ page.current~"/"~page.total_pages }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
</div>
