
{{ content() }}

<div align="right">
    {{ link_to("pagina/new", "Create pagina") }}
</div>

{{ form("pagina/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search pagina</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="pagina_id">Pagina</label>
        </td>
        <td align="left">
            {{ text_field("pagina_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="pagina_nombreControlador">Pagina Of NombreControlador</label>
        </td>
        <td align="left">
            {{ text_field("pagina_nombreControlador", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="pagina_nombreAccion">Pagina Of NombreAccion</label>
        </td>
        <td align="left">
            {{ text_field("pagina_nombreAccion", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
