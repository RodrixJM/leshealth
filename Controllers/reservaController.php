<?php
class reservaController extends Controller
{
    private $_reserva;

    function __construct()
    {
        parent::__construct();
        $this->_reserva = $this->loadModel("reserva");
    }

    public function idProtagonista()
    {
         $datos = $this->_reserva->obtenerDatosReserva(Sessiones::getClave('usuario'));
     
        $id = $datos[0]["id_paciente"];

       return $id;

    } 


    public function getReserva()
    {

        $datos = $this->_reserva->obtenerDatosReserva(Sessiones::getClave('usuario'));
        
        $id = $datos[0]["id_paciente"];

        $fila = $this->_reserva->obtenerReservas($id);
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= '
        <tr>
          <td>' . $fila[$i]['primer_nombre'] .  $fila[$i]['segundo_nombre'].  $fila[$i]['primer_apellido']. $fila[$i]['segundo_apellido']. '</td>
          <td>' . $fila[$i]['nombre_doctor'] . '</td>
          <td>' . $fila[$i]['especialidad'] . '</td>
          <td>' . $fila[$i]['hora'] . '</td>
          <td>' . $fila[$i]['fecha'] . '</td>
            <td>' . $fila[$i]['prioridad'] . '</td>
          

         


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
        Sessiones::acceso('protagonista');

        /* Mandando los departamentos a el formulario de agregar municipio */
        $fila = $this->_reserva->obtenerEspecialista();
        $datos = '<option value="0">Seleccione Especialista</option>';

        for ($i = 0; $i < count($fila); $i++){
            $datos .= '<option value="' . $fila[$i]['id_doctor'] . '">' . $fila[$i]['nombre_doctor'] . ' ' . $fila[$i]['especialidad'] . '</option>';
        }

        $this->_view->especialista = $datos;

        $this->_view->id=$this->idProtagonista();



        $this->_view->tabla = $this->getReserva();

        $this->_view->renderizar('reserva');
    }






    /* Funcion que recibe los datos del formulario para agregar reserva */
     public function agregarReserva(){

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
        
           $this->_reserva->insertarReserva($this->getTexto('hora'),$this->getTexto('fecha'),$this->getTexto('especialista'),$this->getTexto('prioridad'),$this->getTexto('motivo'),$this->getTexto('id'),$image);
           echo $this->getReserva();





           }
           else{
            $this->_doctor->insertarServicioSinImagen($this->getTexto('tipoServicio'),$this->getTexto('descripcionServicio'),$this->getTexto('precioServicio'));
            echo $this->verDoctor();
           }
        
          
          
   
        
    }
 

}




?>