<?php
class medicacionController extends Controller
{
    private $_medicacion;
    private $_usuario;

    function __construct()
    {
        parent::__construct();
        $this->_usuario = $this->loadModel("protagonista");
        $this->_medicacion = $this->loadModel("medicacion");
    }

    public function index()
    {
        Sessiones::acceso('administrador');
        $this->_view->pacientes = $this->_usuario->obtenerProtagonista();
        echo "<script>console.log(" . json_encode($this->_view->pacientes) . " )</script>";

        $this->_view->tabla = $this->verMedicacion();
        $this->_view->renderizar('medicacion');
                echo $this->verMedicacion();

        
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

    try {
        // Recibir datos
        $nombre = $this->getTexto('nombre_medicamento');
        $dosis = $this->getTexto('dosis');
        $frecuencia = $this->getTexto('frecuencia');
        $hora = $this->getTexto('hora_aplicacion'); 
        $fecha = $this->getTexto('fecha');          
        $duracion = $this->getTexto('duracion');
        $protagonista = (int)$this->getTexto('protagonista'); // ID entero

        // Debug: imprimir datos recibidos
        error_log("Datos recibidos:");
        error_log("Nombre: $nombre");
        error_log("Dosis: $dosis");
        error_log("Frecuencia: $frecuencia");
        error_log("Hora: $hora");
        error_log("Fecha: $fecha");
        error_log("Duracion: $duracion");
        error_log("Protagonista: $protagonista");

        $imagen = '';
        if(isset($_FILES['imagenMedicina']) && $_FILES['imagenMedicina']['name'] != '') {
            if ($_FILES['imagenMedicina']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Error al subir la imagen. Código: " . $_FILES['imagenMedicina']['error']);
            }

            $extension = pathinfo($_FILES['imagenMedicina']['name'], PATHINFO_EXTENSION);
            $imagen = rand() . '.' . $extension;
            $destination = './Views/plantilla/assets/img/' . $imagen;

            if (!move_uploaded_file($_FILES['imagenMedicina']['tmp_name'], $destination)) {
                throw new Exception("No se pudo mover el archivo subido a la carpeta destino.");
            }

            error_log("Imagen subida correctamente: $imagen");
        } else {
            error_log("No se subió ninguna imagen.");
        }

        // Insertar medicación
        $this->_medicacion->insertarMedicacion(
            $nombre,
            $dosis,
            $frecuencia,
            $hora,
            $fecha,
            $duracion,
            $protagonista,
            $imagen
        );

        echo $this->verMedicacion();

    } catch (Exception $e) {
        // Mostrar errores
        error_log("Error en agregar medicación: " . $e->getMessage());
        echo json_encode([
            'error' => true,
            'mensaje' => $e->getMessage()
        ]);
    }
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
