<?php

class pacienteModel extends Model
{

    public function obtenerDatosReserva($nombre)
    {
        return $this->_db->query("select *from doctor where usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerPacientes($id)
    {
        return $this->_db->query("select *from confirmacion inner join doctor on doctor_id_doctor=id_doctor inner join protagonista on protagonista_id_protagonista=id_paciente inner join reserva on id_cita_confirmacion=id_cita where id_doctor='$id' and estado='aceptada'")->fetchAll();
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
