<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Planilla</h3>
</div><!-- /.Titulo -->

<div align="right">
    {{ link_to("viaje/new", "Crear Viaje",'class':'btn btn-large btn-danger btn-flat') }}
</div>

<!-- Inicio Formulario -->
{{ content() }}
{{ form("viaje/search", "method":"post", "autocomplete" : "off") }}
<!-- Cuerpo -->
<div class="box-body">
    <label for="viaje_id">Viaje N°</label>

    <div class="form-group">
        {{ text_field("viaje_id", "type" : "numeric") }}
    </div>
    {#===================================================#}
    <label for="viaje_origen">Origen</label>

    <div class="form-group">
        {{ text_field("viaje_origen", "size" : 30) }}
    </div>
    {#===================================================#}
    <label for="viaje_concatenado">Concatenado</label>

    <div class="form-group">
        {{ text_field("viaje_concatenado", "size" : 30) }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("viaje_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
