<?php
class BibliotecaController extends Controller
{
    private $_biblioteca;

    public function __construct()
    {
        parent::__construct();
        $this->_biblioteca = $this->loadModel('biblioteca');
    }

    public function index()
    {
        $busqueda = $_GET['busqueda'] ?? '';
        $categoria = $_GET['categoria'] ?? '';

        $libros = $this->_biblioteca->obtenerLibros($busqueda, $categoria);

        $this->_view->libros = $libros;
        $this->_view->renderizar('biblioteca');
    }
}
