
{{ form("acceso/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("acceso", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create acceso</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="rol_id">Rol</label>
        </td>
        <td align="left">
            {{ text_field("rol_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="pagina_id">Pagina</label>
        </td>
        <td align="left">
            {{ text_field("pagina_id", "type" : "numeric") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
