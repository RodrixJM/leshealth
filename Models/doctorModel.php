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

    public function actualizarServicio($id, $nombre)
    {
        $sql = 'UPDATE servicio 
        SET nombre_departamento = :nombre
        WHERE id_departamento = :id';

        $stmt = $this->_db->prepare($sql);

        $stmt->execute(array(
            'nombre' => $nombre,
            'id' => $id
            
        ));

    }

    public function borrarServicio($id)
    {
        $this->_db->prepare('delete from servicio where id_departamento=:idDepartamento')->execute(array('idDepartamento' => $id));
    }




}
