<?php
class protagonistaController extends Controller
{
    private $_protagonista;

    function __construct()
    {
        parent::__construct();
        $this->_protagonista = $this->loadModel("protagonista");
    }
 
    public function verProtagonista()
    {

        $fila = $this->_protagonista->obtenerProtagonista();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['id_paciente'] . '</td>
          <td>' . $fila[$i]['primer_nombre'] .  $fila[$i]['segundo_nombre'].  $fila[$i]['primer_apellido']. $fila[$i]['segundo_apellido']. '</td>
          <td>' . $fila[$i]['cedula'] . '</td>
          <td>' . $fila[$i]['municipio'] . '</td>
          <td>' . $fila[$i]['fecha_nacimiento'] . '</td>
          <td>' . $fila[$i]['edad'] . '</td>
            <td>' . $fila[$i]['sexo'] . '</td>
            <td>' . $fila[$i]['nacionalidad'] . '</td>
            <td>' . $fila[$i]['estado_civil'] . '</td>
            <td>' . $fila[$i]['ocupacion'] . '</td>
            <td>' . $fila[$i]['direccion'] . '</td>
            <td>' . $fila[$i]['correo'] . '</td>
            <td>' . $fila[$i]['telefono'] . '</td>
            <td>' . $fila[$i]['usuario'] . '</td>

          <td> <img src="Views/plantilla/assets/img/' . $fila[$i]['imagen'] . '" width="50" height="50" class="img-thumbnail" /></td> 
    


          <td>
          <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-Servicio=\'' . $datos . '\' " class="btn btn-info btn-circle btnEditarServicio" data-bs-toggle="modal"
          data-bs-target="#modalActualizarServicio">
            <i style="color: white;" class="fa-solid fa-pen"></i>
            </button>
   <button data-borrarServicio=' . $fila[$i]['id_paciente'] . ' class="btn btn-danger btn-circle btBorrarDepartamento">
   <i class="fas fa-trash"> </i>
   </button>

          </td>
  
          </tr>';

        }

        return $tabla;


    }

    public function index()
    {
        $this->_view->tabla = $this->verProtagonista();

        /* Mandando los departamentos a el formulario de agregar municipio */
        $fila = $this->_protagonista->obtenerDepartamento();
        $datos = '<option value="0">Seleccione Departamento</option>';

        for ($i = 0; $i < count($fila); $i++){
            $datos .= '<option value="' . $fila[$i]['id_departamento'] . '">' . $fila[$i]['nombre_departamento'] . '</option>';
        }

        $this->_view->departamentos = $datos;
        

        $this->_view->renderizar('protagonista');
    }

    /* Funcion que recibe el departamento y muestrea los municipios en el formulario */
     public function cargarMunicipio(){
        $fila = $this->_protagonista->obtenerMunicipio($this->getTexto('idDepartamento'));
        $datos = '<option value="0">Seleccione Municipio</option>';

        for ($i = 0; $i < count($fila); $i++){
            $datos .= '<option value="' . $fila[$i]['id_municipio'] . '">' . $fila[$i]['nombre_municipio'] . '</option>';
        }
        echo $datos;
    }





    /* Funcion que recibe los datos del formulario para agregar departamentos */
    public function agregarProtagonista(){

        function upload_image()
        {
         if(isset($_FILES["imagen"]))
         {
          $extension = explode('.', $_FILES['imagen']['name']);
          $new_name = rand() . '.' . $extension[1];
          $destination = './Views/plantilla/assets/img/' . $new_name;
          move_uploaded_file($_FILES['imagen']['tmp_name'], $destination);
          return $new_name;
         }
        }
        $image = '';
        if($_FILES["imagen"]["name"] != '')
          {
           $image = upload_image();
        
           $this->_protagonista->insertarProtagonista($this->getTexto('pNombre'),$this->getTexto('sNombre'),$this->getTexto('pApellido'),$this->getTexto('sApellido'),$this->getTexto('cedula'),$this->getTexto('municipioOrigen'),$this->getTexto('fechaNacio'),$this->getTexto('edad'),$this->getTexto('sexo'),$this->getTexto('nacionalidad'),$this->getTexto('ocupacion'),$this->getTexto('estadoCivil'),$this->getTexto('direccion'),$this->getTexto('numero'),$this->getTexto('correo'),$this->getTexto('nombreU'),$this->getTexto('clave'),$image);
           echo $this->verProtagonista();



           }
           else{
            $this->_doctor->insertarServicioSinImagen($this->getTexto('tipoServicio'),$this->getTexto('descripcionServicio'),$this->getTexto('precioServicio'));
            echo $this->verDoctor();
           }
        
          
          
   
        
    }

     



}




?>