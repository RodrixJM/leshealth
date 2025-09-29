<?php
class medicacionController extends Controller
{
    private $_medicacion;

    function __construct()
    {
        parent::__construct();
        $this->_medicacion = $this->loadModel("medication");
    }

    public function index()
    {
        Sessiones::acceso('administrador');
        $this->_view->tabla = $this->verMedicacion();
        $this->_view->renderizar('medicacion');
    }

    public function verMedicacion()
    {
        $fila = $this->_medicacion->obtenerMedicacion();
        $tabla = '';

        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= '
            <tr>
                <td>' . $fila[$i]['id_medicacion'] . '</td>
                <td>' . $fila[$i]['nombre_medicamento'] . '</td>
                <td>' . $fila[$i]['dosis'] . '</td>
                <td>' . $fila[$i]['frecuencia'] . '</td>
                <td>' . $fila[$i]['hora_aplicacion'] . '</td>
                <td>' . $fila[$i]['fecha'] . '</td>
                <td>' . $fila[$i]['duracion'] . '</td>
                <td>' . $fila[$i]['protagonista_id_protagonista'] . '</td>
                <td>
                    <button data-medicacion=\'' . $datos . '\' class="btn btn-info btn-circle btnEditarMedicacion">
                        <i class="fas fa-info-circle"></i>
                    </button>
                    <button data-borrarMedicacion=' . $fila[$i]['id_medicacion'] . ' class="btn btn-danger btn-circle btnBorrarMedicacion">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>';
        }

        return $tabla;
    }

    public function agregar()
    {
        Sessiones::acceso('administrador');

        if ($this->getTexto('validar') == 1) {
            $this->_medicacion->insertarMedicacion(
                $this->getTexto('nombre'),
                $this->getTexto('dosis'),
                $this->getTexto('frecuencia'),
                $this->getTexto('hora'),
                $this->getTexto('fecha'),
                $this->getTexto('duracion'),
                $this->getTexto('protagonista'),
                "" // imagen opcional, puedes manejar upload aparte
            );
            echo $this->verMedicacion();
        }

        $this->_view->renderizar('agregar');
    }

    public function editar($id)
    {
        Sessiones::acceso('administrador');
        $medicacion = $this->_medicacion->obtenerMedicacionPorId($id);
        $this->_view->medicacion = $medicacion;

        if ($this->getTexto('validar') == 1) {
            $this->_medicacion->editarMedicacion(
                $id,
                $this->getTexto('nombre'),
                $this->getTexto('dosis'),
                $this->getTexto('frecuencia'),
                $this->getTexto('hora'),
                $this->getTexto('fecha'),
                $this->getTexto('duracion'),
                $this->getTexto('protagonista'),
                ""
            );
            $this->redireccionar('medicacion/index');
        }

        $this->_view->renderizar('editar');
    }

    public function borrar()
    {
        $id = $this->getTexto('id');
        Sessiones::acceso('administrador');
        $this->_medicacion->borrarMedicacion($id);
        echo $this->verMedicacion();
    }
}
?>
