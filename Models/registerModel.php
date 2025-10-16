<?php
class registerModel extends Model{

    public function registrarUsuario($usuario, $clave, $rol)
    {
        $query = $this->_db->prepare("INSERT INTO usuario(nombre_usuario, clave, rol) VALUES(:usuario, :claveUsuario, :rolUsuario)");
        $query->execute([
            'usuario' => $usuario,
            'claveUsuario' => $clave,
            'rolUsuario' => $rol
        ]);
    }
}