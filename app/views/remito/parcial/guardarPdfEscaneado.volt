
<!--=========== AgregarRemitoEscaneado ================-->
<div id="agregarRemitoEscaneado" class="modal fade modal-primary">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa   fa-hand-stop-o"></i> AGREGAR REMITO ESCANEADO</h4>
            </div>
            <div class="modal-body margin-left-right-one"
                 style="border-left: 0 !important; border-right: 0 !important;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 ">
                        <!-- START SUBSCRIBE HEADING -->
                        <div class="heading">
                            <h3 class="wow fadeInLeftBig">Seleccione el Remito escaneado desde el Servidor </h3>
                            <p>Recuerde que el remito escaneado debe ser en PDF.</p>
                        </div>
                        <div class="col-md-12 form-group">

                            <input type="file" id="remito_pdf" name="remito_pdf" data-max-size='3mb' class="form-control" form="submit-pdf">

                            <script>
                                $('input[type=file]').fileValidator({
                                    onValidation: function(files){      $(this).attr('class','');          },
                                    onInvalid:    function(type, file){ $(this).addClass('invalid '+type); },
                                    maxSize:      '3m',
                                    type:           'pdf'
                                });

                            </script>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-navy btn-flat pull-left" data-dismiss="modal">CERRAR</button>
                {{ form('','id':'submit-pdf','method':'POST','enctype':'multipart/form-data') }}
                <div id="cuerpo">
                    {{ hidden_field('id','value':'','form') }}
                    {{ submit_button('GUARDAR','class':'btn btn-outline') }}
                </div>
                {{ end_form() }}
            </div>
        </div>
    </div>
</div>
<!--=========== FIN:AgregarRemitoEscaneado ================-->
<script>
    /**
     * Al hacer click sobre el boton que tenga la clase "enviar-dato" se guardará el valor en el hidden_field 'id'
     */
    $(document).on("click", ".enviar-dato", function () {
        var id = $(this).data("id");
        $("#cuerpo #id").val( id );
    });
    // this is the id of the form
    $("#submit-pdf").submit(function(e) {
        //Metodo para enviar el input file
        var file_data = $('#remito_pdf').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('planilla_id', document.getElementById("remito_planillaId").value);
        form_data.append('remito_id', document.getElementById("id").value);

        var url = "/sya/remito/guardarRemitoEscaneado"; // the script where you handle the form input.

        $.ajax({
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            url: url,
            success: function(data)
            {
                console.log(data); // show response from the php script.
                if(data.success)
                    alert("VERDADERO");
                $('#agregarRemitoEscaneado').modal('toggle');
                //$('#example').ajax.reload();
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });
</script>
