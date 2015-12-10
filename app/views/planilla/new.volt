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
{{ form("planilla/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("planilla", "Volver") }}</td>
        <td align="right">{{ submit_button("Guardar",'class':'btn btn-success ') }}</td>
    </tr>
</table>

{{ content() }}

<div align="center">
    <h1>Crear planilla</h1>
</div>

<table>
    <tr>
        <td align="right">
            <label for="planilla_nombreCliente">Nombre de la Planilla</label>
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
                {{ date_field("planilla_fecha", "type" : "date") }}
        </td>
    </tr>

    <tr>
        <td></td>
        <td>{{ submit_button("Guardar",'class':'btn btn-success btn-block') }}</td>
    </tr>
</table>

</form>
