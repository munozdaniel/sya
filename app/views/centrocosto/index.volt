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
    {#===============================================#}
    <label for="centroCosto_id">N° Centro Costo</label>

    <div class="form-group">
        {{ text_field("centroCosto_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="centroCosto_codigo">Codigo</label>

    <div class="form-group">
        {{ text_field("centroCosto_codigo", "size" : 30) }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("centroCosto_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->
<!-- /.Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
