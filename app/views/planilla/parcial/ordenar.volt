<div id="pnl_ordenar">
    {{ form('planilla/finalizar','id':'finalizar','method':'post') }}
        <fieldset id="ordenar" class="panel-border" disabled>

            <legend>Ordenar Columnas <small>(opcional)</small></legend>
                <input type="hidden" id="token_ordenar" name="<?php echo $this->security->getTokenKey() ?>"
                       value="<?php echo $this->security->getToken() ?>"/>

            <script type="text/javascript">
                // Guarda el nuevo orden de las columnas
                $(document).ready(function () {
                    $("#ul_columnas").sortable({
                        handle: '.handle',
                        update: function () {
                            var order = $('#ul_columnas').sortable('serialize');
                            $("#info").load("ordenar?" + order);
                        }
                    });
                });
            </script>
            <div class="col-md-12">
            <div class="contenedor-lista">
                <ol id="ul_columnas">
                    <!--li id="listItem_1">
                        <a class="handle">
                            <strong>Item 1 </strong>
                        </a>
                    </li-->
                </ol>
            </div>
            </div>
            <pre>
                <div id="info"><em>El orden asignado se guardará para generar las planillas Excel</em></div>
            </pre>
            <div align="center">
                {{ submit_button('FINALIZAR LA CREACIÓN DE LA PLANILLA','class':'btn btn-flat btn-lg btn-primary') }}
            </div>
        </fieldset>
    {{ end_form() }}
</div>
<!-- ====================================== -->
