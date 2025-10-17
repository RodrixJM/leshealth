<?php
class deteccionController extends Controller
{
    private $_deteccion;

    public function __construct()
    {
        parent::__construct();
        $this->_deteccion = $this->loadModel("deteccion");
    }

    public function index()
    {
        $this->_view->renderizar('deteccion');
    }

    public function guardarDeteccionLupus() {
    $datos = $this->_deteccion->obtenerDatosU(Sessiones::getClave('usuario'));
    $id = $datos[0]["id_paciente"] ?? null;

    if (!$id) {
        echo "Error: paciente no encontrado.";
        return;
    }

    $diagnostico = $_POST['diagnostico'] ?? '';
    $respuestas = $_POST['respuestas'] ?? '';

    // Usamos el método del modelo
    $this->_deteccion->guardarDeteccion($id, $respuestas, $diagnostico);

    echo "Guardado exitoso";
}
}
