
{{ content() }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("remito/index", "Go Back") }}
        </td>
        <td align="right">
            {{ link_to("remito/new", "Create ") }}
        </td>
    </tr>
</table>

<div class="box-body">
    <div id="toolbar">
        <label>
            <select class="form-control">
                <option value="">Exportar Pagina</option>
                <option value="all">Exportar Todo</option>
                <option value="selected">Exportar Seleccionados</option>
            </select>
        </label>
    </div>
    <table id="tabla"
           data-show-pagination-switch="true"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-escape="false"{# Para usar html en las celdas#}
           data-show-refresh="true"
           data-toggle="table"
           data-toolbar="#toolbar"
           data-show-columns="true"
           data-cookie="true"
           data-cookie-id-table="tabla"
           data-search="true"
           data-show-toggle="false"{# Cambia de vista cada celda#}
           data-pagination="true"
           data-reorderable-columns="true"
           data-show-export="true"
           data-click-to-select="true"
           data-row-style="rowStyle"
           class="table table-bordered table-striped">
        <thead>
        <tr>
            <th data-field="state" data-checkbox="true"></th>
            <th data-sortable="true">ORDEN</th>
            <th data-sortable="true">REMITO</th>
            <th data-sortable="true">PATENTE</th>
            <th data-sortable="true">N° INTERNO</th>
            <th data-sortable="true">TIPO DE EQUIPO</th>
            <th data-sortable="true">TIPO DE CARGA</th>
            <th data-sortable="true">DNI</th>
            <th data-sortable="true">CHOFER</th>
            <th data-sortable="true">FECHA</th>
            <th data-sortable="true">CLIENTE</th>
            <th data-sortable="true">ORIGEN</th>
            <th data-sortable="true">DESTINO</th>
            <th data-sortable="true">EQUIPO/POZO</th>
            <th data-sortable="true">CONCATENADO</th>
            <th data-sortable="true">OPERADORA</th>
            <th data-sortable="true">LINEA-PSL</th>
            <th data-sortable="true">CENTRO COSTO</th>
            <th data-sortable="true">OBSERVACIONES</th>
            <th data-sortable="true">KM</th>
            <th data-sortable="true">HS HIDRO</th>
            <th data-sortable="true">HS MALACATE</th>
            <th data-sortable="true">HS SERVICIO</th>
            <th data-sortable="true">HS STAND</th>
            <th data-sortable="true">CONFORMIDAD RE</th>
            <th data-sortable="true">MOT NO CONFORM RE</th>
        </tr>
        </thead>
        <tbody>
        {% if page.items is defined %}
            {% for remito in page.items %}
                <tr>
                    <td>X</td>
                    {% for item in remito %}
                    <td>{{ item }}</td>
                    {% endfor %}
                </tr>
            {% endfor %}
        {% endif %}
        </tbody>
    </table>
</div>

{{ link_to("remito/search", "First") }}
{{ link_to("remito/search?page="~page.before, "Previous") }}
{{ link_to("remito/search?page="~page.next, "Next") }}
{{ link_to("remito/search?page="~page.last, "Last") }}
{{ page.current~"/"~page.total_pages }}
