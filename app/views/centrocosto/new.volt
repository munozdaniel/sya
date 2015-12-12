
{{ form("centrocosto/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("centrocosto", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create centrocosto</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
