<?php

abstract class Controller
{
    protected $_view;

    public function __construct()
    {
        $this->_view=new View(new Rutas());
    }

    abstract public function index();

    protected function loadModel($modelo)
    {
        $modelo=$modelo.'Model';
        $rutaModelo=ROOT.'Models'.DS.$modelo.'.php';
        if(is_readable($rutaModelo))
        {
            require_once $rutaModelo;
            $modelo=new $modelo;
            return $modelo;
        }
        else
        {
            throw new Exception('Error en el modelo');
        }
    }

    protected function getTexto($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            $_POST[$clave]=htmlspecialchars($_POST[$clave],ENT_QUOTES);
            return $_POST[$clave];
        }
        else
            return '';
    }

    protected function redireccionar($direccion){
        header("Location:".BASE_URL.$direccion);
    }


}