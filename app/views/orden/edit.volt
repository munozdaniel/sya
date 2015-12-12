{{ content() }}
{{ form("orden/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("orden", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit orden</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="orden_planilla">Orden Of Planilla</label>
        </td>
        <td align="left">
            {{ text_field("orden_planilla", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_periodo">Orden Of Periodo</label>
        </td>
        <td align="left">
            {{ text_field("orden_periodo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_transporte">Orden Of Transporte</label>
        </td>
        <td align="left">
            {{ text_field("orden_transporte", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_tipoEquipo">Orden Of TipoEquipo</label>
        </td>
        <td align="left">
            {{ text_field("orden_tipoEquipo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_tipoCarga">Orden Of TipoCarga</label>
        </td>
        <td align="left">
            {{ text_field("orden_tipoCarga", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_chofer">Orden Of Chofer</label>
        </td>
        <td align="left">
            {{ text_field("orden_chofer", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_cliente">Orden Of Cliente</label>
        </td>
        <td align="left">
            {{ text_field("orden_cliente", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_viaje">Orden Of Viaje</label>
        </td>
        <td align="left">
            {{ text_field("orden_viaje", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_tarifa">Orden Of Tarifa</label>
        </td>
        <td align="left">
            {{ text_field("orden_tarifa", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_columnaExtra">Orden Of ColumnaExtra</label>
        </td>
        <td align="left">
            {{ text_field("orden_columnaExtra", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_observacion">Orden Of Observacion</label>
        </td>
        <td align="left">
            {{ text_field("orden_observacion", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_fecha">Orden Of Fecha</label>
        </td>
        <td align="left">
                {{ text_field("orden_fecha", "type" : "date") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_fechaCreacion">Orden Of FechaCreacion</label>
        </td>
        <td align="left">
            {{ text_field("orden_fechaCreacion", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_conformidad">Orden Of Conformidad</label>
        </td>
        <td align="left">
            {{ text_field("orden_conformidad", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_noConformidad">Orden Of NoConformidad</label>
        </td>
        <td align="left">
            {{ text_field("orden_noConformidad", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="orden_creadoPor">Orden Of CreadoPor</label>
        </td>
        <td align="left">
            {{ text_field("orden_creadoPor", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
