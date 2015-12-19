<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Archivo</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("archivo/new", "Subir Archivo",'class':'btn btn-large btn-danger btn-flat') }}
</div>
{{ content() }}

{{ form("archivo/search", "method":"post", "autocomplete" : "off") }}
<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <label for="archivo_id">N° de Archivo</label>

    <div class="form-group">
        {{ text_field("archivo_id", "type" : "numeric") }}
    </div>
    {#===============================================#}
    <label for="chofer_nombreCompleto">Nombre de Archivo</label>

    <div class="form-group">
        {{ text_field("archivo_nombre", "size" : 30) }}
    </div>
    {#===============================================#}
    <label for="archivo_fechaCreacion">Fecha de Creación</label>

    <div class="form-group">
        {{ date_field("archivo_fechaCreacion") }}
    </div>
    {#===============================================#}

</div><!-- /.Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>

