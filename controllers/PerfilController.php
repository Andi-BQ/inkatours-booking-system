<?php

class PerfilController extends Controller {

    private $userModel;
    private $reservaModel;
    private $resenaModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->userModel = new User($db);
        $this->reservaModel = new Reserva($db);
        $this->resenaModel = new Resena($db);
    }

    public function index($subpage = 'resumen') {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Inkatours/iniciosesion');
            exit();
        }

        // Get user data from the model
        $this->userModel->id = $_SESSION['user_id'];
        $this->userModel->read_single(); // Assuming a method to read user by ID exists

        $data = [
            'title' => 'Mi Perfil - InkaTours',
            'active_page' => 'perfil',
            'user' => $this->userModel,
            'subpage' => $subpage
        ];

        // If on the reservations subpage, fetch the reservations
        if ($subpage == 'reservas') {
            $reservas_stmt = $this->reservaModel->readByUserId($_SESSION['user_id']);
            $reservas = $reservas_stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if each reservation has been reviewed
            foreach ($reservas as $key => $reserva) {
                if (isset($reserva['elemento_id'])) {
                    $reservas[$key]['has_reviewed'] = $this->resenaModel->hasBeenReviewed($_SESSION['user_id'], $reserva['elemento_id'], $reserva['tipo']);
                } else {
                    $reservas[$key]['has_reviewed'] = false;
                }
            }
            $data['reservas'] = $reservas;
        }

        $this->view('perfil', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Acceso no autorizado.']);
            exit();
        }
    
        $response = ['status' => 'error', 'message' => 'No se realizaron cambios.'];
        $this->userModel->id = $_SESSION['user_id'];
    
        // Sanitize POST data
        $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
        $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING));
        $pais = trim(filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING));
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
    
        $this->userModel->nombre = $nombre;
        $this->userModel->telefono = $telefono;
        $this->userModel->pais = $pais;
    
        $profileUpdated = false;
        if ($this->userModel->updateUser()) {
            $profileUpdated = true;
            $response = ['status' => 'success', 'message' => 'Perfil actualizado correctamente.'];
        } else {
            $response['message'] = 'Hubo un error al actualizar tu perfil.';
        }
    
        $passwordUpdated = false;
        if (!empty($password)) {
            if ($password !== $password_confirm) {
                $response = ['status' => 'error', 'message' => 'Las contraseñas no coinciden.'];
            } else {
                $this->userModel->password = $password;
                if ($this->userModel->updatePassword()) {
                    $passwordUpdated = true;
                    $response['message'] = 'Perfil y contraseña actualizados correctamente.';
                } else {
                    $response['message'] = 'Hubo un error al actualizar tu contraseña.';
                }
            }
        }
    
        if ($profileUpdated || $passwordUpdated) {
            $this->userModel->read_single();
            $response['user'] = [
                'nombre' => $this->userModel->nombre,
                'email' => $this->userModel->email,
                'telefono' => $this->userModel->telefono,
                'pais' => $this->userModel->pais
            ];
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
