<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Tipo de Equipo</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("tipoequipo/new", "Crear Tipo de Equipo",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("tipoequipo/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <label for="tipoEquipo_id">N° Tipo de Equipo</label>

    <div class="form-group">
        {{ text_field("tipoEquipo_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="tipoEquipo_nombre">Nombre del Equipo</label>

    <div class="form-group">
        {{ text_field("tipoEquipo_nombre", "size" : 30) }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("tipoEquipo_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
