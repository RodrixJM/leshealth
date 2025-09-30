<?php

class signosModel extends Model
{

    public function obtenerSignos()
    {
        return $this->_db->query("select *from signos;")->fetchAll();
    }

    public function obtenerUsuario()
    {
        return $this->_db->query("select *from signos;")->fetchAll();
    }

     public function obtenerDatos($usuario)
    {
        return $this->_db->query("select *from protagonista where usuario='$usuario';")->fetchAll();
    }



  
 




    public function insertarSigno($id, $fecha, $hora, $tipo, $valor)
    {
        $this->_db->prepare('insert into signos(fecha,hora,tipo,valor,protagonista_id_protagonista)values(:fecha,:hora,:tipo,:valor,:id)')->execute(array(
            
            'fecha' => $fecha,
            'hora' => $hora,
            'tipo' => $tipo,
            'valor' => $valor,
            'id' => $id
        )); 

       

              

    }

    


    public function actualizarSigno($id, $idU, $fecha, $hora, $tipo, $valor)
{

  
    
    $sql = "UPDATE signos 
            SET fecha = :fecha, 
                hora = :hora, 
                tipo = :tipo, 
                valor = :valor,
                protagonista_id_protagonista = :idU
            WHERE id_signo = :id";
    
    $this->_db->prepare($sql)->execute([
        'id' => $id,
        'fecha' => $fecha,
        'hora' => $hora,
        'tipo' => $tipo,
        'valor' => $valor,
        'idU' => $idU
    ]);

   
}


    public function eliminarSigno($id)
    {
        $this->_db->prepare('delete from signos where id_signo=:id')->execute(array('id' => $id));
    }




}
