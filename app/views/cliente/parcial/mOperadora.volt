<!--=========== MODAL CREAR OPERADORA ================-->
<div id="nuevaOperadora" class="modal fade modal-info">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa   fa-pencil"></i> NUEVO</h4>
            </div>
            <div class="modal-body margin-left-right-one"
                 style="border-left: 0 !important; border-right: 0 !important;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 ">
                        <!-- START SUBSCRIBE HEADING -->
                        <div class="heading">
                            <span id="mensaje"></span><br>
                            <label for="operadora_nombre" class="">Nombre Operadora</label>
                        </div>

                        <div class="form-group">
                            {{ text_field("operadora_nombreNew", "size" : 30,'class':'text-black') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                <div  id="cuerpo">
                    {{ submit_button('Agregar','id':'agregarOperadora','class':'btn btn-outline') }}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--===========  MODAL CREAR OPERADORA ================-->
<script>
    $(document).ready(function () {
        $("#agregarOperadora").click(function (event) {
            var value = document.getElementById('operadora_nombreNew').value;
            var getResultsUrl = '/sya/operadora/agregar';
            $.ajax({
                data: {"operadora_nombreNew": value},
                method: "POST",
                url: getResultsUrl,
                success: function (response) {

                    $('#list_cliente_operadoraID').load(document.URL +  ' #list_cliente_operadoraID');
                    document.getElementById("mensaje").innerHTML = "<div class='alert alert-info' ><i class='fa fa-fw fa-thumbs-up'></i> <br> OPERACIÓN EXITOSA <br>  Si desea puede continuar agregando nuevos items  </div>";  // Agrego nueva linea antes
                    console.log(response);
                },
                error: function (error) {
                    document.getElementById("mensaje").innerHTML = error.statusText;  // Agrego nueva linea antes
                    console.log(error);
                }
            });
        });
    });
</script>