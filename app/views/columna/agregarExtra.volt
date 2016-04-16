<div class="box box-primary">
    <div class="box-header with-border">
        <h2 class="box-title">AGREGAR COLUMNAS EXTRAS
            <br>
            <small> Seleccione la cabecera e ingrese las columnas extras </small>
        </h2>

    </div>
    {{ content() }}

    {{ form("columna/guardarExtra","id":"form-extras", "method":"post") }}
    <fieldset id="fielset-buscar-planilla" class="panel-border">
        <legend>SYA</legend>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="form-group">
                        <label>Nombre de la cabecera</label>
                        {{ formulario.render() }}
                    </div>
                    <div class="form-group">
                        {{ partial('columna/parcial/extra') }}
                    </div>
                </div>
            </div>

        </div>
    </fieldset>
    {{ end_form() }}
</div>

<script>
    $('#extra').prop('disabled', false);
    $(function () {
        $(".autocompletar").select2();
    });
</script>