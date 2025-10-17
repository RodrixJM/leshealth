<?php

class pacienteModel extends Model
{

    public function obtenerDatosReserva($nombre)
    {
        return $this->_db->query("select *from doctor where usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerPacientes($id)
    {
        return $this->_db->query("select *from confirmacion as c inner join doctor as d on c.doctor_id_doctor=d.id_doctor 
inner join reserva as r on r.doctor_id_doctor=d.id_doctor inner join protagonista as p
on r.protagonista_id_protagonista=p.id_paciente inner join resultados_deteccion as det
 on det.protagonista_id_protagonista=p.id_paciente
where id_doctor='$id' and estado='aceptada'")->fetchAll();
    }


     public function obtenerPaciente($id)
    {
        return $this->_db->query("select *from confirmacion as c inner join doctor as d on c.doctor_id_doctor=d.id_doctor 
inner join reserva as r on r.doctor_id_doctor=d.id_doctor inner join protagonista as p
on r.protagonista_id_protagonista=p.id_paciente inner join resultados_deteccion as det
 on det.protagonista_id_protagonista=p.id_paciente
where id_doctor='$id' and estado='aceptada'")->fetchAll();
    }

    public function obtenerSignos($id)
    {
        return $this->_db->query("select tipo, valor from confirmacion inner join doctor on doctor_id_doctor=id_doctor inner join protagonista as p on protagonista_id_protagonista=p.id_paciente inner join signos as s on s.protagonista_id_protagonista=p.id_paciente where id_doctor ='$id'")->fetchAll();
    }

     public function obtenerDieta($id)
    {
        return $this->_db->query("select nombre_plato,tipo,descripcion,imagen_platillo from confirmacion inner join doctor on doctor_id_doctor=id_doctor 
inner join protagonista as p on protagonista_id_protagonista=p.id_paciente 
inner join dieta as d on d.protagonista_id_protagonista=p.id_paciente where id_doctor= '$id'")->fetchAll();
    }

       public function obtenerDatosDoctor($nombre)
    {
       return $this->_db->query("select *from doctor where usuario='$nombre'")->fetchAll();
    }


     public function insertarDieta($idP,$nombre,$tipo,$desc,$imagen)
    {


        $this->_db->prepare('insert into dieta(nombre_plato,tipo,descripcion,protagonista_id_protagonista,imagen_platillo)
    values(:nom,:tip,:desc,:idp,:img)')->execute(array(
                    'nom' => $nombre,
                    'tip' => $tipo,
                    'desc' => $desc,
                    'idp' => $idP,
                    'img' => $imagen
                    
                ));

                


    }

   

    

}
