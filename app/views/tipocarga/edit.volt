<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Tipo de Carga</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("tipocarga/save", "method":"post") }}

<table width="100%">
    <tr>
        {{ link_to("tipocarga", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        <label for="tipoCarga_nombre">Nombre del Equipo</label>

        <div class="form-group">
            {{ text_field("tipoCarga_nombre", "size" : 50,'class':'form-control','required':'','placeholder':'INGRESE EL NOMBRE') }}
        </div>
    </div>
</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("tipoCarga_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
{{ end_form() }}
