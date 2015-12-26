<!-- Titulo -->
<div class="box-header with-border">
    <h3 class="box-title">Crear Centro Costo</h3>
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
<div id="perro" class="box-body">
    {% for element in clienteForm %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            {{ element.label() }}
            <div class="form-group">
                {{ element.render(['class': '']) }}
            </div>
        {% endif %}
    {% endfor %}
    {#===============================================#}
    <div class="col-md-12">
        {{ select("provincia", provincia, 'using': ['linea_id', 'linea_nombre']) }}

        {{ select('ciudad', ciudad,'useEmpty': true, 'emptyText': 'Seleccione una ciudad...','emptyValue': '@') }}
    </div>
</div><!-- /. Cuerpo -->
<!-- Footer -->
<div class="box-footer">
    {{ submit_button("Guardar",'id':'submit','class':'btn btn-large btn-primary btn-flat') }}
</div>
</form>
<script >
    $("#provincia").change(function (event) {
        var value = $(this).val();

        var getResultsUrl = 'buscarCiudades';
        $.ajax({
            data: {"provincia": value},
            method: "POST",
            url: "<?php echo $this->url->get('cliente/buscar') ?>",
            success: function (response) {
                $("#ciudad").empty();
                parsed = $.parseJSON(response);
                var html = "";
                for(datos in parsed.listaCiudades)
                {
                    html += '<option value="'+parsed.listaCiudades[datos]['centroCosto_id']+'">'+
                    parsed.listaCiudades[datos]['centroCosto_codigo']+'</option>';

                }
                $('select#ciudad').html(html);

                console.log(response);


            },
            error: function (error) {
                alert("ERROR : "+error.statusText) ;
                console.log(error);
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
    $("#centroCosto_linea").blur(function (event) {

        var value = document.getElementById('centroCosto_lineaId').value ;
        alert("LEER HIDDEN "+value);
        var getResultsUrl = 'cliente/buscarCentroCosto';
        $.ajax({
            data: {"id": value},
            method: "POST",
            url: "<?php echo $this->url->get('cliente/buscarCentroCosto') ?>",
            success: function (response) {
                $("#cliente_centroCosto").empty();
                parsed = $.parseJSON(response);
                var html = "";

                for(datos in parsed.lista)
                {
                    html += '<option data-value="'+parsed.lista[datos]['centroCosto_id']+'" value="'+parsed.lista[datos]['centroCosto_codigo']+'"></option>';
                }
                $('datalist#list_cliente_centroCosto').html(html);

                console.log(response);


            },
            error: function (error) {
                alert("ERROR : "+error.statusText) ;
                console.log(error);
            }
        });
    })});
</script>
