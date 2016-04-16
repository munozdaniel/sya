<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Linea</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("linea/new", "Crear Linea",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("linea/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        {#===============================================#}
        <label for="linea_id">N° de Linea</label>

        <div class="form-group">
            {{ text_field("linea_id", "type" : "numeric",'class':'form-control', 'placeholder':'INGRESAR ID LINEA') }}
        </div>
        {#===============================================#}
        <label for="linea_nombre">Nombre </label>

        <div class="form-group">
            {{ text_field("linea_nombre", "size" : 50,'class':'form-control','placeholder':'INGRESAR NOMBRE') }}
        </div>
        {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
        {% if admin!=1 %}
            {{ hidden_field("linea_habilitado", "value" : "1",'class':'form-control','placeholder':'INGRESAR 1/0' ) }}
        {% endif %}
    </div>
</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>
