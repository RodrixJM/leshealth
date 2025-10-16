<?php

class reservaModel extends Model
{

    public function obtenerDatosReserva($nombre)
    {
        return $this->_db->query("select *from protagonista where protagonista.usuario="."'$nombre'")->fetchAll();
    }

       public function obtenerReservas($id)
    {
        return $this->_db->query("select *from reserva inner join doctor on id_doctor=doctor_id_doctor inner join protagonista on id_paciente=protagonista_id_protagonista where protagonista_id_protagonista='$id';")->fetchAll();
    }

    public function obtenerEspecialista()
    {
        return $this->_db->query("select * from doctor;")->fetchAll();
    }


    public function obtenerMunicipio($idDepartamento)
    {
        return $this->_db->query("select * from municipio where departamento_id_departamento='$idDepartamento'")->fetchAll();
    }


     public function insertarReserva($hora, $fecha, $especialista, $prioridad, $motivo, $idProtagonista, $imagen)
    {
        $estado='sin aceptar';
        $this->_db->prepare('insert into reserva(hora,fecha,doctor_id_doctor,protagonista_id_protagonista,motivo,prioridad,imagen,estado)
    values(:hora,:fecha,:doctor,:protagonista,:motivo,:prioridad,:imagen,:estado)')->execute(array(
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'doctor' => $especialista,
                    'protagonista' => $idProtagonista,
                    'motivo' => $motivo,
                    'prioridad' => $prioridad,
                    'imagen' => $imagen,
                    'estado' => $estado
                    
                ));


       

    }





    public function actualizarCementerio($nombreUp, $municipioUp, $latitudUp, $longitudUp, $capacidadUp, $tipoUp, $horaAperturaUp, $horaCierreUp, $idCementerioUp)
    {
        $sql = 'UPDATE cementerio 
        SET nombre = :nombre, 
            latitud = :latitud, 
            longitud = :longitud, 
            capacidad = :capacidad, 
            tipo = :tipo, 
            hora_apertura = :hora_apertura, 
            hora_cierre = :hora_cierre, 
            municipio_id_municipio = :municipio 
        WHERE id_cementerio = :idCementerioUp';

        $stmt = $this->_db->prepare($sql);

        $stmt->execute(array(
            'nombre' => $nombreUp,
            'latitud' => $latitudUp,
            'longitud' => $longitudUp,
            'capacidad' => $capacidadUp,
            'tipo' => $tipoUp,
            'hora_apertura' => $horaAperturaUp,
            'hora_cierre' => $horaCierreUp,
            'municipio' => $municipioUp,
            'idCementerioUp' => $idCementerioUp
        ));

    }

    public function borrarCementerio($idCementerio)
    {
        $this->_db->prepare('delete from cementerio where id_cementerio=:idCementerio')->execute(array('idCementerio' => $idCementerio));
    }




}
