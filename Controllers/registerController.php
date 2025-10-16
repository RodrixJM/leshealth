<?php

class registerController extends Controller
{
    private $_register;
    private $_login;

    function __construct()
    {
        parent::__construct();
        $this->_register = $this->loadModel("register");
        $this->_login = $this->loadModel("login");
    }

    public function registrarUsuario(){
         $this->_register->registrarUsuario(
            $this->getTexto("user"),
            $this->getTexto("clave"),
            $this->getTexto("rol")
        );
        $this->_view->renderizar("register");
    }
    
    public function index()
    {
       $this->_view->renderizar('register');
    }

    public function salir()
    {
        Sessiones::salir();
        $this->redireccionar('index');
    }

}