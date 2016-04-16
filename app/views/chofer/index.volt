<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Chofer</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("chofer/new", "Nuevo Chofer",'class':'btn btn-large btn-danger btn-flat') }}
</div>
{{ content() }}
{{ form("chofer/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        {#===============================================#}
        <label for="chofer_id">N° de Chofer</label>

        <div class="form-group">
            {{ text_field("chofer_id", "type" : "numeric",'class':'form-control','placeholder':'INGRESE EL ID') }}
        </div>
        {#===============================================#}
        <label for="chofer_nombreCompleto">Nombre Completo</label>

        <div class="form-group">
            {{ text_field("chofer_nombreCompleto", "size" : 100,'class':'form-control','placeholder':'INGRESE EL NOMBRE') }}
        </div>
        {#===============================================#}
        <label for="chofer_dni">Nro de Documento</label>

        <div class="form-group">
            {{ text_field("chofer_dni", "type" : "numeric",'class':'form-control','placeholder':'INGRESE EL DNI') }}
        </div>
        {#===============================================#}
        <label for="fletero">Fletero</label>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="chofer_esFletero" name="chofer_esFletero" value="1">
                    SI
                </label>
                <label>
                    <input type="checkbox" id="chofer_esFletero" name="chofer_esFletero" value="0">
                    NO
                </label>
                <label>
                    <input type="checkbox" id="chofer_esFletero" name="chofer_esFletero" value="" checked>
                    AMBOS
                </label>
            </div>

        </div>
        {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
        {% if admin!=1 %}
            {{ hidden_field("chofer_habilitado", "value" : "1" ) }}
        {% endif %}
    </div>
</div>
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
</div>

</form>
