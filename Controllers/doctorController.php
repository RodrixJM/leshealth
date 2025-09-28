<?php
class doctorController extends Controller
{
    private $_doctor;

    function __construct()
    {
        parent::__construct();
        $this->_doctor = $this->loadModel("doctor");
    }
 
    public function verDoctor()
    {

        $fila = $this->_doctor->obtenerDoctor();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['id_doctor'] . '</td>
          <td>' . $fila[$i]['nombre_doctor'] . '</td>
          <td>' . $fila[$i]['especialidad'] . '</td>
          <td>' . $fila[$i]['correo'] . '</td>
          <td>' . $fila[$i]['telefono'] . '</td>
         <td> <a href="' . PLANTILLA . 'assets/img/' .$fila[$i]['imagen']. '" data-fancybox="gallery" data-caption="'.$fila[$i]['nombre_doctor'].'">
            <img src="' . PLANTILLA . 'assets/img/' .$fila[$i]['imagen']. '" class="img-fluid rounded-start" style="height: 50px;" alt="">
            </a></td>
    


          <td>
          <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-Doctor=\'' . $datos . '\' " class="btn btn-info btn-circle btnEditarDoctor" data-bs-toggle="modal"
          data-bs-target="#modalEditarDoctor">
            <i style="color: white;" class="fa-solid fa-pen"></i>
            </button>
   <button data-borrarServicio=' . $fila[$i]['id_doctor'] . ' class="btn btn-danger btn-circle btBorrarDepartamento">
   <i class="fas fa-trash"> </i>
   </button>

          </td>
  
          </tr>';

        }

        return $tabla;


    }

    public function index()
    {
        $this->_view->tabla = $this->verDoctor();

        $this->_view->renderizar('doctor');
    }






    /* Funcion que recibe los datos del formulario para agregar departamentos */
    public function agregarDoctor(){

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
        
           $this->_doctor->insertarDoctor($this->getTexto('nombre'),$this->getTexto('sexo'),$this->getTexto('especialidad'),$this->getTexto('numero'),
           $this->getTexto('correo'),
           $this->getTexto('nombreU'),
           $this->getTexto('clave'),$image);
           echo $this->verDoctor();
           }
           else{
            $this->_doctor->insertarServicioSinImagen($this->getTexto('tipoServicio'),$this->getTexto('descripcionServicio'),$this->getTexto('precioServicio'));
            echo $this->verDoctor();
           }
        
          
          
   
        
    }

     public function editarDoctor(){

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
        
           $this->_doctor->insertarDoctor($this->getTexto('nombre'),$this->getTexto('sexo'),$this->getTexto('especialidad'),$this->getTexto('numero'),
           $this->getTexto('correo'),
           $this->getTexto('nombreU'),
           $this->getTexto('clave'),$image);
           echo $this->verDoctor();
           }
           else{
            $this->_doctor->insertarServicioSinImagen($this->getTexto('tipoServicio'),$this->getTexto('descripcionServicio'),$this->getTexto('precioServicio'));
            echo $this->verDoctor();
           }
        
          
          
   
        
    }


     



}




?>