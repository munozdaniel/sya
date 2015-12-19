<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ArchivoController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('principal');
        $this->tag->setTitle('Subir Archivos');
        $miSesion = $this->session->get('auth');
        if ($miSesion['rol_nombre'] == 'ADMIN')
            $this->view->admin = 1;
        else
            $this->view->admin = 0;
        parent::initialize();

    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for archivo
     */
    public function searchAction()
    {
        parent::importarJsSearch();

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Archivo", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "archivo_id";

        $archivo = Archivo::find($parameters);
        if (count($archivo) == 0) {
            $this->flash->notice("No se encontraron resultados");

            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $archivo,
            "limit"=> 10000,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * NO SE UTILIZA
     *
     * @param string $archivo_id
     */
    public function editAction($archivo_id)
    {

        if (!$this->request->isPost()) {

            $archivo = Archivo::findFirstByarchivo_id($archivo_id);
            if (!$archivo) {
                $this->flash->error("El archivo no ha sido encontrado");

                return $this->dispatcher->forward(array(
                    "controller" => "archivo",
                    "action" => "index"
                ));
            }

            $this->view->archivo_id = $archivo->archivo_id;

            $this->tag->setDefault("archivo_id", $archivo->getArchivoId());
            $this->tag->setDefault("archivo_nombre", $archivo->getArchivoNombre());
            $this->tag->setDefault("archivo_fechaCreacion", $archivo->getArchivoFechacreacion());

        }
    }

    /**
     * Creacion de un nuevo archivo en la bd y a la vez, se sube el archivo en el servidor.
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "index"
            ));
        }
        /*SUBIENDO LOS ARCHIVOS*/
        #Verifica si existen archivos para subir
        date_default_timezone_set('America/Argentina/Rio_Gallegos');

        /*$script_tz = date_default_timezone_get();

        if (strcmp($script_tz, ini_get('date.timezone'))){
            echo 'La zona horaria del script difiere de la zona horaria de la configuracion ini.';
        } else {
            echo 'La zona horaria del script y la zona horaria de la configuración ini coinciden.';
        }*/
        $archivosFallidos= "";
        if ($this->request->hasFiles() == true) {
            $uploads = $this->request->getUploadedFiles();
            $isUploaded = false;
            #Por cada archivo subido:
            $nombreCarpeta = 'temp/'.Date('Y_m_d');
            if (!file_exists($nombreCarpeta)) {
                mkdir($nombreCarpeta, 0777, true);
            }
            foreach ($uploads as $upload) {
                #define a “unique” name and a path to where our file must go
                $nombreArchivo = date('h_i_s').'_'. strtolower($upload->getname());
                $path = $nombreCarpeta.'/' .$nombreArchivo;
                #move the file and simultaneously check if everything was ok
                ($upload->moveTo($path)) ? $isUploaded = true : $isUploaded = false;
                //=========== Creando un registro en la bd ====================
                if($isUploaded){
                    $archivo = new Archivo();

                    $archivo->setArchivoCarpeta($nombreCarpeta);
                    $archivo->setArchivoNombre($nombreArchivo);
                    $archivo->setArchivoFechacreacion(Date('Y_m_d'));


                    if (!$archivo->save()) {
                        foreach ($archivo->getMessages() as $message) {
                            $this->flash->error($message);
                        }

                        return $this->dispatcher->forward(array(
                            "controller" => "archivo",
                            "action" => "new"
                        ));
                    }
                }
                else{
                    $archivosFallidos .= "$nombreArchivo <br>";
                }

            }
            #if any file couldn’t be moved, then throw an message
            if($isUploaded)
            {
                $this->flash->success('Los archivos han sido cargado correctamente');
            }
            else{
                $this->flash->error('Ha ocurrido un error, los siguientes archivos no se han podido subir: <br>'.$archivosFallidos);
            }
            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "index"
            ));



        } else {
            #if no files were sent, throw a message warning user
            $this->flash->warning('Debes seleccionar los archivos que vas a subir al servidor. Intenta de nuevo.');
        }
        /*FIN:SUBIENDO LOS ARCHIVOS*/
    }

    /**
     * NO SE UTILIZA
     * Saves a archivo edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "index"
            ));
        }

        $archivo_id = $this->request->getPost("archivo_id");

        $archivo = Archivo::findFirstByarchivo_id($archivo_id);
        if (!$archivo) {
            $this->flash->error("archivo does not exist " . $archivo_id);

            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "index"
            ));
        }

        $archivo->setArchivoNombre($this->request->getPost("archivo_nombre"));
        $archivo->setArchivoFechacreacion($this->request->getPost("archivo_fechaCreacion"));
        

        if (!$archivo->save()) {

            foreach ($archivo->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "edit",
                "params" => array($archivo->archivo_id)
            ));
        }

        $this->flash->success("archivo was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "archivo",
            "action" => "index"
        ));

    }

    /**
     * Deletes a archivo
     *
     */
    public function deleteAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "index"
            ));
        }
        $id = $this->request->getPost('id');
        $archivo = Archivo::findFirstByarchivo_id($id);
        if (!$archivo) {
            $this->flash->error("El archivo no fue encontrado");

            return $this->dispatcher->forward(array(
                "controller" => "archivo",
                "action" => "index"
            ));
        }
        try {
            $this->db->begin();
            $path = $archivo->archivo_carpeta.'/'.$archivo->archivo_nombre;
            if (!$archivo->delete()) {

                foreach ($archivo->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->dispatcher->forward(array(
                    "controller" => "archivo",
                    "action" => "search"
                ));
            } else {
                //el archivo fue eliminado de la bd, asi que procedemos a eliminarlo del servidor.
                if (file_exists($path)) {
                    unlink($path);
                    //Compruebo que se borro
                    if (file_exists($path))
                    {
                        $this->db->rollback();
                        $this->flash->error("Hubo un problema al eliminar el archivo, pruebe nuevamente");

                    }
                    else
                    {
                        $this->db->commit();
                        $this->flash->success("El archivo ha sido eliminado correctamente");
                    }
                }
            }
        }
        catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
                $this->flash->error('Transaccion Fallida: ', $e->getMessage());
            }
            catch (\Exception $e) {
                $this->flash->error('Transaccion Fallida2: ', $e->getMessage());
            }
        return $this->dispatcher->forward(array(
            "controller" => "archivo",
            "action" => "index"
        ));
    }

}
