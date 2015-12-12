
{{ content() }}

<div align="right">
    {{ link_to("viaje/new", "Create viaje") }}
</div>

{{ form("viaje/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search viaje</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="viaje_id">Viaje</label>
        </td>
        <td align="left">
            {{ text_field("viaje_id", "type" : "numeric") }}
        </td>
    </tr>
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
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
