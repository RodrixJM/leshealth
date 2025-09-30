<?php
class signosController extends Controller
{
    private $_signos;

    function __construct()
    {
        parent::__construct();
        $this->_signos = $this->loadModel("signos");
    }
 
    public function verSignos()
    {

        $fila = $this->_signos->obtenerSignos();
        $tabla = '';
        for ($i = 0; $i < count($fila); $i++) {
            $datos = json_encode($fila[$i]);
            $tabla .= ' 
          <tr>
          <td>' . $fila[$i]['id_signo'] . '</td>
          <td>' . $fila[$i]['fecha'] . '</td>
          <td>' . $fila[$i]['hora'] . '</td>
          <td>' . $fila[$i]['tipo'] . '</td>
          <td>' . $fila[$i]['valor'] . '</td>
        
          <td>
          <button style="background-color: #5A2A7A	; border: #5A2A7A	;" data-Signos=\'' . $datos . '\' " class="btn btn-info btn-circle btnEditarSigno" data-bs-toggle="modal"
          data-bs-target="#modalActualizarSigno">
            <i style="color: white;" class="fa-solid fa-pen"></i>
            </button>
   <button data-borrarSigno=' . $fila[$i]['id_signo'] . ' class="btn btn-danger btn-circle btBorrarSigno">
   <i class="fas fa-trash"> </i>
   </button>

          </td>
  
          </tr>';

        }

        return $tabla;


    }

     public function obtenerProtagonista()
    {

        $fila = $this->_signos->obtenerDatos(Sessiones::getClave('usuario'));
        $id=$fila[0]['id_paciente'];



       return $id;
    


    }



    public function index()
    {

      Sessiones::acceso('protagonista');
        $this->_view->tabla = $this->verSignos();
        $this->_view->usuario = $this->obtenerProtagonista();

        $this->_view->renderizar('signos');
    }






    /* Funcion que recibe los datos del formulario para agregar departamentos */
    public function agregarSigno(){

       
        
        
           $this->_signos->insertarSigno($this->getTexto('idP'),$this->getTexto('fecha'),$this->getTexto('hora'),$this->getTexto('tipo'),$this->getTexto('valor'));
           echo $this->verSignos();
        
        
          
          
   
        
    }


     /* Funcion que recibe los datos del formulario para agregar departamentos */
    public function editarSigno(){

       
        
        
           $this->_signos->actualizarSigno($this->getTexto('idSigno'),$this->getTexto('idPUp'),$this->getTexto('fechaUp'),$this->getTexto('horaUp'),$this->getTexto('tipoUp'),$this->getTexto('valorUp'));
           echo $this->verSignos();
        
        
          
          
   
        
    }

     public function borrarSigno()

    {        
        $id = $this->getTexto('id');
        $this->_signos->eliminarSigno($id);
        echo $this->verSignos();
    }

 



     



}




?>