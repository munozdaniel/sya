<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Yacimiento</h3>
</div><!-- /.Titulo -->
{{ content() }}
{{ form("yacimiento/save", "method":"post") }}
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
    </div>
    {#====================================================#}
</div><!-- /.Cuerpo -->
<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("yacimiento_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
