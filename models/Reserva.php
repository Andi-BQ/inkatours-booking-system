<?php
class Reserva {
    private $conn;
    private $table = 'reservas';

    public $id;
    public $numero_reserva;
    public $usuario_id;
    public $tipo;
    public $estado;
    public $fecha_reserva;
    public $fecha_experiencia;
    public $participantes;
    public $precio_unitario;
    public $subtotal;
    public $impuestos;
    public $total;
    public $moneda;
    public $metodo_pago;
    public $id_pago;
    public $notas;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET 
            numero_reserva = :numero_reserva,
            usuario_id = :usuario_id,
            tipo = :tipo,
            estado = :estado,
            fecha_reserva = :fecha_reserva,
            fecha_experiencia = :fecha_experiencia,
            participantes = :participantes,
            precio_unitario = :precio_unitario,
            subtotal = :subtotal,
            impuestos = :impuestos,
            total = :total,
            moneda = :moneda,
            metodo_pago = :metodo_pago,
            id_pago = :id_pago,
            notas = :notas';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->numero_reserva = htmlspecialchars(strip_tags($this->numero_reserva));
        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        $this->fecha_reserva = htmlspecialchars(strip_tags($this->fecha_reserva));
        $this->fecha_experiencia = htmlspecialchars(strip_tags($this->fecha_experiencia));
        $this->participantes = htmlspecialchars(strip_tags($this->participantes));
        $this->precio_unitario = htmlspecialchars(strip_tags($this->precio_unitario));
        $this->subtotal = htmlspecialchars(strip_tags($this->subtotal));
        $this->impuestos = htmlspecialchars(strip_tags($this->impuestos));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->moneda = htmlspecialchars(strip_tags($this->moneda));
        $this->metodo_pago = htmlspecialchars(strip_tags($this->metodo_pago));
        $this->id_pago = htmlspecialchars(strip_tags($this->id_pago));
        $this->notas = htmlspecialchars(strip_tags($this->notas));

        // Bind data
        $stmt->bindParam(':numero_reserva', $this->numero_reserva);
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':fecha_reserva', $this->fecha_reserva);
        $stmt->bindParam(':fecha_experiencia', $this->fecha_experiencia);
        $stmt->bindParam(':participantes', $this->participantes);
        $stmt->bindParam(':precio_unitario', $this->precio_unitario);
        $stmt->bindParam(':subtotal', $this->subtotal);
        $stmt->bindParam(':impuestos', $this->impuestos);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':moneda', $this->moneda);
        $stmt->bindParam(':metodo_pago', $this->metodo_pago);
        $stmt->bindParam(':id_pago', $this->id_pago);
        $stmt->bindParam(':notas', $this->notas);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }

    public function updatePagoId($id, $pago_id) {
        $query = 'UPDATE ' . $this->table . ' SET id_pago = :pago_id WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $pago_id = htmlspecialchars(strip_tags($pago_id));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':pago_id', $pago_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getReservaByNumero($numero_reserva) {
        $query = 'SELECT 
                    r.*, 
                    u.nombre as usuario_nombre, 
                    u.email as usuario_email,
                    COALESCE(d.nombre, a.nombre) AS item_nombre
                  FROM ' . $this->table . ' r
                  LEFT JOIN usuarios u ON r.usuario_id = u.id
                  LEFT JOIN reserva_destinos rd ON r.id = rd.reserva_id AND r.tipo = "destino"
                  LEFT JOIN destinos d ON rd.destino_id = d.id
                  LEFT JOIN reserva_actividades ra ON r.id = ra.reserva_id AND r.tipo = "actividad"
                  LEFT JOIN actividades a ON ra.actividad_id = a.id
                  WHERE r.numero_reserva = ?
                  LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $numero_reserva);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readByUserId($usuario_id) {
        $query = 'SELECT
                        r.id,
                        r.numero_reserva,
                        r.fecha_experiencia,
                        r.participantes,
                        r.total,
                        r.estado,
                        r.tipo,
                        COALESCE(d.nombre, a.nombre) AS item_nombre,
                        COALESCE(d.imagen_principal, a.imagen_principal) AS item_imagen,
                        COALESCE(d.slug, a.slug) AS item_slug,
                        COALESCE(rd.destino_id, ra.actividad_id) AS elemento_id,
                        CASE 
                            WHEN r.tipo = "destino" THEN "destinos"
                            WHEN r.tipo = "actividad" THEN "actividades"
                            ELSE ""
                        END AS item_path
                    FROM
                        ' . $this->table . ' as r
                    LEFT JOIN
                        reserva_destinos as rd ON r.id = rd.reserva_id AND r.tipo = "destino"
                    LEFT JOIN
                        destinos as d ON rd.destino_id = d.id
                    LEFT JOIN
                        reserva_actividades as ra ON r.id = ra.reserva_id AND r.tipo = "actividad"
                    LEFT JOIN
                        actividades as a ON ra.actividad_id = a.id
                    WHERE
                        r.usuario_id = :usuario_id
                    ORDER BY
                        r.fecha_experiencia DESC';
    
        $stmt = $this->conn->prepare($query);
    
        // Bind user_id
        $stmt->bindParam(':usuario_id', $usuario_id);
    
        $stmt->execute();
    
        return $stmt;
    }

    public function getReservaCompletaByNumero($numero_reserva) {
        $reserva_base = $this->getReservaByNumero($numero_reserva);
        if ($reserva_base) {
            return $this->getReservaCompletaById($reserva_base['id']);
        }
        return null;
    }

    public function getReservaCompletaById($id) {
        $query = 'SELECT
                        r.*,
                        u.nombre as usuario_nombre, 
                        u.email as usuario_email,
                        COALESCE(d.nombre, a.nombre) AS item_nombre,
                        COALESCE(d.imagen_principal, a.imagen_principal) AS item_imagen,
                        CASE 
                            WHEN r.tipo = "destino" THEN "destinos"
                            WHEN r.tipo = "actividad" THEN "actividades"
                            ELSE ""
                        END AS item_path,
                        COALESCE(rd.destino_id, ra.actividad_id) AS elemento_id
                    FROM ' . $this->table . ' as r
                    LEFT JOIN usuarios u ON r.usuario_id = u.id
                    LEFT JOIN reserva_destinos as rd ON r.id = rd.reserva_id AND r.tipo = "destino"
                    LEFT JOIN destinos as d ON rd.destino_id = d.id
                    LEFT JOIN reserva_actividades as ra ON r.id = ra.reserva_id AND r.tipo = "actividad"
                    LEFT JOIN actividades as a ON ra.actividad_id = a.id
                    WHERE r.id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reserva) {
            // Cargar dinámicamente el modelo de participantes si es necesario
            $participanteModel = new ParticipanteReserva($this->conn);
            $reserva['participantes_detalle'] = $participanteModel->getByReservaId($reserva['id']);
        }

        return $reserva;
    }

    public function getByPagoId($pago_id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_pago = :pago_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pago_id', $pago_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEstado($id, $estado) {
        $query = 'UPDATE ' . $this->table . ' SET estado = :estado WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $estado = htmlspecialchars(strip_tags($estado));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':estado', $estado);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function confirmarPagoCompleto($id, $nuevo_total) {
        $query = 'UPDATE ' . $this->table . ' SET total = :total, estado = :estado WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $nuevo_total = htmlspecialchars(strip_tags($nuevo_total));
        $nuevo_estado = 'confirmada';

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':total', $nuevo_total);
        $stmt->bindParam(':estado', $nuevo_estado);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
