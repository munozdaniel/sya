<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Operadora</h3>
</div><!-- /.Titulo -->
<!-- Formulario -->
{{ content() }}
{{ form("operadora/create", "method":"post") }}
<table width="100%">
    <tr>
        <td align="left">
            {{ link_to("operadora", "VOLVER",'class':'btn btn-flat btn-large bg-olive') }}
        </td>
    </tr>
</table>

<!-- Cuerpo -->
<div class="box-body">

    {#==================================================#}
    <div class="col-md-6 col-md-offset-3">
        {#======================================================#}
        {% for element in operadoraForm %}
            {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
                {{ element }}
            {% else %}
                <div class="form-group">
                    {{ element.label() }}
                    {{ element.render() }}
                </div>
            {% endif %}
        {% endfor %}
        {#======================================================#}

    </div>
</div><!-- /. Cuerpo -->

<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>

