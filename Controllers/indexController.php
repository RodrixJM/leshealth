<?php
    class indexController extends Controller{
        private $_index;
    
    function __construct()
    {
       parent::__construct(); 
       $this->_index = $this->loadModel("index");
    }




public function getColaboradores()
{
    $fila=$this->_index->obtenerColaboradores();
    for($i=0;$i<count($fila);$i++){
        $servicio=json_encode($fila);
        
    } 
    return $servicio;
    

}


public function getCitas()
{
    $datos=$this->_index->obtenerDatosReserva(Sessiones::getClave('usuario'));
    if($datos==null){
        return null;
    }else
    $id = $datos[0]["id_paciente"];
    $fila=$this->_index->obtenerCitas($id);

    for($i=0;$i<count($fila);$i++){
        $citas=json_encode($fila);
        
    } 
    return $citas;
    

}


public function getMedicacion()
{
    $datos=$this->_index->obtenerDatosMedicacion(Sessiones::getClave('usuario'));
    if($datos==null){
        return null;
    }else
    $id = $datos[0]["id_paciente"];
    $fila=$this->_index->obtenerMedicacion($id);

    for($i=0;$i<count($fila);$i++){
        $medicacion=json_encode($fila);
        
    } 
    return $medicacion;
    

}

public function getDieta()
{
    $datos=$this->_index->obtenerDatosDieta(Sessiones::getClave('usuario'));
    if($datos==null){
        return null;
    }else
    $id = $datos[0]["id_paciente"];
    $fila=$this->_index->obtenerDieta($id);

    for($i=0;$i<count($fila);$i++){
        $dieta=json_encode($fila);
        
    } 
    return $dieta;
    

}

public function getEjercicio()
{
    $datos=$this->_index->obtenerDatosEjercicio(Sessiones::getClave('usuario'));
    if($datos==null){
        return null;
    }else
    $id = $datos[0]["id_paciente"];
    $fila=$this->_index->obtenerEjercicio($id);
    
    for($i=0;$i<count($fila);$i++){
        $ejercicio=json_encode($fila);
        
    } 

    return $ejercicio;
    

}

public function getSigno()
{
    $datos=$this->_index->obtenerDatosSigno(Sessiones::getClave('usuario'));
    if($datos==null){
        return null;
    }else
    $id = $datos[0]["id_paciente"];
    $fila=$this->_index->obtenerSigno($id);
    if($fila!=null){
    
    for($i=0;$i<count($fila);$i++){
        $signo=json_encode($fila);
        
    } 

    return $signo;
    }

}






       public function index()
    {
      $this->_view->colaborador=$this->getColaboradores();
      $this->_view->citas=$this->getCitas();
      $this->_view->medicacion=$this->getMedicacion();
      $this->_view->dieta=$this->getDieta();
      $this->_view->ejercicio=$this->getEjercicio();
      $this->_view->signo=$this->getSigno();       
      $this->_view->renderizar('index');
    }

    }
    
 


?>