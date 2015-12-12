{{ content() }}
{{ form("tipoequipo/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("tipoequipo", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

<div align="center">
    <h1>Edit tipoequipo</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="tipoEquipo_nombre">TipoEquipo Of Nombre</label>
        </td>
        <td align="left">
            {{ text_field("tipoEquipo_nombre", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td>{{ hidden_field("id") }}</td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
