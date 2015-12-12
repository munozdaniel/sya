
{{ form("viaje/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("viaje", "Go Back") }}</td>
        <td align="right">{{ submit_button("Save") }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Create viaje</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="viaje_origen">Viaje Of Origen</label>
        </td>
        <td align="left">
            {{ text_field("viaje_origen", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="viaje_concatenado">Viaje Of Concatenado</label>
        </td>
        <td align="left">
            {{ text_field("viaje_concatenado", "size" : 30) }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Save") }}</td>
    </tr>
</table>

</form>
