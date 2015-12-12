
{{ form("tipocarga/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("tipocarga", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create tipocarga</h1>
</div>

<table>
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
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
