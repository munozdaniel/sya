<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Buscar Operadora</h3>
</div><!-- /.Titulo -->
<div align="right">
    {{ link_to("operadora/new", "Nueva Operadora",'class':'btn btn-large btn-danger btn-flat') }}
</div>
<!-- Inicio Formulario -->
{{ content() }}
{{ form("operadora/search", "method":"post", "autocomplete" : "off") }}


<!-- Cuerpo -->
<div class="box-body">
    {#===============================================#}
    <div class="row form-group">
        <div class="col-md-3">
            <label for="operadora_id">N° de Operadora</label>
        </div>
        <div class="col-md-6">
            {{ text_field("operadora_id", "type" : "numeric",'class':'form-control','placeholder':'INGRESE EL N° DE OPERADORA') }}
        </div>
    </div>

    {#===============================================#}
    <div class="row form-group">
        <div class="col-md-3">
            <label for="operadora_nombre">Nombre </label>
        </div>
        <div class="col-md-6">
            {{ text_field("operadora_nombre", "size" : 30,'class':'form-control','placeholder':'INGRESE EL NOMBRE') }}
        </div>
    </div>
    {#===============================================#}
    <div class="row form-group">
        <div class="col-md-3">
            <label for="operadora_yacimientoId">Yacimiento </label>
        </div>
        <div class="col-md-6">
            {{ operadoras.render() }}
        </div>
    </div>

    {# EN LA BUSQUEDA Si no es ADMIN mostrar unicamente los habilitados = 1#}
    {% if admin!=1 %}
        {{ hidden_field("operadora_habilitado", "value" : "1",'class':'form-control' ) }}
    {% endif %}
</div><!-- /.Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Buscar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>

<script>
    $(function () {
        $(".autocompletar").select2();
    });
</script>