<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Planilla</h3>
</div><!-- /.Titulo -->

<div align="right">
    {{ link_to("yacimiento/new", "Crear Yaciiento",'class':'btn btn-large btn-danger btn-flat') }}
</div>

<!-- Inicio Formulario -->
{{ content() }}
{{ form("yacimiento/search", "method":"post", "autocomplete" : "off") }}
<!-- Cuerpo -->
<div class="box-body">
    <label for="yacimiento_id"> N° de Yacimiento</label>

    <div class="form-group">
        {{ text_field("yacimiento_id", "type" : "numeric") }}
    </div>
    {#===================================================#}
    <label for="yacimiento_destino">Destino</label>

    <div class="form-group">
        {{ text_field("yacimiento_destino", "size" : 30) }}
    </div>

    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("yacimiento_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
