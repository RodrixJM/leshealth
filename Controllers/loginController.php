<?php

class loginController extends Controller{
    private $_login;

    function __construct(){
        parent::__construct(); 
        $this->_login=$this->loadModel("login");
    }

    public function index(){
        if($this->getTexto('validar') == 1)
        {
            $datos = $this->_login->obtenerUsuario($this->getTexto('user'));
    
            // Verificar si obtenerUsuario devuelve un array válido
            if($datos && is_array($datos)) {
                if(password_verify($this->getTexto('clave'), $datos["clave"]))
                {
                    Sessiones::setClave('rol', $datos["rol"]);
                    Sessiones::setClave('autenticado', true);
                    Sessiones::setClave('usuario', $datos["nombre_usuario"]);
                    Sessiones::setClave('id_usuario', $datos["id_usuario"]);
                    $this->redireccionar('index');
                }
                else {
                    $this->_view->mensaje = '<div class="alert alert-danger" role="alert">
                        <center>Usuario y/o Clave Incorrecta!</center>
                    </div>';
                }
            } else {
                // Si no hay resultados o el usuario no existe
                $this->_view->mensaje = '<div class="alert alert-danger" role="alert">
                    <center>Usuario no encontrado!</center>
                </div>';
            }
        }
    
        $this->_view->renderizar('login');
        
    }

    public function salir()
    {
        Sessiones::salir();
        $this->redireccionar('index');
    }

}