<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('SYA | ');
        $this->view->setVar("jquery", $this->jquery->genCDNs());

    }

    protected function redireccionar($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1],
                'params' => $params
            )
        );
    }
    protected function importarJsSearch(){
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/dataTables.bootstrap.css');
        $this->assets->collection('footer')
            ->addJs('plugins/datatables/jquery.dataTables.min.js')
            ->addJs('plugins/datatables/dataTables.bootstrap.min.js');
        $this->assets->collection('footerInline')
            ->addInlineJs('
            $(function () {
            $("#tabla_id").DataTable();
            });')
            ->addInlineJs('
            $(document).on("click", ".enviar-dato", function () {
                var id = $(this).data("id");
                $("#cuerpo #id").val( id );
            });
        ');
    }
    protected function importarJsTable(){

        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/dataTables.bootstrap.css');
        $this->assets->collection('headerJs')
            ->addJs('js/bootstrap-table.js')
            ->addJs('js/reorder/bootstrap-table-reorder-columns.js')
            ->addJs('js/reorder/jquery-ui.js')
            ->addJs('js/reorder/jquery.dragtable.js')
            ->addJs('js/sticky/bootstrap-table-sticky-header.js')
            ->addJs('js/export/bootstrap-table-export.js')
            ->addJs('js/export/tableExport.js');
        $this->assets->collection('footerInline')
            ->addInlineJs("/*Exportar*/
    var table = $('#tabla');
    $(function () {
        $('#toolbar').find('select').change(function () {
            table.bootstrapTable('refreshOptions', {
                exportDataType: $(this).val()
            });
        });
    })")
            ->addInlineJs("/*Scroll Arriba y Abajo*/
    var
        button = $('#botonTop'),
       button2 = $('#botonBottom');

    $(function () {
        button.click(function () {
            table.bootstrapTable('scrollTo', 0);
        });
        button2.click(function () {
            table.bootstrapTable('scrollTo', 'bottom');
        });
    });");
    }
}
