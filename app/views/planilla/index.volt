<!-- Page title -->
<div class="page-title">
    <h5><i class="fa fa-bars"></i> Fixed navbar <small>Blank page</small></h5>
    <div class="btn-group">
        <a href="#" class="btn btn-link btn-lg btn-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i><span class="caret"></span></a>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><a href="#">One more line</a></li>
        </ul>
    </div>
</div>
<!-- /page title -->
{{ content() }}

<div align="right">
    {{ link_to("planilla/new", "Create planilla") }}
</div>

{{ form("planilla/search", "method":"post", "autocomplete" : "off") }}

<div align="center">
    <h1>Search planilla</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="planilla_id">Planilla</label>
        </td>
        <td align="left">
            {{ text_field("planilla_id", "type" : "numeric") }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="planilla_nombreCliente">Planilla Of NombreCliente</label>
        </td>
        <td align="left">
            {{ text_field("planilla_nombreCliente", "size" : 30) }}
        </td>
    </tr>
    <tr>
        <td align="right">
            <label for="planilla_fecha">Planilla Of Fecha</label>
        </td>
        <td align="left">
                {{ text_field("planilla_fecha", "type" : "date") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Search") }}</td>
    </tr>
</table>

</form>
