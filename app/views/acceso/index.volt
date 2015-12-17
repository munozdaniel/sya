
{{ content() }}

<div align="right">
    {{ link_to("acceso/new", "Create acceso") }}
</div>

{{ form("acceso/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search acceso</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="acceso_id">Acceso</label>
        </td>
        <td align="left">
            {{ text_field("acceso_id", "type" : "numeric") }}
        </td>
    </tr>
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
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
