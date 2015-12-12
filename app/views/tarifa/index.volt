
{{ content() }}

<div align="right">
    {{ link_to("tarifa/new", "Create tarifa") }}
</div>

{{ form("tarifa/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search tarifa</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="tarifa_id">Tarifa</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tarifa_horaInicial">Tarifa Of HoraInicial</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_horaInicial", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tarifa_horaFinal">Tarifa Of HoraFinal</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_horaFinal", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tarifa_hsServicio">Tarifa Of HsServicio</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_hsServicio", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tarifa_hsHidro">Tarifa Of HsHidro</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_hsHidro", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tarifa_hsMalacate">Tarifa Of HsMalacate</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_hsMalacate", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tarifa_hsStand">Tarifa Of HsStand</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_hsStand", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tarifa_km">Tarifa Of Km</label>
        </td>
        <td align="left">
            {{ text_field("tarifa_km", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
