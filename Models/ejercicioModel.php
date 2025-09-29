<?php
class ejercicioModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerEjercicios()
    {
        $query = $this->_db->query("SELECT * FROM ejercicio");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEjercicioPorId($id)
    {
        $query = $this->_db->prepare("SELECT * FROM ejercicio WHERE id_ejercicio = :id LIMIT 1");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarEjercicio($nombre, $repeticiones, $series, $protagonista, $imagen)
    {
        $query = $this->_db->prepare("INSERT INTO ejercicio(nombre_ejercicio, repeticiones, series, protagonista_id_protagonista, imagen_ejercicio) VALUES(:nombre, :repeticiones, :series, :protagonista, :imagen)");
        $query->execute([
            'nombre' => $nombre,
            'repeticiones' => $repeticiones,
            'series' => $series,
            'protagonista' => $protagonista,
            'imagen' => $imagen
        ]);
    }

    public function editarEjercicio($id, $nombre, $repeticiones, $series, $protagonista, $imagen)
    {
        $query = $this->_db->prepare("UPDATE ejercicio SET nombre_ejercicio=:nombre, repeticiones=:repeticiones, series=:series, protagonista_id_protagonista=:protagonista, imagen_ejercicio=:imagen WHERE id_ejercicio=:id");
        $query->execute([
            'nombre' => $nombre,
            'repeticiones' => $repeticiones,
            'series' => $series,
            'protagonista' => $protagonista,
            'imagen' => $imagen,
            'id' => $id
        ]);
    }

    public function borrarEjercicio($id)
    {
        $query = $this->_db->prepare("DELETE FROM ejercicio WHERE id_ejercicio=:id");
        $query->execute(['id' => $id]);
    }
}
?>
