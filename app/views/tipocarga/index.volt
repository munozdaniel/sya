<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Tipo de Carga</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("tipocarga/new", "Nuevo Tipo de Carga",'class':'btn btn-large btn-danger btn-flat') }}
</div>

<!-- Inicio Formulario -->
{{ content() }}
{{ form("tipocarga/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        {#===============================================#}
        <label for="tipoCarga_id">N° Tipo de Carga</label>

        <div class="form-group">
            {{ text_field("tipoCarga_id", "type" : "numeric",'class':'form-control','placeholder':'INGRESE EL ID') }}
        </div>
        {#===============================================#}
        <label for="tipoCarga_nombre">Nombre de la Carga</label>

        <div class="form-group">
            {{ text_field("tipoCarga_nombre", "size" : 50,'class':'form-control','placeholder':'INGRESE EL NOMBRE') }}
        </div>
        {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
        {% if admin!=1 %}
            {{ hidden_field("tipoCarga_habilitado", "value" : "1" ) }}
        {% endif %}
    </div>
</div>
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
