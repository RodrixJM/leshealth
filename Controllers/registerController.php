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
        $user = $this->getTexto("user");
        $clave = $this->getTexto("clave");
        $rol = $this->getTexto("rol");

        $this->_register->registrarUsuario(
            $user,
            $clave,
            $rol);

            Sessiones::setClave('rol', $rol);
            Sessiones::setClave('autenticado', true);
            Sessiones::setClave('usuario', $user);
            Sessiones::setClave('clave', $clave);
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