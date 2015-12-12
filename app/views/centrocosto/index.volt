
{{ content() }}

<div align="right">
    {{ link_to("centrocosto/new", "Create centrocosto") }}
</div>

{{ form("centrocosto/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search centrocosto</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="centroCosto_id">CentroCosto</label>
        </td>
        <td align="left">
            {{ text_field("centroCosto_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="centroCosto_codigo">CentroCosto Of Codigo</label>
        </td>
        <td align="left">
            {{ text_field("centroCosto_codigo", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
