<?php
class pacienteController extends Controller
{
  private $_paciente;

  function __construct()
  {
    parent::__construct();
    $this->_paciente = $this->loadModel("paciente");
  }







  public function getPaciente()
  {
    $datos = $this->_paciente->obtenerDatosDoctor(Sessiones::getClave('usuario'));
    $id = $datos[0]["id_doctor"];

  
    $fila = $this->_paciente->obtenerPacientes($id);

    $fila2 = $this->_paciente->obtenerSignos($id);
    $datos2 = json_encode($fila2);  

    $fila3 = $this->_paciente->obtenerDieta($id);
    $datos3 = json_encode($fila3);  
    
   
    $tabla = '';
    for ($i = 0; $i < count($fila); $i++) {
      $datos = json_encode($fila[$i]);
      
    
      $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['id_cita'] . '</td>
          <td>' . $fila[$i]['hora'] . '</td>
          <td>' . $fila[$i]['fecha'] . '</td>
          <td>' . $fila[$i]['primer_nombre'] . ' ' . $fila[$i]['segundo_nombre'] . ' ' . $fila[$i]['primer_apellido'] . ' ' . $fila[$i]['segundo_apellido'] . '</td>
          <td>' . $fila[$i]['motivo'] . '</td>
          <td>' . $fila[$i]['prioridad'] . '</td>


         <td> <a href="' . PLANTILLA . 'assets/img/' . $fila[$i]['imagen'] . '" data-fancybox="gallery" data-caption="' . $fila[$i]['motivo'] . '">
            <img src="' . PLANTILLA . 'assets/img/' . $fila[$i]['imagen'] . '" class="img-fluid rounded-start" style="height: 50px;" alt="">
            </a></td>
    


          <td>
            
 
             <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-Consulta=\'' . $datos . '\' " data-Signos=\'' . $datos2 . '\' data-Dieta=\'' . $datos3 . '\'  " class="btn btn-info btn-circle btnAgregarConsulta" data-bs-toggle="modal"
          data-bs-target="#modalAgregarConsulta">
           <i style="color: white;" class="fa-solid fa-receipt"></i>
            </button>


   <button data-agregarDieta=' . $fila[$i]['id_paciente'] . ' class="btn btn-success btn-circle btnAgregarDieta" data-bs-toggle="modal"
          data-bs-target="#modalAgregarDieta">
   <i class="fa-solid fa-utensils"></i>
   </button>

          </td>
  
          </tr>';
    }
    return $tabla;
  }
















  public function index()
  {

    $this->_view->tabla = $this->getPaciente();


    $this->_view->renderizar('paciente');
  }

     /* funcion agregar dieta */
    public function agregarDieta(){

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
        
           $this->_paciente->insertarDieta($this->getTexto('idPaciente'), $this->getTexto('nombrePlatillo'), $this->getTexto('tipoPlatillo'), $this->getTexto('descriPlatillo'),$image);
            echo $this->getPaciente();
           }
       
        
          
          
   
        
    }



}
