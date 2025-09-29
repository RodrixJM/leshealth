<?php
class dietaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerDieta()
    {
        $query = $this->_db->query("SELECT * FROM dieta");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDietaPorId($id)
    {
        $query = $this->_db->prepare("SELECT * FROM dieta WHERE id_dieta = :id LIMIT 1");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarDieta($nombre, $tipo, $descripcion, $protagonista, $imagen)
    {
        $query = $this->_db->prepare("INSERT INTO dieta(nombre_plato, tipo, descripcion, protagonista_id_protagonista, imagen_platillo) VALUES(:nombre, :tipo, :descripcion, :protagonista, :imagen)");
        $query->execute([
            'nombre' => $nombre,
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'protagonista' => $protagonista,
            'imagen' => $imagen
        ]);
    }

    public function editarDieta($id, $nombre, $tipo, $descripcion, $protagonista, $imagen)
    {
        $query = $this->_db->prepare("UPDATE dieta SET nombre_plato=:nombre, tipo=:tipo, descripcion=:descripcion, protagonista_id_protagonista=:protagonista, imagen_platillo=:imagen WHERE id_dieta=:id");
        $query->execute([
            'nombre' => $nombre,
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'protagonista' => $protagonista,
            'imagen' => $imagen,
            'id' => $id
        ]);
    }

    public function borrarDieta($id)
    {
        $query = $this->_db->prepare("DELETE FROM dieta WHERE id_dieta=:id");
        $query->execute(['id' => $id]);
    }
}
?>
