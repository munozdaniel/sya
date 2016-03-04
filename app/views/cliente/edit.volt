<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Cliente</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("cliente/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("cliente", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">
        <label>Nombre del cliente</label>
        {{ text_field('cliente_nombre','class':'form-control','required':'','placeholder':'INGRESE DEL CLIENTE') }}
    </div>
</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("cliente_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
