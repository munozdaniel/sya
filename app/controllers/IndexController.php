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
        //$this->assets->collection('footer')->addJs('plugins/iCheck/icheck.min.js');
        /*$this->assets->collection('footerInline')->addInlineJs(" $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });");
        */
    }


    /**
     * Tablero Principal, donde se mostraran las operaciones primordiales del sistema.
     */
    public function dashboardAction()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Tablero Principal');
        $this->view->form = new ClienteForm();
        $this->flash->success("Bienvenido ".$this->session->get('auth')['usuario_nick']);
    }

    /**
     * Generar un excel de prueba.
     */
    public function generarExcelAction()
    {
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

    public function uploadAction()
    {

        #Verifica si existen archivos para subir
        if ($this->request->hasFiles() == true) {
            $uploads = $this->request->getUploadedFiles();
            $isUploaded = false;
            #Por cada archivo subido:
            $nombreCarpeta = 'temp/'.Date('Y_m_d');
            if (!file_exists($nombreCarpeta)) {
                mkdir($nombreCarpeta, 0777, true);
            }
            $this->flash->success($nombreCarpeta);
            foreach ($uploads as $upload) {
                #define a “unique” name and a path to where our file must go
                $path = $nombreCarpeta.'/' .date('h_i_s').'_'. strtolower($upload->getname());
                #move the file and simultaneously check if everything was ok
                ($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
            }
            #if any file couldn’t be moved, then throw an message
            ($isUploaded) ? $this->flash->success('Carga Satisfactoria.') : $this->flash->error('Ha ocurrido un error, intentar nuevamente.');
        } else {
            #if no files were sent, throw a message warning user
            $this->flash->warning('Debes seleccionar los archivos que vas a subir al servidor. Intenta de nuevo.');
        }
        return $this->redireccionar('index/dashboard');
    }

    public function mostrarAction()
    {
            $this->flash->success('DATdO: '.$this->request->getPost('browsers'));
        return $this->redireccionar('index/dashboard');
    }
}

