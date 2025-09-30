<?php
class medicacionModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function obtenerMedicacion()
    {
        $query = $this->_db->query("SELECT * FROM medicacion");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerMedicacionPorId($id)
    {
        $query = $this->_db->prepare("SELECT * FROM medicacion WHERE id_medicacion = :id LIMIT 1");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insertarMedicacion($nombre, $dosis, $frecuencia, $hora, $fecha, $duracion, $protagonista, $imagen)
    {
        $query = $this->_db->prepare("INSERT INTO medicacion(nombre_medicamento, dosis, frecuencia, hora_aplicacion, fecha, duracion, protagonista_id_protagonista, imagenMedicina) VALUES(:nombre, :dosis, :frecuencia, :hora, :fecha, :duracion, :protagonista, :imagen)");
        $query->execute([
            'nombre' => $nombre,
            'dosis' => $dosis,
            'frecuencia' => $frecuencia,
            'hora' => $hora,
            'fecha' => $fecha,
            'duracion' => $duracion,
            'protagonista' => $protagonista,
            'imagen' => $imagen
        ]);
    }

    public function editarMedicacion($id, $nombre, $dosis, $frecuencia, $hora, $fecha, $duracion, $protagonista, $imagen)
    {
        $query = $this->_db->prepare("UPDATE medicacion SET nombre_medicamento=:nombre, dosis=:dosis, frecuencia=:frecuencia, hora_aplicacion=:hora, fecha=:fecha, duracion=:duracion, protagonista_id_protagonista=:protagonista, imagenMedicina=:imagen WHERE id_medicacion=:id");
        $query->execute([
            'nombre' => $nombre,
            'dosis' => $dosis,
            'frecuencia' => $frecuencia,
            'hora' => $hora,
            'fecha' => $fecha,
            'duracion' => $duracion,
            'protagonista' => $protagonista,
            'imagen' => $imagen,
            'id' => $id
        ]);
    }

    public function borrarMedicacion($id)
    {
        $query = $this->_db->prepare("DELETE FROM medicacion WHERE id_medicacion=:id");
        $query->execute(['id' => $id]);
    }
}
?>
