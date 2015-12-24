<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Equipo/Pozo</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("equipopozo/new", "Crear Equipo/Pozo",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}

{{ form("equipopozo/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    {% for element in equipoPozoForm %}
        {% if admin!=1 %}
            {{ hidden_field("equipoPozo_habilitado", "value" : "1" ) }}
        {% endif %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            {{ element.label(['class': 'control-label']) }}
            <div class="form-group">
                    {{ element }}
            </div>
        {% endif %}
    {% endfor %}
    {#===============================================#}

</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
