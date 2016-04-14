<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Transporte</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}

{{ form("transporte/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("transporte", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        <label for="transporte_dominio">Dominio</label>

        <div class="form-group">
            {{ text_field("transporte_dominio", "size" : 30,'class':'form-control','required':'','placeholder':'INGRESE EL DOMINIO') }}
        </div>
        {#==================================================#}
        <label for="transporte_nroInterno">Nro Interno</label>

        <div class="form-group">
            {{ text_field("transporte_nroInterno", "type" : "numeric",'class':'form-control','required':'','placeholder':'INGRESE EL NRO DE INTERNO') }}
        </div>
        {#==================================================#}
    </div>
</div>
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
