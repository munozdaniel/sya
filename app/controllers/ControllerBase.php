<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('SYA | ');
        //No se usa mas.
        $this->view->setVar("jquery", $this->jquery->genCDNs());

    }

    /**
     * Redireccionamiento
     * @param $uri
     * @return null
     */
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

    /**
     * No se usa mas
     */
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

    /**
     * En uso para los remitos
     */
    protected function importarDataTables()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/css/jquery.dataTables.min.css')
            ->addCss('plugins/datatables/css/buttons.dataTables.min.css')
            ->addCss('plugins/datatables/css/select.dataTables.min.css')
            ->addCss('plugins/datatables/css/fixedHeader.dataTables.min.css')
            // ->addCss('plugins/datatables/css/bootstrap.min.css',false)
            ->addCss('plugins/datatables/css/dataTables.bootstrap.min.css');
        $this->assets->collection('footer')
            ->addJs('plugins/datatables/js/jquery.dataTables.min.js')
            ->addJs('plugins/datatables/js/dataTables.buttons.min.js')
            ->addJs('plugins/datatables/js/buttons.colVis.min.js')
            ->addJs('plugins/datatables/js/dataTables.select.min.js')

            //Excel
            ->addJs('plugins/datatables/excel/jszip.min.js')
            ->addJs('plugins/datatables/excel/pdfmake.min.js')
            ->addJs('plugins/datatables/excel/vfs_fonts.js')
            ->addJs('plugins/datatables/excel/buttons.html5.min.js')
            //Fin:Excel
            ->addJs('plugins/datatables/header-fixed/dataTables.fixedHeader.min.js')
            ->addJs('plugins/datatables/col-reorder/dataTables.colReorder.min.js')
        ;

    }

    /**
     * Dejar de usar
     */
    protected function importarDataTablesCDN()
    {
        $this->assets->collection('headerCss')
            ->addCss('https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css',false)
            ->addCss('https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css',false)
            ->addCss('https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css',false)
            ->addCss('https://cdn.datatables.net/fixedheader/3.1.1/css/fixedHeader.dataTables.min.css',false)
            ->addCss('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',false)
            ->addCss('https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css',false);
        $this->assets->collection('footer')
            ->addJs('https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js',false)
            ->addJs('https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js',false)
            ->addJs('//cdn.datatables.net/buttons/1.1.2/js/buttons.colVis.min.js',false)
            ->addJs('https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js',false)

            //Excel
            ->addJs('https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js',false)
            ->addJs('https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js',false)
            ->addJs('https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js',false)
            ->addJs('https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js',false)
           //Fin:Excel
            ->addJs('https://cdn.datatables.net/fixedheader/3.1.1/js/dataTables.fixedHeader.min.js',false)
            ->addJs('https://cdn.datatables.net/colreorder/1.3.1/js/dataTables.colReorder.min.js',false)
           ;

    }

    /**
     * Sin uso todavia
     */
    protected function importarDataTablesEditor()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/datatables/css/jquery.dataTables.min.css')
            ->addCss('plugins/Editor/css/editor.dataTables.min.css')
            ->addCss('plugins/datatables/css/buttons.dataTables.min.css')
            ->addCss('plugins/datatables/css/select.dataTables.min.css')
            ->addCss('plugins/datatables/css/fixedHeader.dataTables.min.css')
            // ->addCss('plugins/datatables/css/bootstrap.min.css',false)
            ->addCss('plugins/datatables/css/dataTables.bootstrap.min.css');
        $this->assets->collection('footer')
            ->addJs('plugins/datatables/js/jquery.dataTables.min.js')
            ->addJs('plugins/Editor/js/dataTables.editor.min.js')
            ->addJs('plugins/datatables/js/dataTables.buttons.min.js')
            ->addJs('plugins/datatables/js/buttons.colVis.min.js')
            ->addJs('plugins/datatables/js/dataTables.select.min.js')

            //Excel
            ->addJs('plugins/datatables/excel/jszip.min.js')
            ->addJs('plugins/datatables/excel/pdfmake.min.js')
            ->addJs('plugins/datatables/excel/vfs_fonts.js')
            ->addJs('plugins/datatables/excel/buttons.html5.min.js')
            //Fin:Excel
            ->addJs('plugins/datatables/header-fixed/dataTables.fixedHeader.min.js')
            ->addJs('plugins/datatables/col-reorder/dataTables.colReorder.min.js')
        ;

    }

    /**
     * Select Autocompletar
     */
    protected function importarSelect2()
    {
        $this->assets->collection('headerCss')
            ->addCss('plugins/select2/select2.min.css')
            ->addCss('plugins/select2/select2-bootstrap.min.css');
        $this->assets->collection('footer')
            ->addJs('plugins/select2/select2.full.min.js');
    }

    /**
     * Usado en las tablas Gestionar
     */
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
            ->addJs('plugins/bower_components/bootstrap-table/dist/extensions/export/bootstrap-table-export.js')
            ->addJs('//rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js',false);
        $this->assets->collection('footerInline')
            ->addInlineJs('
            $(document).on("click", ".enviar-dato", function () {
                var id = $(this).data("id");
                $("#cuerpo #id").val( id );
            });
        ');
    }
}
