<?php

class confirmacionModel extends Model
{

    public function obtenerDatosReserva($nombre)
    {
        return $this->_db->query("select *from doctor where usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerReservas($id)
    {
        return $this->_db->query("select id_cita,reserva.motivo, reserva.prioridad, reserva.imagen, reserva.hora, reserva.fecha, protagonista.primer_nombre, protagonista.segundo_nombre, protagonista.primer_apellido, protagonista.segundo_apellido,id_doctor,id_paciente,id_cita,estado from
        
        reserva inner join doctor on id_doctor=doctor_id_doctor inner join protagonista on protagonista_id_protagonista=id_paciente where id_doctor='$id' and estado='sin aceptar' ;")->fetchAll();
    }

       public function obtenerDatosDoctor($nombre)
    {
       return $this->_db->query("select *from doctor where usuario='$nombre'")->fetchAll();
    }


     public function agendarCita($idD,$idP,$idC)
    {

        $estado='aceptada';

        $this->_db->prepare('insert into confirmacion(doctor_id_doctor,protagonista_id_protagonista,id_cita_confirmacion)
    values(:idD,:idP,:idC)')->execute(array(
                    'idD' => $idD,
                    'idP' => $idP,
                    'idC' => $idC
                    
                ));

                      $this->_db->prepare('UPDATE reserva SET estado = :estado WHERE id_cita = :idC')
        ->execute([
            'estado' => $estado,
            'idC' => $idC
        ]);


    }

   

    

}
