
{{ form("transporte/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("transporte", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create transporte</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
