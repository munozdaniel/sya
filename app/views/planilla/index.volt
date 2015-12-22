<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar planilla</h3>
</div><!-- /.Titulo -->
<!-- Formulario-->

<div align="right">
    {{ link_to("planilla/new", "Crear Planilla",'class':'btn btn-large btn-danger btn-flat') }}
</div>
{{ content() }}
{{ form("planilla/search", "method":"post", "autocomplete" : "") }}
    <div class="box-body">
        <label for="planilla_id">N° Planilla</label>

        <div class="form-group">
            {{ text_field("planilla_id", "type" : "numeric") }}
        </div>
        <label for="planilla_nombreCliente">Nombre del Cliente</label>

        <div class="form-group">
            {{ text_field("planilla_nombreCliente", "size" : 30) }}
        </div>
        <label for="planilla_nombreCliente">Fecha de Creación</label>

        <div class="form-group">
            {{ date_field("planilla_fecha", "type" : "date") }}
        </div>
        {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
        {% if admin!=1 %}
            {{ hidden_field("planilla_habilitado", "value" : "1" ) }}
        {% endif %}
    </div><!-- /.box-body -->

    <div class="box-footer">
        {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
    </div>
</form>


