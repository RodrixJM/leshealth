<?php 
class ayudaController extends Controller
{

    private $_ayuda;
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_view->renderizar('ayuda');
        $this->_ayuda = $this->loadModel("ayuda");
    }
}