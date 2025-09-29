<?php

class protagonistaModel extends Model
{

    public function obtenerProtagonista()
    {
        return $this->_db->query("select * from protagonista;")->fetchAll();
    }

    
    public function obtenerDepartamento()
    {
        return $this->_db->query("select * from departamento;")->fetchAll();
    }

    public function obtenerCausas()
    {
        return $this->_db->query("select * from causas;")->fetchAll();
    }

    public function obtenerMunicipio($idDepartamento)
    {
        return $this->_db->query("select * from municipio where departamento_id_departamento='$idDepartamento'")->fetchAll();
    }

    public function insertarProtagonista($pNombre,$sNombre,$pApellido,$sApellido,$cedula,$municipioOrigen,$fechaNacio,$edad,$sexo,$nacionalidad,$ocupacion,$estadoCivil,$direccion,$numero,$correo,$nombreU,$clave,$imagen)
    {
        $hash=password_hash($clave, PASSWORD_DEFAULT);
        $rol='protagonista';
        $this->_db->prepare('insert into protagonista(primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,cedula,municipio,fecha_nacimiento,edad,sexo,nacionalidad,estado_civil,ocupacion,direccion,correo,telefono,usuario,imagen)
    values(:pNombre,:sNombre,:pApellido,:sApellido,:cedula,:municipioOrigen,:fecha,:edad,:sexo,:nacionalidad,:estadoCivil,:ocupacion,:direccion,:correo,:numero,:nombreU,:imagen)')->execute(array(
                    'pNombre' => $pNombre,
                    'sNombre' => $sNombre,
                    'pApellido' => $pApellido,
                    'sApellido' => $sApellido,
                    'cedula' => $cedula,
                    'municipioOrigen' => $municipioOrigen,
                    'fecha' => $fechaNacio,
                    'edad' => $edad,
                    'sexo' => $sexo,
                    'nacionalidad' => $nacionalidad,
                    'ocupacion' => $ocupacion,
                    'estadoCivil' => $estadoCivil,
                    'direccion' => $direccion,
                    'correo' => $correo,
                    'numero' => $numero,
                    'nombreU' => $nombreU,
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
