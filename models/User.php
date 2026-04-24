<?php

class User {
    private $conn;
    private $table = 'usuarios';

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $avatar;
    public $telefono;
    public $pais;
    public $fecha_nacimiento;
    public $idioma_preferido;
    public $notificaciones;
    public $rol;
    public $verificado;
    public $token_verificacion;
    public $fecha_verificacion;
    public $ultimo_login;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = 'INSERT INTO ' . $this->table . ' 
            SET
                nombre = :nombre,
                email = :email,
                password = :password,
                avatar = :avatar,
                telefono = :telefono,
                pais = :pais,
                fecha_nacimiento = :fecha_nacimiento,
                idioma_preferido = :idioma_preferido,
                notificaciones = :notificaciones,
                rol = :rol,
                verificado = :verificado,
                token_verificacion = :token_verificacion';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->avatar = htmlspecialchars(strip_tags($this->avatar));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->pais = htmlspecialchars(strip_tags($this->pais));
        $this->fecha_nacimiento = htmlspecialchars(strip_tags($this->fecha_nacimiento));
        $this->idioma_preferido = htmlspecialchars(strip_tags($this->idioma_preferido));
        $this->notificaciones = htmlspecialchars(strip_tags($this->notificaciones));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->verificado = htmlspecialchars(strip_tags($this->verificado));
        $this->token_verificacion = htmlspecialchars(strip_tags($this->token_verificacion));

        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind data
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':avatar', $this->avatar);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':pais', $this->pais);
        $stmt->bindParam(':fecha_nacimiento', $this->fecha_nacimiento);
        $stmt->bindParam(':idioma_preferido', $this->idioma_preferido);
        $stmt->bindParam(':notificaciones', $this->notificaciones);
        $stmt->bindParam(':rol', $this->rol);
        $stmt->bindParam(':verificado', $this->verificado);
        $stmt->bindParam(':token_verificacion', $this->token_verificacion);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function loginAdmin($email, $password) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email AND rol = "admin" LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $num = $stmt->rowCount();

        if($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $stored_password = $row['password'];

            if(password_verify($password, $stored_password)) {
                // Update last login time
                $this->id = $row['id'];
                $this->updateLastLogin();
                
                // Return user data
                return $row;
            }
        }

        return false;
    }

    public function login() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if($stmt->rowCount() == 0) {
            return 'EMAIL_NOT_FOUND';
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stored_password = $row['password'];

        if(password_verify($this->password, $stored_password)) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->email = $row['email'];
            $this->rol = $row['rol'];
            $this->updateLastLogin();
            return $row; // Return user data on success
        } else {
            return 'PASSWORD_INCORRECT';
        }
    }
        
            public function read_single() {
                $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';
        
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
        
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if($row) {
                    $this->nombre = $row['nombre'];
                    $this->email = $row['email'];
                    $this->avatar = $row['avatar'];
                    $this->telefono = $row['telefono'];
                    $this->pais = $row['pais'];
                    $this->fecha_nacimiento = $row['fecha_nacimiento'];
                    $this->idioma_preferido = $row['idioma_preferido'];
                    $this->notificaciones = $row['notificaciones'];
                    $this->rol = $row['rol'];
                    $this->verificado = $row['verificado'];
                    $this->ultimo_login = $row['ultimo_login'];
                    $this->created_at = $row['created_at'];
                }
            }
        
            public function findUserByEmail($email) {        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function getUserById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function updateUser() {
        $query = 'UPDATE ' . $this->table . '
            SET
                nombre = :nombre,
                telefono = :telefono,
                pais = :pais
            WHERE
                id = :id';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->pais = htmlspecialchars(strip_tags($this->pais));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':pais', $this->pais);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updatePassword() {
        $query = 'UPDATE ' . $this->table . '
            SET
                password = :password
            WHERE
                id = :id';

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':password', $hashed_password);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    private function updateLastLogin() {
        $query = 'UPDATE ' . $this->table . ' SET ultimo_login = NOW() WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }
}