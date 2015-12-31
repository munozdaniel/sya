<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Operadora</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("operadora/new", "Crear Operadora",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("operadora/search", "method":"post", "autocomplete" : "off") }}


<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <label for="operadora_id">N° de Operadora</label>

    <div class="form-group">
        {{ text_field("operadora_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="operadora_nombre">Nombre </label>

    <div class="form-group">
        {{ text_field("operadora_nombre", "size" : 30) }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("operadora_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>

