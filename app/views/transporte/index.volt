
{{ content() }}

<div align="right">
    {{ link_to("transporte/new", "Create transporte") }}
</div>

{{ form("transporte/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search transporte</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="transporte_id">Transporte</label>
        </td>
        <td align="left">
            {{ text_field("transporte_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="transporte_dominio">Transporte Of Dominio</label>
        </td>
        <td align="left">
            {{ text_field("transporte_dominio", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="transporte_nroInterno">Transporte Of NroInterno</label>
        </td>
        <td align="left">
            {{ text_field("transporte_nroInterno", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
