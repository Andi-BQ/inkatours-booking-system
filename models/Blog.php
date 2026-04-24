<?php
class Blog {
    private $conn;
    private $table = 'articulos_blog';

    public $id;
    public $titulo;
    public $slug;
    public $contenido;
    public $resumen;
    public $imagen_principal;
    public $categoria_id;
    public $autor_id;
    public $fecha_publicacion;
    public $tiempo_lectura;
    public $palabras_clave;
    public $destacado;
    public $activo;
    public $visitas;
    public $likes;
    public $created_at;
    public $updated_at;

    public $categoria_nombre;
    public $autor_nombre;
    public $categoria_color;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT 
                    b.*, 
                    c.nombre as categoria_nombre,
                    c.color as categoria_color,
                    u.nombre as autor_nombre
                  FROM ' . $this->table . ' b
                  LEFT JOIN categorias_blog c ON b.categoria_id = c.id
                  LEFT JOIN usuarios u ON b.autor_id = u.id
                  ORDER BY b.fecha_publicacion DESC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT 
                    b.*, 
                    c.nombre as categoria_nombre,
                    c.color as categoria_color,
                    u.nombre as autor_nombre
                  FROM ' . $this->table . ' b
                  LEFT JOIN categorias_blog c ON b.categoria_id = c.id
                  LEFT JOIN usuarios u ON b.autor_id = u.id
                  WHERE b.id = ?
                  LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->titulo = $row['titulo'];
            $this->slug = $row['slug'];
            $this->contenido = $row['contenido'];
            $this->resumen = $row['resumen'];
            $this->imagen_principal = $row['imagen_principal'];
            $this->categoria_id = $row['categoria_id'];
            $this->autor_id = $row['autor_id'];
            $this->fecha_publicacion = $row['fecha_publicacion'];
            $this->tiempo_lectura = $row['tiempo_lectura'];
            $this->palabras_clave = $row['palabras_clave'];
            $this->destacado = $row['destacado'];
            $this->activo = $row['activo'];
            $this->visitas = $row['visitas'];
            $this->likes = $row['likes'];
            $this->categoria_nombre = $row['categoria_nombre'];
            $this->autor_nombre = $row['autor_nombre'];
            $this->categoria_color = $row['categoria_color'];
        }
    }

    public function approve() {
        $query = 'UPDATE ' . $this->table . ' SET activo = 1 WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function disapprove() {
        $query = 'UPDATE ' . $this->table . ' SET activo = 0 WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function create($data) {
        $query = 'INSERT INTO ' . $this->table . ' (titulo, slug, contenido, resumen, imagen_principal, categoria_id, autor_id, tiempo_lectura, palabras_clave, destacado, activo) VALUES (:titulo, :slug, :contenido, :resumen, :imagen_principal, :categoria_id, :autor_id, :tiempo_lectura, :palabras_clave, :destacado, :activo)';
        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($data['titulo']));
        $this->slug = htmlspecialchars(strip_tags($data['slug']));
        $this->contenido = $data['contenido'];
        $this->resumen = htmlspecialchars(strip_tags($data['resumen']));
        $this->imagen_principal = htmlspecialchars(strip_tags($data['imagen_principal']));
        $this->categoria_id = htmlspecialchars(strip_tags($data['categoria_id']));
        $this->autor_id = htmlspecialchars(strip_tags($data['autor_id']));
        $this->tiempo_lectura = htmlspecialchars(strip_tags($data['tiempo_lectura']));
        $this->palabras_clave = htmlspecialchars(strip_tags($data['palabras_clave']));
        $this->destacado = htmlspecialchars(strip_tags($data['destacado']));
        $this->activo = htmlspecialchars(strip_tags($data['activo']));

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':contenido', $this->contenido);
        $stmt->bindParam(':resumen', $this->resumen);
        $stmt->bindParam(':imagen_principal', $this->imagen_principal);
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':autor_id', $this->autor_id);
        $stmt->bindParam(':tiempo_lectura', $this->tiempo_lectura);
        $stmt->bindParam(':palabras_clave', $this->palabras_clave);
        $stmt->bindParam(':destacado', $this->destacado);
        $stmt->bindParam(':activo', $this->activo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET titulo = :titulo, slug = :slug, contenido = :contenido, resumen = :resumen, imagen_principal = :imagen_principal, categoria_id = :categoria_id, autor_id = :autor_id, tiempo_lectura = :tiempo_lectura, palabras_clave = :palabras_clave, destacado = :destacado, activo = :activo WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($id));
        $this->titulo = htmlspecialchars(strip_tags($data['titulo']));
        $this->slug = htmlspecialchars(strip_tags($data['slug']));
        $this->contenido = $data['contenido'];
        $this->resumen = htmlspecialchars(strip_tags($data['resumen']));
        if (!empty($data['imagen_principal'])) {
            $this->imagen_principal = htmlspecialchars(strip_tags($data['imagen_principal']));
        } else {
            // Mantener la imagen existente si no se sube una nueva
            $this->read_single();
            $this->imagen_principal = $this->imagen_principal;
        }
        $this->categoria_id = htmlspecialchars(strip_tags($data['categoria_id']));
        $this->autor_id = htmlspecialchars(strip_tags($data['autor_id']));
        $this->tiempo_lectura = htmlspecialchars(strip_tags($data['tiempo_lectura']));
        $this->palabras_clave = htmlspecialchars(strip_tags($data['palabras_clave']));
        $this->destacado = htmlspecialchars(strip_tags($data['destacado']));
        $this->activo = htmlspecialchars(strip_tags($data['activo']));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':contenido', $this->contenido);
        $stmt->bindParam(':resumen', $this->resumen);
        $stmt->bindParam(':imagen_principal', $this->imagen_principal);
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':autor_id', $this->autor_id);
        $stmt->bindParam(':tiempo_lectura', $this->tiempo_lectura);
        $stmt->bindParam(':palabras_clave', $this->palabras_clave);
        $stmt->bindParam(':destacado', $this->destacado);
        $stmt->bindParam(':activo', $this->activo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
