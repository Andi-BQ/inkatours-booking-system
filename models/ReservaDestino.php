<?php
class ReservaDestino {
    private $conn;
    private $table = 'reserva_destinos';

    public $id;
    public $reserva_id;
    public $destino_id;
    public $precio;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET reserva_id = :reserva_id, destino_id = :destino_id, precio = :precio';
        
        $stmt = $this->conn->prepare($query);

        $this->reserva_id = htmlspecialchars(strip_tags($this->reserva_id));
        $this->destino_id = htmlspecialchars(strip_tags($this->destino_id));
        $this->precio = htmlspecialchars(strip_tags($this->precio));

        $stmt->bindParam(':reserva_id', $this->reserva_id);
        $stmt->bindParam(':destino_id', $this->destino_id);
        $stmt->bindParam(':precio', $this->precio);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}

