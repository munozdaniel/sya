<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><strong>AGREGAR COLUMNAS EXTRAS</strong></h3>
    </div>
    <!-- /.Titulo -->
    <!-- Formulario -->

    {{ flashSession.output() }}
    {{ content() }}
    {{ form("planilla/createColumnas", "method":"post") }}
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td align="left">
                {{ link_to("planilla/index", "<i class='fa fa-search'></i> Busqueda Personalizada",'class':'btn btn-flat btn-large bg-olive') }}
            </td>
            <td align="right">
                {{ link_to("planilla/ordenar", "<i class='fa  fa-share'></i> Saltar, ordenar columnas",'class':'btn btn-flat btn-large btn-warning') }}
            </td>
        </tr>
    </table>
    <!-- Cuerpo -->
    <div class="box-body">
        <hr>

        <div class="col-md-4" style="margin-top:40px;">
        <a id="agregarCampo" class="btn btn-info" href="#">Agregar Campo</a>
        </div>
        <div id="contenedor"class="col-md-6">
            <div class="added" >
                <input type="text" name="columna[]" id="extra_1" placeholder="Columna Extra 1" class="form-control"/>
                <a href="#" class="eliminar">[&times;] Eliminar</a>
            </div>

        </div>
    </div>
    <!-- Footer -->
    <div class="box-footer">

        {{ submit_button("Guardar",'class':'btn btn-large btn-primary btn-flat') }}
    </div>
    </form>
</div>

<!-- ====================================== -->
<script>
    $(document).ready(function() {

        var MaxInputs       = 8; //Número Maximo de Campos
        var contenedor       = $("#contenedor"); //ID del contenedor
        var AddButton       = $("#agregarCampo"); //ID del Botón Agregar

        //var x = número de campos existentes en el contenedor
        var x = $("#contenedor div").length + 1;
        var FieldCount = x-1; //para el seguimiento de los campos

        $(AddButton).click(function (e) {
            if(x <= MaxInputs) //max input box allowed
            {
                FieldCount++;
                //agregar campo
                $(contenedor).append('<div><input type="text" name="columna[]" class="form-control" id="extra_'+ FieldCount +'" placeholder="Columna Extra '+ FieldCount +'"/><a href="#" class="eliminar">[&times;] Eliminar</a></div>');
                x++; //text box increment
            }
            return false;
        });

        $("body").on("click",".eliminar", function(e){ //click en eliminar campo
            if( x > 1 ) {
                $(this).parent('div').remove(); //eliminar el campo
                x--;
            }
            return false;
        });
    });
</script>