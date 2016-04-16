<div class="box box-primary">
    <!-- Titulo -->
    <div class="box-header with-border">
        <h3 class="box-title">Buscar planilla</h3>
    </div>
    <!-- /.Titulo -->
    <!-- Formulario-->

    <div align="right">
        {{ link_to("planilla/new", "<i class='fa fa-plus-square'></i> Nueva Planilla ",'class':'btn btn-flat btn-danger') }}
    </div>
    {{ content() }}
    {{ form("planilla/search", "method":"post", "autocomplete" : "") }}
    <div class="box-body">
        <div class="col-md-6 col-md-offset-3">

            <label for="planilla_id">N° Planilla</label>

            <div class="form-group">
                {{ text_field("planilla_id", "type" : "numeric",'class':'form-control','placeholder':'INGRESAR ID PLANILLA') }}
            </div>
            <label for="planilla_nombreCliente">Nombre del Cliente</label>

            <div class="form-group">
                {{ text_field("planilla_nombreCliente", "size" : 30,'class':'form-control','placeholder':'INGRESAR NOMBRE') }}
            </div>
            <label for="planilla_nombreCliente">Fecha de Creación</label>

            <div class="form-group">
                {{ date_field("planilla_fecha", "type" : "date",'class':'form-control','placeholder':'INGRESAR FECHA') }}
            </div>
            {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
            {% if admin!=1 %}
                {{ hidden_field("planilla_habilitado", "value" : "1",'class':'form-control' ) }}
            {% endif %}
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
    </div>
    {{ end_form() }}

</div>
