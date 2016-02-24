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
            ->addCss('https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css',false)
            ->addCss('https://cdn.datatables.net/fixedheader/3.1.1/css/fixedHeader.dataTables.min.css',false)
            ->addCss('https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css',false);
        $this->assets->collection('footer')
            ->addJs('https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js',false)
            ->addJs('https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js',false)
            ->addJs('https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js',false)
            ->addJs('plugins/dataTableEditor/js/dataTables.editor.min.js')

            ->addJs('https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js',false)
            ->addJs('https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js',false)
            ->addJs('https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js',false)
            ->addJs('https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js',false)
            ->addJs('https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js',false)

            ->addJs('https://cdn.datatables.net/fixedheader/3.1.1/js/dataTables.fixedHeader.min.js',false)
            ->addJs('https://cdn.datatables.net/colreorder/1.3.1/js/dataTables.colReorder.min.js',false)
           ;

/*
        $this->assets->collection('footerInline')
            ->addInlineJs("
            $(document).ready(function() {
              var table = $('#example').DataTable({
                'paging':   true,
                'ordering': true,
                'info':     true,
                'colReorder': true,
                fixedHeader: true,
                scrollX:        'true',
                processing: true,
                'serverSide': true,
                 'ajax': {
                      'url': '/sya/remito/ajax',
                      'type': 'POST'
                  },
        'columns': [
            { 'data': 'first_name' },
            { 'data': 'last_name' },
            { 'data': 'position' },
            { 'data': 'office' },
            { 'data': 'start_date' },
            { 'data': 'salary' }
        ]
              });
table.on( 'xhr', function ( e, settings, json ) {
    console.log( 'Ajax event occurred. Returned data: ', json );
} );            $('#example tbody')
                .on( 'mouseenter', 'td', function () {
                    var colIdx = table.cell(this).index().column;
table.colReorder.order( [1 , 0 ,9,10,11,2, 3, 4, 5,6,7,19,20,21,22,8,12,13,14,15,16,17,18,23,24 ], true );
                    $( table.cells().nodes() ).removeClass( 'highlight' );
                    $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
                } );


            } );
        ");*/
    }
    protected function importarJsTable()
    {

        $this->assets->collection('headerCss')
            ->addCss('plugins/bower_components/bootstrap-table/dist/bootstrap-table.min.css')
            ->addCss('https://rawgit.com/akottr/dragtable/master/dragtable.css',false)
            ->addJs('plugins/bower_components/bootstrap-table/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css')
            ->addJs('plugins/bower_components/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css');
        $this->assets->collection('headerJs')
            ->addJs('plugins/bower_components/bootstrap-table/dist/bootstrap-table.min.js')
            ->addJs('plugins/bower_components/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js')
            ->addJs('plugins/bower_components/bootstrap-table/dist/extensions/reorder-columns/bootstrap-table-reorder-columns.min.js')
            ->addJs('js/jquery/jquery-ui.min.js')
            ->addJs('https://rawgit.com/akottr/dragtable/master/jquery.dragtable.js',false)
            ->addJs('js/jquery/jquery.dragtable.js')
            ->addJs('plugins/bower_components/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js')
            ->addJs('//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js',false);
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
           ;
    }
}
