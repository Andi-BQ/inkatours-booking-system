<?php
class Actividad {
    private $conn;
    private $table = 'actividades';

    public $id;
    public $nombre;
    public $slug;
    public $descripcion;
    public $descripcion_corta;
    public $imagen_principal;
    public $categoria;
    public $duracion;
    public $participantes_min;
    public $participantes_max;
    public $dificultad;
    public $impacto;
    public $precio;
    public $incluye;
    public $requisitos;
    public $destacado;
    public $activo;
    public $rating_promedio;
    public $total_resenas;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readWithLocation() {
        $query = 'SELECT a.*, ST_X(d.ubicacion) as lng, ST_Y(d.ubicacion) as lat
                  FROM ' . $this->table . ' a
                  LEFT JOIN destinos_actividades da ON a.id = da.actividad_id
                  LEFT JOIN destinos d ON da.destino_id = d.id
                  WHERE d.ubicacion IS NOT NULL
                  GROUP BY a.id
                  ORDER BY a.created_at DESC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nombre = $row['nombre'];
            $this->slug = $row['slug'];
            $this->descripcion = $row['descripcion'];
            $this->descripcion_corta = $row['descripcion_corta'];
            $this->imagen_principal = $row['imagen_principal'];
            $this->categoria = $row['categoria'];
            $this->duracion = $row['duracion'];
            $this->participantes_min = $row['participantes_min'];
            $this->participantes_max = $row['participantes_max'];
            $this->dificultad = $row['dificultad'];
            $this->impacto = $row['impacto'];
            $this->precio = $row['precio'];
            $this->incluye = $row['incluye'];
            $this->requisitos = $row['requisitos'];
            $this->destacado = $row['destacado'];
            $this->activo = $row['activo'];
            $this->rating_promedio = $row['rating_promedio'];
            $this->total_resenas = $row['total_resenas'];
        }
    }
    public function read_featured() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE destacado = 1 ORDER BY created_at DESC LIMIT 4';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($data) {
        $query = 'INSERT INTO ' . $this->table . ' SET 
                    nombre = :nombre,
                    slug = :slug,
                    descripcion = :descripcion,
                    descripcion_corta = :descripcion_corta,
                    imagen_principal = :imagen_principal,
                    categoria = :categoria,
                    duracion = :duracion,
                    dificultad = :dificultad,
                    impacto = :impacto,
                    precio = :precio
                  ';

        $stmt = $this->conn->prepare($query);

        // Sanitize data from the form
        $nombre = htmlspecialchars(strip_tags($data['nombre']));
        $slug = htmlspecialchars(strip_tags($data['slug']));
        $descripcion = htmlspecialchars(strip_tags($data['descripcion']));
        $descripcion_corta = htmlspecialchars(strip_tags($data['descripcion_corta']));
        $imagen_principal = htmlspecialchars(strip_tags($data['imagen_principal']));
        $categoria = htmlspecialchars(strip_tags($data['categoria']));
        $duracion = htmlspecialchars(strip_tags($data['duracion']));
        $dificultad = htmlspecialchars(strip_tags($data['dificultad']));
        $impacto = htmlspecialchars(strip_tags($data['impacto']));
        $precio = htmlspecialchars(strip_tags($data['precio']));

        // Bind data
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':descripcion_corta', $descripcion_corta);
        $stmt->bindParam(':imagen_principal', $imagen_principal);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':duracion', $duracion);
        $stmt->bindParam(':dificultad', $dificultad);
        $stmt->bindParam(':impacto', $impacto);
        $stmt->bindParam(':precio', $precio);

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET 
                    nombre = :nombre,
                    descripcion = :descripcion
                  WHERE id = :id';
        
        $stmt = $this->conn->prepare($query);

        $nombre = htmlspecialchars(strip_tags($data['nombre']));
        $descripcion = htmlspecialchars(strip_tags($data['descripcion']));
        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function search($query) {
        $search_query = $query . '%'; // Search for names that start with the query
        $sql = 'SELECT id, nombre, slug, imagen_principal, descripcion_corta, "actividad" as tipo FROM ' . $this->table . '
                WHERE nombre LIKE :query';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':query', $search_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
