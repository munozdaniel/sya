
{{ content() }}

<div align="right">
    {{ link_to("tipocarga/new", "Create tipocarga") }}
</div>

{{ form("tipocarga/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search tipocarga</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="tipoCarga_id">TipoCarga</label>
        </td>
        <td align="left">
            {{ text_field("tipoCarga_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="tipoCarga_nombre">TipoCarga Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("tipoCarga_nombre", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
