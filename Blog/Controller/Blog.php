<?php

namespace TestProject\Controller;

class Blog
{
    const MAX_POSTS = 5;

    protected $oUtil, $oModel;
    private $_iId;
    private $_file_type;

    public function __construct()
    {
        // Enable PHP Session
        if (empty($_SESSION))
            @session_start();

        $this->oUtil = new \TestProject\Engine\Util;

        /** Get the Model class in all the controller class **/
        $this->oUtil->getModel('Blog');
        $this->oModel = new \TestProject\Model\Blog;

        /** Get the Post ID in the constructor in order to avoid the duplication of the same code **/
        $this->_iId = (int) (!empty($_GET['id']) ? $_GET['id'] : 0);

        /** Get the filetype file post in the constructor **/
        $this->_file_type = (string) (!empty($_GET['file_type']) ? $_GET['file_type'] : 'none');
    }


    /***** Front end *****/
    // Homepage
    public function index()
    {
        $this->oUtil->oPosts = $this->oModel->get(0, self::MAX_POSTS); // Get only the latest X posts

        $this->oUtil->getView('index');
    }

    public function post()
    {
        $this->oUtil->oPost = $this->oModel->getById($this->_iId); // Get the data of the post

        $this->oUtil->getView('post');
    }

    public function notFound()
    {
        $this->oUtil->getView('not_found');
    }


    /***** For Admin (Back end) *****/
    public function all()
    {
        if (!$this->isLogged()) exit;

        $this->oUtil->oPosts = $this->oModel->getAll();

        $this->oUtil->getView('index');
    }


    public function add()
    {
        if (!$this->isLogged()) exit;

        if (!empty($_POST['add_submit']))
        {

            if (isset($_POST['title'], $_POST['body']) && mb_strlen($_POST['title']) <= 50) // Allow a maximum of 50 characters
            {
              $fileName = basename($_FILES["fileToUpload"]["name"]);
              $target_file = PATH_FILE . $fileName;
              $uploadOk = 1;
              $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

              // Check if file already exists
              if (file_exists($target_file)) {
                echo "<p class='error'>El archivo ya existe.<p>";
                $uploadOk = 0;
              } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                  echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]). " ha sido subido.";
                } else {
                  echo "Lo sentimos :(, ha habido un error al subir el archivo.";
                }
              }

                $aData = array(
                              'title' => $_POST['title'],
                              'body' => $_POST['body'],
                              'created_date' => date('Y-m-d H:i:s'),
                              'file_type' => empty($fileType) ?  "none" : $fileType,
                              'file_name' => empty($fileName) ? "none.jpg" : $fileName );

                if ($this->oModel->add($aData))
                    $this->oUtil->sSuccMsg = '¡Bien! Haz agregado un post nuevo.';
                else
                    $this->oUtil->sErrMsg = '¡Ooops! Ha ocurrido un error. Por favor intente de nuevo más tarde.';
            }
            else
            {
                $this->oUtil->sErrMsg = 'Todos los campos son requeridos, y el título no puede axceder los 50 carácteres.';
            }
        }

        $this->oUtil->getView('add_post');
    }

    public function edit()
    {
        if (!$this->isLogged()) exit;

        if (!empty($_POST['edit_submit']))
        {
            if (isset($_POST['title'], $_POST['body']))
            {
                $aData = array('post_id' => $this->_iId, 'title' => $_POST['title'], 'body' => $_POST['body']);

                if ($this->oModel->update($aData))
                    $this->oUtil->sSuccMsg = '¡Bien! EL post ha sido actualizado.';

                else
                    $this->oUtil->sErrMsg = '¡Ooops! Ha ocurrido un error. Por favor intente de nuevo más tarde.';
                    //
            }
            else
            {
                $this->oUtil->sErrMsg = 'Todos los campos son requeridos.';
            }
        }

        /* Get the data of the post */
        $this->oUtil->oPost = $this->oModel->getById($this->_iId);

        $this->oUtil->getView('edit_post');
    }

    public function delete()
    {
        if (!$this->isLogged()) exit;

        if (!empty($_POST['delete']) && $this->oModel->delete($this->_iId))
            header('Location: ' . ROOT_URL);
        else
            exit('¡Ooops! El post no pudo ser eliminado.');
    }

    protected function isLogged()
    {
        return !empty($_SESSION['is_logged']);
    }
}
