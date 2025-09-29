<?php
class dietaController extends Controller
{
    private $_dieta;

    function __construct()
    {
        parent::__construct();
        $this->_dieta = $this->loadModel("dieta");
    }

    public function index()
    {
        Sessiones::acceso('administrador');
        $this->_view->tabla = $this->verDieta();
        $this->_view->renderizar('dieta');
    }

    public function verDieta()
    {
        $fila = $this->_dieta->obtenerDieta();
        $tabla = '';

        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= '
            <tr>
                <td>' . $fila[$i]['id_dieta'] . '</td>
                <td>' . $fila[$i]['nombre_plato'] . '</td>
                <td>' . $fila[$i]['tipo'] . '</td>
                <td>' . $fila[$i]['descripcion'] . '</td>
                <td>' . $fila[$i]['protagonista_id_protagonista'] . '</td>
                <td>
                    <button data-dieta=\'' . $datos . '\' class="btn btn-info btn-circle btnEditarDieta">
                        <i class="fas fa-info-circle"></i>
                    </button>
                    <button data-borrarDieta=' . $fila[$i]['id_dieta'] . ' class="btn btn-danger btn-circle btnBorrarDieta">
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
            $this->_dieta->insertarDieta(
                $this->getTexto('nombre'),
                $this->getTexto('tipo'),
                $this->getTexto('descripcion'),
                $this->getTexto('protagonista'),
                "" // imagen opcional
            );
            echo $this->verDieta();
        }

        $this->_view->renderizar('agregar');
    }

    public function editar($id)
    {
        Sessiones::acceso('administrador');
        $dieta = $this->_dieta->obtenerDietaPorId($id);
        $this->_view->dieta = $dieta;

        if ($this->getTexto('validar') == 1) {
            $this->_dieta->editarDieta(
                $id,
                $this->getTexto('nombre'),
                $this->getTexto('tipo'),
                $this->getTexto('descripcion'),
                $this->getTexto('protagonista'),
                "" // imagen opcional
            );
            $this->redireccionar('dieta/index');
        }

        $this->_view->renderizar('editar');
    }

    public function borrar()
    {
        $id = $this->getTexto('id');
        Sessiones::acceso('administrador');
        $this->_dieta->borrarDieta($id);
        echo $this->verDieta();
    }
}
?>
