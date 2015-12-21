<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Equipo/Pozo</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("equipopozo/new", "Crear Tipo de Equipo",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}

{{ form("equipopozo/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <label for="equipoPozo_id">N° EquipoPozo</label>

    <div class="form-group">
        {{ text_field("equipoPozo_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="equipoPozo_nombre">Nombre </label>

    <div class="form-group">
        {{ text_field("equipoPozo_nombre", "size" : 30) }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("equipoPozo_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
