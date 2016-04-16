<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Equipo/Pozo</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->
{{ content() }}
{{ form("equipopozo/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("equipopozo", "Búsqueda Personalizada",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">
    <div class="col-md-6 col-md-offset-3">

        {% for element in equipoPozoForm %}
            {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
                {{ element }}
            {% else %}
                {{ element.label() }}
                <div class="form-group">
                    {{ element.render(['class': 'form-control']) }}
                </div>
            {% endif %}
        {% endfor %}

    </div>
</div><!-- /.Cuerpo -->


<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("equipoPozo_id") }}
    {{ submit_button("Guardar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>
{{ end_form() }}
<script>
    function habilitarNuevoYacimiento(nuevoYacimiento) {
        $("#nuevo").toggle();
        $("#equipoPozo_yacimiento").toggle();
    }
</script>