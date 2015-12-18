<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Chofer</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("chofer/save", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">{{ link_to("chofer", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    {#======================================================#}
    <label for="chofer_nombreCompleto">Nombre Completo</label>
    <div class="form-group">
        {{ text_field("chofer_nombreCompleto", "size" : 30) }}
    </div>
    {#======================================================#}
    <label for="chofer_dni">Nro Documento</label>
    <div class="form-group">
        {{ text_field("chofer_dni", "type" : "numeric") }}
    </div>
    {#======================================================#}
    <label for="chofer_esFletero">Es Fletero?</label>
    <div class="form-group">
        <div class="radio">
            <label>
                <input type="radio" name="chofer_esFletero" id="chofer_esFletero" value="1" >
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
</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("chofer_id") }}
    {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
