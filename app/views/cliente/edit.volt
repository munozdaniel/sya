{{ content() }}
{{ form("cliente/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("cliente", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit cliente</h1>
</div>

<table>
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
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>