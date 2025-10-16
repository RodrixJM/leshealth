<?php

class completeController extends Controller{
    private $_complete;
    private $_rol;
    function __construct()
    {
        parent::__construct();
        $this->_complete = $this->loadModel("complete");
        $this->_rol = Sessiones::getClave("rol");
    }

    public function index()
    {
        if($this->_rol != "doctor" && $this->_rol != "protagonista"){
            $this->redireccionar('index');
            exit;
        }   
        //Sessiones::acceso('administrador');
        $this->_view->renderizar('complete');
    }

}

?>