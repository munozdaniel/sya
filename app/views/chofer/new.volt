<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Chofer</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}

{{ form("chofer/create", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("chofer", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        {#======================================================#}
        <label for="chofer_nombreCompleto">Nombre Completo</label>

        <div class="form-group">
            {{ text_field("chofer_nombreCompleto", "size" : 100,'class':'form-control','required':'','placeholder':'INGRESE EL NOMBRE') }}
        </div>
        {#======================================================#}
        <label for="chofer_dni">Nro Documento</label>

        <div class="form-group">
            {{ text_field("chofer_dni", "type" : "numeric",'class':'form-control','required':'','placeholder':'INGRESE EL DNI') }}
        </div>
        {#======================================================#}
        <label for="chofer_esFletero">Es Fletero?</label>

        <div class="form-group">
            <div class="radio">
                <label>
                    <input type="radio" name="chofer_esFletero" id="chofer_esFletero" value="1">
                    SI
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="chofer_esFletero" id="chofer_esFletero" value="0" checked>
                    NO
                </label>
            </div>
        </div>
    </div>
</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
