<?php
class Contacto {
    private $conn;
    private $table = 'contactos';

    public $id;
    public $nombre;
    public $email;
    public $telefono;
    public $asunto;
    public $mensaje;
    public $leido;
    public $respondido;
    public $respuesta;
    public $usuario_id;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET 
            nombre = :nombre,
            email = :email,
            telefono = :telefono,
            asunto = :asunto,
            mensaje = :mensaje';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->asunto = htmlspecialchars(strip_tags($this->asunto));
        $this->mensaje = htmlspecialchars(strip_tags($this->mensaje));

        // Bind data
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':asunto', $this->asunto);
        $stmt->bindParam(':mensaje', $this->mensaje);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
