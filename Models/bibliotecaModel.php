<?php
class bibliotecaModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener libros con filtro opcional por búsqueda y categoría
    public function obtenerLibros($busqueda = '', $categoria = '')
    {
        $query = "SELECT * FROM libros_lupus WHERE 1=1";
        $params = [];

        if ($busqueda != '') {
            $query .= " AND (titulo LIKE :busqueda OR autor LIKE :busqueda)";
            $params[':busqueda'] = "%$busqueda%";
        }

        if ($categoria != '') {
            $query .= " AND categoria = :categoria";
            $params[':categoria'] = $categoria;
        }

        $query .= " ORDER BY fecha_publicacion DESC";

        $stmt = $this->_db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
