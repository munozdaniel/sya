<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Linea</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("linea/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("linea", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        <label for="linea_nombre">Nombre de la Linea</label>

        <div class="form-group">
            {{ text_field("linea_nombre", "size" : 50,'class':'form-control','required':'true','placeholder':'INGRESAR NOMBRE') }}
        </div>
        {#==================================================#}
        <label for="linea_nombre">Nombre del Cliente</label>

        <div class="form-group">
            {{ cliente }}
        </div>
    </div>
</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("linea_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
{{ end_form() }}
<script>
    $(function () {
        $(".autocompletar").select2();

    });
</script>
