<?php
class Destino {
    private $conn;
    private $table = 'destinos';

    public $id;
    public $nombre;
    public $slug;
    public $descripcion;
    public $descripcion_corta;
    public $imagen_principal;
    public $galeria;
    public $categoria_id;
    public $tipo;
    public $dificultad;
    public $distancia;
    public $ubicacion;
    public $altitud;
    public $clima;
    public $mejor_epoca;
    public $precio_base;
    public $duracion_horas;
    public $grupo_maximo;
    public $grupo_minimo;
    public $guia_requerido;
    public $sostenible;
    public $sello_verde;
    public $destacado;
    public $activo;
    public $rating_promedio;
    public $total_resenas;
    public $visitas;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }
public function read() {
    $query = 'SELECT d.id, d.nombre, d.slug, d.descripcion_corta, d.imagen_principal, d.precio_base, d.duracion_horas, d.distancia, d.dificultad, d.tipo, d.rating_promedio, d.total_resenas, d.destacado, d.activo, c.nombre as categoria_nombre, ST_X(d.ubicacion) as lng, ST_Y(d.ubicacion) as lat 
              FROM ' . $this->table . ' d
              LEFT JOIN categorias_destinos c ON d.categoria_id = c.id
              ORDER BY d.created_at DESC';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

public function read_featured() {
    $query = 'SELECT d.id, d.nombre, d.slug, d.descripcion_corta, d.imagen_principal, d.precio_base, d.duracion_horas, d.dificultad, d.rating_promedio, d.total_resenas, c.nombre as categoria_nombre 
              FROM ' . $this->table . ' d
              LEFT JOIN categorias_destinos c ON d.categoria_id = c.id
              WHERE d.destacado = 1
              ORDER BY d.created_at DESC
              LIMIT 6';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
    public function read_single() {
        $query = 'SELECT d.*, c.nombre as categoria_nombre, ST_X(d.ubicacion) as lng, ST_Y(d.ubicacion) as lat FROM ' . $this->table . ' d
                  LEFT JOIN categorias_destinos c ON d.categoria_id = c.id
                  WHERE d.id = ?
                  LIMIT 0,1';

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
            $this->galeria = $row['galeria'];
            $this->categoria_id = $row['categoria_id'];
            $this->tipo = $row['tipo'];
            $this->dificultad = $row['dificultad'];
            $this->distancia = $row['distancia'];
            $this->ubicacion = $row['ubicacion'];
            $this->lat = $row['lat'];
            $this->lng = $row['lng'];
            $this->altitud = $row['altitud'];
            $this->clima = $row['clima'];
            $this->mejor_epoca = $row['mejor_epoca'];
            $this->precio_base = $row['precio_base'];
            $this->duracion_horas = $row['duracion_horas'];
            $this->grupo_maximo = $row['grupo_maximo'];
            $this->grupo_minimo = $row['grupo_minimo'];
            $this->guia_requerido = $row['guia_requerido'];
            $this->sostenible = $row['sostenible'];
            $this->sello_verde = $row['sello_verde'];
            $this->destacado = $row['destacado'];
            $this->activo = $row['activo'];
            $this->rating_promedio = $row['rating_promedio'];
            $this->total_resenas = $row['total_resenas'];
            $this->visitas = $row['visitas'];
            $this->categoria_nombre = $row['categoria_nombre'];
        }
    }

    public function count_featured() {
        $query = 'SELECT COUNT(id) as count FROM ' . $this->table . ' WHERE destacado = 1';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] ?? 0;
    }

    public function create($data) {
        $query = 'INSERT INTO ' . $this->table . ' SET 
                    nombre = :nombre,
                    slug = :slug,
                    descripcion = :descripcion,
                    descripcion_corta = :descripcion_corta,
                    imagen_principal = :imagen_principal,
                    categoria_id = :categoria_id,
                    tipo = :tipo,
                    dificultad = :dificultad,
                    precio_base = :precio_base,
                    duracion_horas = :duracion_horas,
                    ubicacion = ST_PointFromText(:wkt, 4326)
                  ';

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $nombre = htmlspecialchars(strip_tags($data['nombre']));
        $slug = htmlspecialchars(strip_tags($data['slug']));
        $descripcion = htmlspecialchars(strip_tags($data['descripcion']));
        $descripcion_corta = htmlspecialchars(strip_tags($data['descripcion_corta']));
        $imagen_principal = htmlspecialchars(strip_tags($data['imagen_principal']));
        $categoria_id = htmlspecialchars(strip_tags($data['categoria_id']));
        $tipo = htmlspecialchars(strip_tags($data['tipo']));
        $dificultad = htmlspecialchars(strip_tags($data['dificultad']));
        $precio_base = htmlspecialchars(strip_tags($data['precio_base']));
        $duracion_horas = htmlspecialchars(strip_tags($data['duracion_horas']));
        $wkt = 'POINT(' . $data['longitud'] . ' ' . $data['latitud'] . ')';

        // Bind data
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':descripcion_corta', $descripcion_corta);
        $stmt->bindParam(':imagen_principal', $imagen_principal);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':dificultad', $dificultad);
        $stmt->bindParam(':precio_base', $precio_base);
        $stmt->bindParam(':duracion_horas', $duracion_horas);
        $stmt->bindParam(':wkt', $wkt);

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

    public function toggleDestacado($id, $status) {
        $query = 'UPDATE ' . $this->table . ' SET destacado = :status WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $status = htmlspecialchars(strip_tags($status));

        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function search($query) {
        $search_query = $query . '%'; // Search for names that start with the query
        $sql = 'SELECT id, nombre, slug, imagen_principal, descripcion_corta, precio_base, "destino" as tipo FROM ' . $this->table . '
                WHERE nombre LIKE :query';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':query', $search_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}