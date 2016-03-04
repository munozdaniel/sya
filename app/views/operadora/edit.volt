<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Editar Operadora</h3>
</div><!-- /.Titulo -->
<!-- Inicio Formulario -->

{{ content() }}
{{ form("operadora/save", "method":"post") }}

<table width="100%">
    <tr>
        <td align="left">{{ link_to("equipopozo", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}</td>
    </tr>
</table>
<!-- Cuerpo -->
<div class="box-body">
    {% for element in operadoraForm %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            {{ element.label() }}
            <div class="form-group">
                {{ element.render(['class': '']) }}
            </div>
        {% endif %}
    {% endfor %}

</div><!-- /.Cuerpo -->

<!-- Inicio Footer -->
<div class="box-footer">
    {{ hidden_field("operadora_id") }}
    {{ submit_button("Guardar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>

