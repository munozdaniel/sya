<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Ingresar el CLIENTE</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("cliente/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("cliente", "VOLVER",'class':'btn btn-flat btn-large btn-warning') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="col-md-6 col-md-offset-3 box-body">
    {% for element in clienteForm %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            <div class="col-md-12">
                {{ element }}
            </div>
        {% else %}
            {% if loop.index==2%}
                <div class="col-md-12">
            {% else %}
                <div class="col-md-6">
            {% endif %}
                {{ element.label() }}
                <div class="form-group">
                    {{ element.render(['class': '']) }}
                </div>
            </div>
        {% endif %}
    {% endfor %}
    {#===============================================#}
</div><!-- /. Cuerpo -->
<!-- Footer -->

<div class="box-footer">
    <div class="col-md-12">

        {{ submit_button('GUARDAR','id':'submit','class':'btn btn-large btn-primary btn-flat') }}
    </div>
</div>
</form>
