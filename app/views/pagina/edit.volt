{{ content() }}
{{ form("pagina/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("pagina", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit pagina</h1>
</div>

<table>
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
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
