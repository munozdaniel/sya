<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Buscar planilla</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                <div align="right">
                    {{ link_to("planilla/new", "crear planilla",'class':'btn btn-large btn-danger btn-flat') }}
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
                        <label for="planilla_nombreCliente">Fecha de Creacion</label>
                        <div class="form-group">
                            {{ date_field("planilla_fecha", "type" : "date") }}
                        </div>
                        {# Si no es ADMIN mostrar unicamente los habilitados #}
                        {% if admin!=1 %}
                            {{ hidden_field("planilla_habilitado", "value" : "1" ) }}
                        {% endif %}
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        {{ submit_button("Buscar",'class':'btn btn-large btn-primary btn-flat') }}
                    </div>
                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>



