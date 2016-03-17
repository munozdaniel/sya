
{{ content() }}

<div align="right">
    {{ link_to("remito/new", "Create remito") }}
</div>

{{ form("remito/buscarRemitoPorPlanilla", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search remito</h1>
</div>
{{ text_field('paginador',"type":'numeric') }}
<table>
    <tr>
        <td align="right">
            <label for="remito_id">Remito</label>
        </td>
        <td align="left">
            {{ text_field("remito_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_nro">Remito Of Nro</label>
        </td>
        <td align="left">
            {{ text_field("remito_nro", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_planillaId">Remito Of PlanillaId</label>
        </td>
        <td align="left">
            {{ text_field("remito_planillaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_periodo">Remito Of Periodo</label>
        </td>
        <td align="left">
            {{ text_field("remito_periodo", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_transporteId">Remito Of TransporteId</label>
        </td>
        <td align="left">
            {{ text_field("remito_transporteId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_tipoEquipoId">Remito Of TipoEquipoId</label>
        </td>
        <td align="left">
            {{ text_field("remito_tipoEquipoId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_tipoCargaId">Remito Of TipoCargaId</label>
        </td>
        <td align="left">
            {{ text_field("remito_tipoCargaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_choferId">Remito Of ChoferId</label>
        </td>
        <td align="left">
            {{ text_field("remito_choferId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_viajeId">Remito Of ViajeId</label>
        </td>
        <td align="left">
            {{ text_field("remito_viajeId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_concatenadoId">Remito Of ConcatenadoId</label>
        </td>
        <td align="left">
            {{ text_field("remito_concatenadoId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_tarifaId">Remito Of TarifaId</label>
        </td>
        <td align="left">
            {{ text_field("remito_tarifaId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_contenidoExtraId">Remito Of ContenidoExtraId</label>
        </td>
        <td align="left">
            {{ text_field("remito_contenidoExtraId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_clienteId">Remito Of ClienteId</label>
        </td>
        <td align="left">
            {{ text_field("remito_clienteId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_centroCostoId">Remito Of CentroCostoId</label>
        </td>
        <td align="left">
            {{ text_field("remito_centroCostoId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_equipoPozoId">Remito Of EquipoPozoId</label>
        </td>
        <td align="left">
            {{ text_field("remito_equipoPozoId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_operadoraId">Remito Of OperadoraId</label>
        </td>
        <td align="left">
            {{ text_field("remito_operadoraId", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_observacion">Remito Of Observacion</label>
        </td>
        <td align="left">
            {{ text_field("remito_observacion", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_pdf">Remito Of Pdf</label>
        </td>
        <td align="left">
            {{ text_field("remito_pdf", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_fecha">Remito Of Fecha</label>
        </td>
        <td align="left">
                {{ text_field("remito_fecha", "type" : "date") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_fechaCreacion">Remito Of FechaCreacion</label>
        </td>
        <td align="left">
            {{ text_field("remito_fechaCreacion", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_conformidad">Remito Of Conformidad</label>
        </td>
        <td align="left">
            {{ text_field("remito_conformidad", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_noConformidad">Remito Of NoConformidad</label>
        </td>
        <td align="left">
            {{ text_field("remito_noConformidad", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_creadoPor">Remito Of CreadoPor</label>
        </td>
        <td align="left">
            {{ text_field("remito_creadoPor", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_habilitado">Remito Of Habilitado</label>
        </td>
        <td align="left">
            {{ text_field("remito_habilitado", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="remito_ultima">Remito Of Ultima</label>
        </td>
        <td align="left">
            {{ text_field("remito_ultima", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
