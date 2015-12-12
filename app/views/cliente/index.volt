
{{ content() }}

<div align="right">
    {{ link_to("cliente/new", "Create cliente") }}
</div>

{{ form("cliente/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search cliente</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="cliente_id">Cliente</label>
        </td>
        <td align="left">
            {{ text_field("cliente_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_operadora">Cliente Of Operadora</label>
        </td>
        <td align="left">
            {{ text_field("cliente_operadora", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_frs">Cliente Of Frs</label>
        </td>
        <td align="left">
            {{ text_field("cliente_frs", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_linea">Cliente Of Linea</label>
        </td>
        <td align="left">
            {{ text_field("cliente_linea", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="cliente_yacimiento">Cliente Of Yacimiento</label>
        </td>
        <td align="left">
            {{ text_field("cliente_yacimiento", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
