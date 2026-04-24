<?php

class ParticipanteReserva {
    private $conn;
    private $table = 'participantes_reserva';

    public $id;
    public $reserva_id;
    public $nombre;
    public $email;
    public $telefono;
    public $fecha_nacimiento;
    public $documento_identidad;
    public $tipo_documento; // Usado para 'tipo_turista' (local, nacional, extranjero)

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' 
            SET
                reserva_id = :reserva_id,
                nombre = :nombre,
                email = :email,
                telefono = :telefono,
                tipo_documento = :tipo_documento';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->reserva_id = htmlspecialchars(strip_tags($this->reserva_id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = !empty($this->email) ? htmlspecialchars(strip_tags($this->email)) : null;
        $this->telefono = !empty($this->telefono) ? htmlspecialchars(strip_tags($this->telefono)) : null;
        $this->tipo_documento = htmlspecialchars(strip_tags($this->tipo_documento));

        // Bind data
        $stmt->bindParam(':reserva_id', $this->reserva_id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':tipo_documento', $this->tipo_documento);

        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function getByReservaId($reserva_id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE reserva_id = :reserva_id';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':reserva_id', $reserva_id);
        
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

