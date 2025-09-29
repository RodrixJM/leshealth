<?php

class reportesController extends Controller
{
    private $_reportes;

    public function __construct()
    {
        parent::__construct();
        $this->_reportes = $this->loadModel("reportes");
    }

    // Página principal de reportes
    public function index()
    {
        Sessiones::acceso('administrador'); // Solo administradores pueden acceder

        // Obtener signos y pacientes
        $this->_view->signos = $this->_reportes->obtenerSignos();
        $this->_view->pacientes = $this->_reportes->obtenerPacientes();

        $this->_view->renderizar('reportes');
    }

    // Filtrar signos por paciente y fechas
    public function filtrar()
    {
        $pacienteId = $this->getInt('protagonista_id');
        $fechaDesde = $this->getTexto('fecha_desde');
        $fechaHasta = $this->getTexto('fecha_hasta');

        $signos = $this->_reportes->obtenerSignosFiltrados($pacienteId, $fechaDesde, $fechaHasta);

        // Devolver como JSON para actualizar la tabla con AJAX
        echo json_encode($signos);
    }
}

?>
