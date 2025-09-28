<?php

class indexModel extends Model
{

    public function obtenerDatosReserva($nombre)
    {
        return $this->_db->query("select *from reserva inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista.usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerCitas($id)
    {
        return $this->_db->query("SELECT 
    d.nombre_doctor,
    d.especialidad,
    d.telefono,
    d.imagen AS imagen_doctor,   -- renombramos para que no se confunda
    r.fecha,
    r.hora,
    p.primer_nombre AS paciente,
    r.motivo
FROM reserva r
INNER JOIN doctor d ON d.id_doctor = r.doctor_id_doctor
INNER JOIN protagonista p ON p.id_paciente = r.protagonista_id_protagonista
WHERE r.protagonista_id_protagonista='$id';")->fetchAll();
    }

     public function obtenerDatosMedicacion($nombre)
    {
        return $this->_db->query("select *from reserva inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista.usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerMedicacion($id)
    {
        return $this->_db->query("select *from medicacion inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista_id_protagonista='$id';")->fetchAll();
    }

     public function obtenerDatosDieta($nombre)
    {
        return $this->_db->query("select *from reserva inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista.usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerDieta($id)
    {
        return $this->_db->query("select *from dieta inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista_id_protagonista='$id';")->fetchAll();
    }


     public function obtenerDatosEjercicio($nombre)
    {
        return $this->_db->query("select *from reserva inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista.usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerEjercicio($id)
    {
        return $this->_db->query("select *from ejercicio inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista_id_protagonista='$id';")->fetchAll();
    }

      public function obtenerDatosSigno($nombre)
    {
        return $this->_db->query("select *from reserva inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista.usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerSigno($id)
    {
        return $this->_db->query("select *from signos inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista_id_protagonista='$id';")->fetchAll();
    }





    public function obtenerColaboradores()
    {
        return $this->_db->query("select *from doctor;")->fetchAll();
    }

    

}
