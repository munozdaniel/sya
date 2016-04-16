<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Yacimiento</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("yacimiento/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("yacimiento", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">
        <label for="yacimiento_destino">Destino</label>
        <div class="form-group">
            {{ text_field("yacimiento_destino", "size" : 30,'class':'form-control','required':'','placeholder':'INGRESE EL DESTINO') }}
        </div>
        <label for="operadoras">Seleccionar Operadoras</label>
        <div class="form-group">
            {{ form.render('operadoras') }}
        </div>
    </div>
</div><!-- /. Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
{{ end_form() }}
