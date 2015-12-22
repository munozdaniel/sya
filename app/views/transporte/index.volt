<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Transporte</h3>
</div><!-- /.Titulo -->


<div align="right">
    {{ link_to("transporte/new", "Crear Yacimiento",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("transporte/search", "method":"post", "autocomplete" : "off") }}
<!-- Cuerpo -->
<div class="box-body">
    <label for="transporte_id">N° Transporte</label>

    <div class="form-group">
        {{ text_field("transporte_id", "type" : "numeric") }}
    </div>
    {#===================================================#}
    <label for="transporte_dominio">Dominio</label>

    <div class="form-group">
        {{ text_field("transporte_dominio", "size" : 30) }}
    </div>
    {#===================================================#}
    <label for="transporte_nroInterno">N° de Interno</label>

    <div class="form-group">
        {{ text_field("transporte_nroInterno", "type" : "numeric") }}
    </div>
    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("transporte_habilitado", "value" : "1" ) }}
    {% endif %}
</div><!-- /.Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
