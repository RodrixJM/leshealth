<?php
class deteccionModel extends Model
{
    public function insertarResultado($respuestas, $resultado)
    {
        $this->_db->prepare("INSERT INTO resultados_deteccion (respuestas, resultado, fecha) VALUES (:respuestas, :resultado, NOW())")
        ->execute([
            'respuestas' => $respuestas,
            'resultado' => $resultado
        ]);
    }


      public function obtenerDatosU($nombre)
    {
        return $this->_db->query("select *from protagonista where usuario="."'$nombre'")->fetchAll();
    }


    public function guardarDeteccion($idPaciente, $respuestas, $diagnostico) {
    $sql = "INSERT INTO resultados_deteccion 
            (respuestas, resultado, fecha, protagonista_id_protagonista)
            VALUES (:respuestas, :resultado, NOW(), :protagonista_id_protagonista)";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute([
        'respuestas' => $respuestas,
        'resultado' => $diagnostico,
        'protagonista_id_protagonista' => $idPaciente
    ]);
}
}
