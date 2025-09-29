<?php

class reportesModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todos los signos con el nombre del paciente
    public function obtenerSignos()
    {
        $sql = "SELECT s.*, CONCAT(p.primer_nombre, ' ', p.primer_apellido) AS paciente
                FROM signos s
                JOIN protagonista p ON s.protagonista_id_protagonista = p.id_paciente
                ORDER BY s.fecha DESC, s.hora DESC";
        return $this->_db->query($sql)->fetchAll();
    }

    // Obtener todos los pacientes para el select de filtro
    public function obtenerPacientes()
    {
        $sql = "SELECT id_paciente, primer_nombre, primer_apellido FROM protagonista ORDER BY primer_nombre ASC";
        return $this->_db->query($sql)->fetchAll();
    }

    // Obtener signos filtrados por paciente y rango de fechas
    public function obtenerSignosFiltrados($pacienteId = 0, $fechaDesde = null, $fechaHasta = null)
    {
        $sql = "SELECT s.*, CONCAT(p.primer_nombre, ' ', p.primer_apellido) AS paciente
                FROM signos s
                JOIN protagonista p ON s.protagonista_id_protagonista = p.id_paciente
                WHERE 1=1";

        $params = [];

        if ($pacienteId != 0) {
            $sql .= " AND s.protagonista_id_protagonista = :pacienteId";
            $params['pacienteId'] = $pacienteId;
        }

        if (!empty($fechaDesde)) {
            $sql .= " AND s.fecha >= :fechaDesde";
            $params['fechaDesde'] = $fechaDesde;
        }

        if (!empty($fechaHasta)) {
            $sql .= " AND s.fecha <= :fechaHasta";
            $params['fechaHasta'] = $fechaHasta;
        }

        $sql .= " ORDER BY s.fecha DESC, s.hora DESC";

        $stmt = $this->_db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}

?>
