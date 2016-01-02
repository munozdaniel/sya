<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar FRS</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("frs/new", "Crear FRS",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("frs/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <label for="frs_id">N° de FRS</label>

    <div class="form-group">
        {{ text_field("frs_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="frs_codigo">Codigo </label>

    <div class="form-group">
        {{ text_field("frs_codigo", "size" : 30) }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("frs_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
