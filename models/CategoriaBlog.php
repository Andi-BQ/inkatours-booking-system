<?php
class CategoriaBlog {
    private $conn;
    private $table = 'categorias_blog';

    public $id;
    public $nombre;
    public $slug;
    public $descripcion;
    public $color;
    public $activo;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE activo = 1 ORDER BY nombre ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
