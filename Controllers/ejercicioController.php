<?php
class ejercicioController extends Controller
{
    private $_ejercicio;

    function __construct()
    {
        parent::__construct();
        $this->_ejercicio = $this->loadModel("ejercicio");
    }

    public function index()
    {
        Sessiones::acceso('administrador');
        $this->_view->tabla = $this->verEjercicios();
        $this->_view->renderizar('ejercicio');
    }

    public function verEjercicios()
    {
        $fila = $this->_ejercicio->obtenerEjercicios();
        $tabla = '';

        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= '
            <tr>
                <td>' . $fila[$i]['id_ejercicio'] . '</td>
                <td>' . $fila[$i]['nombre_ejercicio'] . '</td>
                <td>' . $fila[$i]['repeticiones'] . '</td>
                <td>' . $fila[$i]['series'] . '</td>
                <td>' . $fila[$i]['protagonista_id_protagonista'] . '</td>
                <td>
                    <button data-ejercicio=\'' . $datos . '\' class="btn btn-info btn-circle btnEditarEjercicio">
                        <i class="fas fa-info-circle"></i>
                    </button>
                    <button data-borrarEjercicio=' . $fila[$i]['id_ejercicio'] . ' class="btn btn-danger btn-circle btnBorrarEjercicio">
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
            $this->_ejercicio->insertarEjercicio(
                $this->getTexto('nombre'),
                $this->getTexto('repeticiones'),
                $this->getTexto('series'),
                $this->getTexto('protagonista'),
                "" // imagen opcional
            );
            echo $this->verEjercicios();
        }

        $this->_view->renderizar('agregar');
    }

    public function editar($id)
    {
        Sessiones::acceso('administrador');
        $ejercicio = $this->_ejercicio->obtenerEjercicioPorId($id);
        $this->_view->ejercicio = $ejercicio;

        if ($this->getTexto('validar') == 1) {
            $this->_ejercicio->editarEjercicio(
                $id,
                $this->getTexto('nombre'),
                $this->getTexto('repeticiones'),
                $this->getTexto('series'),
                $this->getTexto('protagonista'),
                "" // imagen opcional
            );
            $this->redireccionar('ejercicio/index');
        }

        $this->_view->renderizar('editar');
    }

    public function borrar()
    {
        $id = $this->getTexto('idEjercicio');
        Sessiones::acceso('administrador');
        $this->_ejercicio->borrarEjercicio($id);
        echo $this->verEjercicios();
    }
}
?>
