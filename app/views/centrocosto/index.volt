<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Centro Costo</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("centrocosto/new", "Crear Centro Costo",'class':'btn btn-large btn-danger btn-flat') }}
</div>

<!-- Inicio Formulario -->
{{ content() }}
{{ form("centrocosto/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    {% for element in centroCostoForm %}
        {% if admin!=1 %}
            {{ hidden_field("centroCosto_habilitado", "value" : "1" ) }}
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
<!-- /.Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
