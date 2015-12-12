<?php

/**
 * Class IndexController
 * Inicio del sistema, donde se solicitan los datos para ingresar. Se encarga de validar y chequear los permisos.
 * Permite recuperar los datos, en caso que se hayan olvidado, se les envia un correo con dichos datos recuperados desde
 * la base de datos.
 */
class IndexController extends ControllerBase
{
    public function initialize()
    {
        parent::initialize();

    }

    /**
     * Inicio de Sesion: Solicita usuario y contraseña.
     */
    public function indexAction()
    {
        $this->tag->setTitle('Iniciar Sesión');
        $this->assets->collection('footer')->addJs('plugins/iCheck/icheck.min.js');
        $this->assets->collection('footerInline')->addInlineJs(" $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });");
    }


    /**
     * Tablero Principal, donde se mostraran las operaciones primordiales del sistema.
     */
    public function dashboardAction()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Tablero Principal');


    }

    /**
     * Generar un excel de prueba.
     */
    public function generarExcelAction(){
        /** Incluir la libreria PHPExcel */

        // Crea un nuevo objeto PHPExcel
                $objPHPExcel = new PHPExcel();

        // Establecer propiedades
                $objPHPExcel->getProperties()
                    ->setCreator("Cattivo")
                    ->setLastModifiedBy("Cattivo")
                    ->setTitle("Documento Excel de Prueba")
                    ->setSubject("Documento Excel de Prueba")
                    ->setDescription("Demostracion sobre como crear archivos de Excel desde PHP.")
                    ->setKeywords("Excel Office 2007 openxml php")
                    ->setCategory("Pruebas de Excel");

        // Agregar Informacion
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Valor 1')
                    ->setCellValue('B1', 'Valor 2')
                    ->setCellValue('C1', 'Total')
                    ->setCellValue('A2', '10')
                    ->setCellValue('C2', '=sum(A2:B2)');

        // Renombrar Hoja
                $objPHPExcel->getActiveSheet()->setTitle('Tecnologia Simple');

        // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
                $objPHPExcel->setActiveSheetIndex(0);

        // Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

}

