<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Cliente</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("cliente/new", "Nuevo Cliente",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("cliente/search", "method":"post", "autocomplete" : "off") }}

<!-- Cuerpo -->
<div class="box-body">
    {% if formulario is defined %}
        <div class="row form-group">
            <div class="col-md-3">
                <label>Nombre del cliente</label>
            </div>
            <div class="col-md-6">
                {{ formulario.render() }}
            </div>
        </div>
        <div class="row form-group">
            {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
            {% if admin!=1 %}
                {{ hidden_field("cliente_habilitado", "value" : "1" ) }}
            {% else %}
                <div class="col-md-3">
                    <label>Habilitado/Deshabilitado</label>
                </div>
                <div class="col-md-6">
                    {{ select('cliente_habilitado',['':'TODOS','1':'CLIENTES HABILITADOS','0':'CLIENTES DESHABILITADOS'],'class':'form-control') }}
                </div>
            {% endif %}
        </div>
    {% endif %}
    {#===============================================#}

</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("BUSCAR CLIENTE",'class':'btn btn-lg btn-primary btn-flat') }}
</div>
<script>
    /**************** select autocomplete *******************/
    $(function () {
        $(".autocompletar").select2();
    });
</script>