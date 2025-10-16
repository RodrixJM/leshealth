<?php
class registerModel extends Model{

    public function registrarUsuario($usuario, $clave, $rol)
    {
        $hash = password_hash($clave, PASSWORD_DEFAULT);
        $query = $this->_db->prepare("INSERT INTO usuario(nombre_usuario, clave, rol) VALUES(:usuario, :claveUsuario, :rolUsuario)");
        $query->execute([
            'usuario' => $usuario,
            'claveUsuario' => $hash,
            'rolUsuario' => $rol
        ]);
    }
}