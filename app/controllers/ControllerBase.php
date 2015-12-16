<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
        $this->tag->prependTitle('SYA | ');
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
}
