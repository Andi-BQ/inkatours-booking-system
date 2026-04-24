<?php
class Resena {
    private $conn;
    private $table = 'resenas';

    public $id;
    public $usuario_id;
    public $tipo;
    public $elemento_id;
    public $calificacion;
    public $titulo;
    public $comentario;
    public $recomendado;
    public $aprobado;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET usuario_id = :usuario_id, tipo = :tipo, elemento_id = :elemento_id, calificacion = :calificacion, titulo = :titulo, comentario = :comentario, aprobado = 0';
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->elemento_id = htmlspecialchars(strip_tags($this->elemento_id));
        $this->calificacion = htmlspecialchars(strip_tags($this->calificacion));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->comentario = htmlspecialchars(strip_tags($this->comentario));

        // Bind data
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':elemento_id', $this->elemento_id);
        $stmt->bindParam(':calificacion', $this->calificacion);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':comentario', $this->comentario);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getReviewsByElemento($elemento_id, $tipo) {
        $query = 'SELECT res.*, u.nombre as usuario_nombre FROM ' . $this->table . ' res LEFT JOIN usuarios u ON res.usuario_id = u.id WHERE res.elemento_id = ? AND res.tipo = ? AND res.aprobado = 1 ORDER BY res.created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $elemento_id);
        $stmt->bindParam(2, $tipo);
        $stmt->execute();
        return $stmt;
    }

    public function getRecentReviews($limit = 5) {
        $query = 'SELECT
                    res.titulo, res.comentario, res.calificacion, res.created_at,
                    u.nombre as usuario_nombre,
                    COALESCE(d.nombre, a.nombre) AS item_nombre,
                    COALESCE(d.slug, a.slug) AS item_slug,
                    CASE WHEN res.tipo = "destino" THEN "destinos" WHEN res.tipo = "actividad" THEN "actividades" ELSE "" END AS item_path
                FROM ' . $this->table . ' res
                LEFT JOIN usuarios u ON res.usuario_id = u.id
                LEFT JOIN destinos d ON res.elemento_id = d.id AND res.tipo = "destino"
                LEFT JOIN actividades a ON res.elemento_id = a.id AND res.tipo = "actividad"
                WHERE res.aprobado = 1 AND (d.id IS NOT NULL OR a.id IS NOT NULL)
                ORDER BY res.created_at DESC
                LIMIT :limit';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllReviews() {
        $query = 'SELECT res.*, u.nombre as usuario_nombre 
                  FROM ' . $this->table . ' res 
                  LEFT JOIN usuarios u ON res.usuario_id = u.id 
                  ORDER BY res.aprobado ASC, res.created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approve($id) {
        $query = 'UPDATE ' . $this->table . ' SET aprobado = 1 WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function disapprove($id) {
        $query = 'UPDATE ' . $this->table . ' SET aprobado = 0 WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function reject($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function hasBeenReviewed($usuario_id, $elemento_id, $tipo) {
        $query = 'SELECT id FROM ' . $this->table . ' WHERE usuario_id = ? AND elemento_id = ? AND tipo = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $usuario_id);
        $stmt->bindParam(2, $elemento_id);
        $stmt->bindParam(3, $tipo);
        $stmt->execute();
        if ($stmt->fetch()) {
            return true;
        }
        return false;
    }
}