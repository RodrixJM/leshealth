<?php
class usuarioController extends Controller
{
    private $_usario;

    function __construct()
    {
        parent::__construct();
        $this->_usario = $this->loadModel("usuario");
    }
 
    public function verUsuario()
    {

        $fila = $this->_usario->obtenerUsuario();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= '
          <tr>
          <td>' . $fila[$i]['id_usuario'] . '</td>
          <td>' . $fila[$i]['nombre_usuario'] . '</td>
          <td>' . $fila[$i]['clave'] . '</td>
          <td>' . $fila[$i]['rol'] . '</td>
          
          <td>
          <button data-usuario=\'' . $datos . '\' " class="btn btn-info btn-circle btnEditarUsuario">
            <i class="fas fa-info-circle"> </i>
            </button>
   <button data-borrarUsuario=' . $fila[$i]['id_usuario'] . ' class="btn btn-danger btn-circle btBorrarCementerio">
   <i class="fas fa-trash"> </i>
   </button>

          </td>
  
          </tr>';

        }

        return $tabla;


    }

    public function index()
    {

        Sessiones::acceso('administrador');

        $this->_view->tabla = $this->verUsuario();

        $this->_view->renderizar('usuario');
    }

    public function agregar()
    {
        /* Mandando los departamentos a el formulario de agregar */
        $fila = $this->_usario->obtenerDepartamento();
        $datos = '<option value="0">Seleccione Departamento</option>';

        for ($i = 0; $i < count($fila); $i++){
            $datos .= '<option value="' . $fila[$i]['id_departamento'] . '">' . $fila[$i]['nombre_departamento'] . '</option>';
        }
        $this->_view->departamentos = $datos;

       


        Sessiones::acceso('administrador');

        $this->_view->renderizar('agregar');
    }



    public function cargarMunicipio(){
        $fila = $this->_usario->obtenerMunicipio($this->getTexto('idDepartamento'));
        $datos = '<option value="0">Seleccione Municipio</option>';

        for ($i = 0; $i < count($fila); $i++){
            $datos .= '<option value="' . $fila[$i]['id_municipio'] . '">' . $fila[$i]['nombre_municipio'] . '</option>';
        }
        echo $datos;
    }


    /* Funcion que recibe los datos del formulario para agregar cementerio */
    public function agregarUsuario(){
    $this->_usario->insertarUsuario($this->getTexto('nombre'),$this->getTexto('clave'),
   $this->getTexto('rol'));

        echo $this->verUsuario();
    }

    public function actualizar()
    {
         /* Mandando los departamentos a el formulario de Actualizar */
        $fila = $this->_usario->obtenerDepartamento();
        $datos = '<option value="0">Seleccione Departamento</option>';
 
        for ($i = 0; $i < count($fila); $i++){
             $datos .= '<option value="' . $fila[$i]['id_departamento'] . '">' . $fila[$i]['nombre_departamento'] . '</option>';
        }
        $this->_view->departamentos = $datos;

        

        $this->_view->renderizar('actualizar');
    }

     /* Funcion que recibe los datos del formulario para actualizar cementerio */
     public function actualizarCementerio(){
        $this->_usario->actualizarCementerio($this->getTexto('nombreUp'),$this->getTexto('municipioUp'),
       $this->getTexto('latitudUp'),$this->getTexto('longitudUp'),
       $this->getTexto('capacidadUp'),$this->getTexto('tipoUp'),
       $this->getTexto('horaAperturaUp'),$this->getTexto('horaCierreUp'),$this->getTexto('idCementerioUp')); 
    
        }

    /* Funcion que recibe el id del cementerio a eliminar */
    public function borrarCementerio(){
        $this->_usario->borrarCementerio($this->getTexto('idCementerio'));
        echo $this->verUsuario();
    }



}




?>