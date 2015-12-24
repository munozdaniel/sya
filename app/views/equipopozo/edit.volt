<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Equipo/Pozo</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->
{{ content() }}
{{ form("equipopozo/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("equipopozo", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    {% for element in equipoPozoForm %}
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
            {{ text_field("yacimiento_destino", "size" : 30,"placeholder":"NUEVO DESTINO") }}
        </div>
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label for="nuevoYacimiento">
                <input id="nuevoYacimiento" name="nuevoYacimiento" type="checkbox" onclick="habilitarNuevoYacimiento(this);" value="1">
                Ingresar nuevo yacimiento?
            </label>
        </div>
    </div>
</div><!-- /.Cuerpo -->


<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("equipoPozo_id") }}
    {{ submit_button("Guardar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
<script>
    function habilitarNuevoYacimiento(nuevoYacimiento) {
        $("#nuevo").toggle();
        $("#equipoPozo_yacimiento").toggle();
    }
</script>