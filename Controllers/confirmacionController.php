<?php
    class confirmacionController extends Controller{
        private $_confirmacion;
    
    function __construct()
    {
       parent::__construct(); 
       $this->_confirmacion = $this->loadModel("confirmacion");
    }







public function getSolicitudes()
{
    $datos=$this->_confirmacion->obtenerDatosDoctor(Sessiones::getClave('usuario'));
    $id = $datos[0]["id_doctor"];
    $fila=$this->_confirmacion->obtenerReservas($id);

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


         <td> <a href="' . PLANTILLA . 'assets/img/' .$fila[$i]['imagen']. '" data-fancybox="gallery" data-caption="'.$fila[$i]['motivo'].'">
            <img src="' . PLANTILLA . 'assets/img/' .$fila[$i]['imagen']. '" class="img-fluid rounded-start" style="height: 50px;" alt="">
            </a></td>
    


          <td>
          <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-cita=\'' . $datos . '\' " class="btn btn-info btn-circle btnAceptarCita">
            <i style="color: white;" class="fa-solid fa-check"></i>
            </button>
   <button data-borrarServicio=' . $fila[$i]['id_cita'] . ' class="btn btn-danger btn-circle btBorrarDoctor">
   <i class="fas fa-xmark"> </i>
   </button>

          </td>
  
          </tr>';

        }
    return $tabla;
    

}













       public function index()
    {

      $this->_view->tabla=$this->getSolicitudes();
     
       
      $this->_view->renderizar('confirmacion');
    }

    

     public function aceptarCita(){
        
           $this->_confirmacion->agendarCita($this->getTexto('idD'),$this->getTexto('idP'),$this->getTexto('idC'));
           echo $this->getSolicitudes();
        
          
          
   
        
    }




    }
    
 


?>