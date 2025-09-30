<?php

class usuarioModel extends Model
{

    public function obtenerUsuario()
    {
        return $this->_db->query("select *from usuario;")->fetchAll();
    }

     public function obtenerUsuariosPorRol($rol)
    {
        $query = $this->_db->prepare("SELECT * FROM usuario WHERE rol = :rol");
        $query->execute(['rol' => $rol]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProtagonistas()
    {
        return $this->obtenerUsuariosPorRol('protagonista');
    }


    public function obtenerUsuarioPorId($id)
{
    $query = $this->_db->prepare("SELECT * FROM usuario WHERE id_usuario = :id LIMIT 1");
    $query->execute(['id' => $id]);
    return $query->fetch(PDO::FETCH_ASSOC);
}


    public function obtenerDepartamento()
    {
        return $this->_db->query("select * from departamento;")->fetchAll();
    }

    public function obtenerMunicipio($idDepartamento)
    {
        return $this->_db->query("select * from municipio where departamento_id_departamento='$idDepartamento'")->fetchAll();
    }

    public function insertarUsuario($nombre, $clave, $rol)
    {
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $this->_db->prepare('insert into usuario(nombre_usuario,clave,rol)
    values(:nombre,:clave,:rol)')->execute(array(
                    'nombre' => $nombre,
                    'clave' => $hash,
                    'rol' => $rol,
                ));

    }

    public function editarUsuario($id, $nombre, $clave, $rol)
    {
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $this->_db->prepare('UPDATE usuario SET nombre_usuario = :nombre, clave = :clave, rol = :rol WHERE id_usuario = :id')
            ->execute(array(
                'nombre' => $nombre,
                'clave' => $hash,
                'rol' => $rol,
                'id' => $id
            ));
    }

    public function borrarUsuario($id)
    {
        $this->_db->prepare('DELETE FROM usuario WHERE id_usuario = :id')
            ->execute(array(
                'id' => $id
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
