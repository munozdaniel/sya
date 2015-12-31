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
                            <label for="operadora_nombre" class="">Nombre Operadora</label>
                        </div>

                        <div class="form-group">
                            {{ text_field("operadora_nombre", "size" : 30,'form':'agregar','class':'text-black') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ form('operadora/agregar','id':'agregar','method':'POST') }}
                <div  id="cuerpo">
                    {{ submit_button('Agregar','class':'btn btn-outline') }}
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--===========  MODAL CREAR OPERADORA ================-->
