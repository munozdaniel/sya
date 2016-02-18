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

    protected function importarJsSearch()
    {
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

    protected function importarDataTables()
    {
        $this->assets->collection('headerCss')
            ->addCss('https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css',false)
            ->addCss('https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css',false);
        $this->assets->collection('footer')
            ->addJs('https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js',false)
            ->addJs('https://cdn.datatables.net/colreorder/1.3.1/js/dataTables.colReorder.min.js',false);

        $this->assets->collection('footerInline')
            ->addInlineJs("
            $(document).ready(function() {
              var table = $('#example').DataTable({
                'paging':   true,
                    'ordering': true,
                    'info':     true,
                   'colReorder': true,
              });
            $('#example tbody')
                .on( 'mouseenter', 'td', function () {
                    var colIdx = table.cell(this).index().column;
table.colReorder.order( [1 , 0 ,9,10,11,2, 3, 4, 5,6,7,19,20,21,22,8,12,13,14,15,16,17,18,23,24 ], true );
                    $( table.cells().nodes() ).removeClass( 'highlight' );
                    $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
                } );


            } );
        ");
    }
    protected function importarJsTable()
    {

        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/dataTables.bootstrap.css');
        $this->assets->collection('headerJs')
            ->addJs('js/bootstrap-table.js')
            ->addJs('js/cookie/bootstrap-table-cookie.js')
            ->addJs('js/reorder/bootstrap-table-reorder-columns.js')
            ->addJs('js/reorder/jquery-ui.js')
            ->addJs('js/reorder/jquery.dragtable.js')
            ->addJs('js/sticky/bootstrap-table-sticky-header.js')
            ->addJs('js/export/bootstrap-table-export.js')
            ->addJs('js/export/tableExport.js');
        $this->assets->collection('footerInline')
            ->addInlineJs('
            $(document).on("click", ".enviar-dato", function () {
                var id = $(this).data("id");
                $("#cuerpo #id").val( id );
            });
        ')
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
