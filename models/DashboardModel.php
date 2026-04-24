<?php
class DashboardModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene el número total de participantes de reservas futuras confirmadas o pagadas por destino.
     */
    public function getAfluenciaActual() {
        $query = "SELECT
                    d.nombre AS Destino,
                    SUM(r.participantes) AS ParticipantesFuturos
                  FROM
                    reservas r
                  JOIN
                    reserva_destinos rd ON r.id = rd.reserva_id
                  JOIN
                    destinos d ON rd.destino_id = d.id
                  WHERE
                    r.fecha_experiencia >= CURDATE()
                    AND r.estado IN ('confirmada', 'pagada')
                  GROUP BY
                    d.id, d.nombre
                  ORDER BY
                    ParticipantesFuturos DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene las predicciones de afluencia para un rango de fechas.
     */
    public function getPrediccionesRecientes() {
        $query = "SELECT
                    d.nombre AS Destino,
                    p.fecha,
                    p.hora,
                    p.afluencia_esperada,
                    p.nivel
                  FROM
                    predicciones_afluencia p
                  JOIN
                    destinos d ON p.destino_id = d.id
                  WHERE
                    p.fecha BETWEEN CURDATE() AND (CURDATE() + INTERVAL 7 DAY)
                  ORDER BY
                    p.fecha, p.hora, d.nombre";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los destinos activos con su nivel de afluencia predicho más próximo para hoy.
     */
    public function getDestinosConAfluenciaActual() {
        $query = "SELECT
                    d.id,
                    d.nombre,
                    ST_Y(d.ubicacion) AS lat,
                    ST_X(d.ubicacion) AS lng,
                    (
                        SELECT p.nivel
                        FROM predicciones_afluencia p
                        WHERE p.destino_id = d.id AND p.fecha = CURDATE() AND p.hora >= CURTIME()
                        ORDER BY p.hora ASC
                        LIMIT 1
                    ) AS nivel_afluencia
                  FROM
                    destinos d
                  WHERE
                    d.activo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>