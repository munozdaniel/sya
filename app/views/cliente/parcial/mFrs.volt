<!--=========== MODAL CREAR OPERADORA ================-->
<div id="nuevoFrs" class="modal fade modal-info" tabindex="3    ">

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
                            <span id="mensajeFRS"></span><br>
                            <label for="operadora_nombre" class="">Codigo FRS</label>
                        </div>

                        <div class="form-group">
                            {{ text_field("frs_codigoNew", "size" : 30,'class':'text-black','autofocus':'') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                <div  id="cuerpo">
                    {{ submit_button('Agregar','id':'agregarFRS','class':'btn btn-outline') }}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--===========  MODAL CREAR OPERADORA ================-->
<script>
    $('#nuevoFrs').on('shown.bs.modal', function () {
        setTimeout(function (){
            $('#frs_codigoNew').focus();
        }, 1000);
    });
    $(document).ready(function () {

        $("#agregarFRS").click(function (event) {
            var value = document.getElementById('frs_codigoNew').value;
            var getResultsUrl = '/sya/frs/agregar';
            $.ajax({
                data: {"frs_codigo": value},
                method: "POST",
                url: getResultsUrl,
                success: function (response) {

                    $('#list_cliente_frsId').load(document.URL +  ' #list_cliente_frsId');
                    document.getElementById("mensajeFRS").innerHTML = "<div class='alert alert-info' ><i class='fa fa-fw fa-thumbs-up'></i> <br> OPERACIÓN EXITOSA <br>  Si desea puede continuar agregando nuevos items  </div>";  // Agrego nueva linea antes
                    console.log(response);
                },
                error: function (error) {
                    document.getElementById("mensajeFRS").innerHTML = error.statusText;  // Agrego nueva linea antes
                    console.log(error);
                }
            });
        });
    });
</script>