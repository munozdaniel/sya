<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Centro Costo</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("centrocosto/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("centrocosto", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>


<!-- Cuerpo -->
<div class="box-body">
    {% for element in centroCostoForm %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            {{ element.label() }}
            <div class="form-group">
                {{ element.render(['class': '']) }}
            </div>
        {% endif %}
    {% endfor %}
    <div id="nuevo" style="display: none;">
        <div class="form-group">
            {{ text_field("linea_nombre", "size" : 50,"placeholder":"NUEVA LINEA") }}
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="nuevaLinea">
                <input id="nuevaLinea" name="nuevaLinea" type="checkbox" onclick="habilitarNuevo(this);" value="1">
                Ingresar nueva Linea?
            </label>
        </div>
    </div>
    {#===============================================#}
</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
<script>
    function habilitarNuevo(nuevoYacimiento) {
        $("#nuevo").toggle();
        $("#centroCosto_linea").toggle();//Esconde el datalist
    }
</script>