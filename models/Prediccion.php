<?php
class Prediccion {
    private $conn;
    private $table = 'predicciones_afluencia';

    public $id;
    public $destino_id;
    public $fecha;
    public $hora;
    public $afluencia_esperada;
    public $nivel;
    public $confianza;
    public $factores;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT p.*, d.nombre as destino_nombre 
                  FROM ' . $this->table . ' p
                  LEFT JOIN destinos d ON p.destino_id = d.id
                  ORDER BY p.fecha DESC, p.hora DESC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAfluenciaActual() {
        // Query to get total participants for upcoming dates from confirmed or pending reservations
        $query = 'SELECT
                        d.id as destino_id,
                        d.nombre as destino_nombre,
                        SUM(r.participantes) as total_participantes
                    FROM
                        reservas r
                    JOIN
                        reserva_destinos rd ON r.id = rd.reserva_id
                    JOIN
                        destinos d ON rd.destino_id = d.id
                    WHERE
                        r.fecha_experiencia >= CURDATE()
                        AND r.estado IN (:estado_confirmada, :estado_pendiente)
                    GROUP BY
                        d.id, d.nombre
                    ORDER BY
                        total_participantes DESC';

        $stmt = $this->conn->prepare($query);
        $confirmedStatus = 'confirmada';
        $pendingStatus = 'pendiente';
        $stmt->bindParam(':estado_confirmada', $confirmedStatus);
        $stmt->bindParam(':estado_pendiente', $pendingStatus);
        
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Define thresholds for afluencia levels
        $afluencia_data = [];
        foreach ($results as $row) {
            $level = 'Bajo';
            if ($row['total_participantes'] > 50) {
                $level = 'Alto';
            } elseif ($row['total_participantes'] > 20) {
                $level = 'Medio';
            }
            
            $afluencia_data[] = [
                'destino_nombre' => $row['destino_nombre'],
                'total_participantes' => $row['total_participantes'],
                'nivel' => $level
            ];
        }

        return $afluencia_data;
    }
}
