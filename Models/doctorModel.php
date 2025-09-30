<?php

class doctorModel extends Model
{

    public function obtenerDoctor()
    {
        return $this->_db->query("select *from doctor;")->fetchAll();
    }

  
    public function insertarDoctor($nombre,$sexo,$especialidad,$numero,$correo,$nombreU,$clave,$imagen)
    {
        $hash=password_hash($clave, PASSWORD_DEFAULT);
        $rol='doctor';


        $this->_db->prepare('insert into doctor(nombre_doctor,sexo,especialidad,correo,telefono,usuario,imagen)
    values(:nombre,:sexo,:especialidad,:correo,:telefono,:usuario,:imagen)')->execute(array(
                    'nombre' => $nombre,
                    'sexo' => $sexo,
                    'especialidad' => $especialidad,
                    'correo' => $correo,
                    'telefono' => $numero,
                    'usuario' => $nombreU,
                    'imagen' => $imagen
                    
                ));

                $this->_db->prepare('insert into usuario(nombre_usuario,clave,rol) values(:nombreU,:clave,:rol)')->execute(array(
                    'nombreU' => $nombreU,
                    'clave' => $hash,
                    'rol' => $rol
                ));

    }

    

    public function insertarServicioSinImagen($tipo,$descripcion,$precio)
    {
       
        $this->_db->prepare('insert into servicio(tipo_servicio,descripcion,precio)
    values(:tipo,:descripcion,:precio)')->execute(array(
                    'tipo' => $tipo,
                    'descripcion' => $descripcion,
                    'precio' => $precio
                    
                ));

    }

    public function actualizarDoctor($id, $nombre, $sexo, $especialidad, $telefono, $correo, $usuario, $clave, $imagen)
{
    $hash = password_hash($clave, PASSWORD_DEFAULT);
    $sql = "UPDATE doctor 
            SET nombre_doctor = :nombre, 
                sexo = :sexo, 
                especialidad = :especialidad, 
                telefono = :telefono, 
                correo = :correo, 
                usuario = :usuario, 
                imagen = :imagen 
            WHERE id_doctor = :id";
    
    $this->_db->prepare($sql)->execute([
        'nombre' => $nombre,
        'sexo' => $sexo,
        'especialidad' => $especialidad,
        'telefono' => $telefono,
        'correo' => $correo,
        'usuario' => $usuario,
        'imagen' => $imagen,
        'id' => $id
    ]);

    // También actualizar la tabla usuario
    $this->_db->prepare('UPDATE usuario SET nombre_usuario = :nombreU, clave = :clave WHERE nombre_usuario = :usuarioOld')
        ->execute([
            'nombreU' => $usuario,
            'clave' => $hash,
            'usuarioOld' => $usuario
        ]);
}

public function actualizarDoctorSinImagen($id, $nombre, $sexo, $especialidad, $telefono, $correo, $usuario, $clave)
{
    $hash = password_hash($clave, PASSWORD_DEFAULT);
    $sql = "UPDATE doctor 
            SET nombre_doctor = :nombre, 
                sexo = :sexo, 
                especialidad = :especialidad, 
                telefono = :telefono, 
                correo = :correo, 
                usuario = :usuario
            WHERE id_doctor = :id";
    
    $this->_db->prepare($sql)->execute([
        'nombre' => $nombre,
        'sexo' => $sexo,
        'especialidad' => $especialidad,
        'telefono' => $telefono,
        'correo' => $correo,
        'usuario' => $usuario,
        'id' => $id
    ]);

    // También actualizar la tabla usuario
    $this->_db->prepare('UPDATE usuario SET nombre_usuario = :nombreU, clave = :clave WHERE nombre_usuario = :usuarioOld')
        ->execute([
            'nombreU' => $usuario,
            'clave' => $hash,
            'usuarioOld' => $usuario
        ]);
}


    public function borrarServicio($id)
    {
        $this->_db->prepare('delete from doctor where id_doctor=:idDoctor')->execute(array('idDoctor' => $id));
    }




}
