<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Tipo de Equipo</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("tipoequipo/new", "Nuevo Tipo de Equipo",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("tipoequipo/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">
        {#===============================================#}
        <label for="tipoEquipo_id">N° Tipo de Equipo</label>

        <div class="form-group">
            {{ text_field("tipoEquipo_id", "type" : "numeric",'class':'form-control','placeholder':'INGRESE EL ID') }}
        </div>
        {#===============================================#}
        <label for="tipoEquipo_nombre">Nombre del Equipo</label>

        <div class="form-group">
            {{ text_field("tipoEquipo_nombre", "size" : 50,'class':'form-control','placeholder':'INGRESE EL NOMBRE') }}
        </div>
        {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
        {% if admin!=1 %}
            {{ hidden_field("tipoEquipo_habilitado", "value" : "1" ) }}
        {% endif %}
    </div>
</div>

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

{{ end_form() }}