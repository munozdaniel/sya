<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Viaje</h3>
</div><!-- /.Titulo -->

<!-- Inicio Formulario -->
{{ content() }}
{{ form("viaje/save", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">{{ link_to("viaje", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <label for="viaje_origen">Origen</label>
    <div class="form-group">
        {{ text_field("viaje_origen", "size" : 30) }}
    </div>


</div><!-- /.Cuerpo -->
<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("viaje_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>