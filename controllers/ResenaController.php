<?php
class ResenaController extends Controller {

    private $reservaModel;
    private $resenaModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $database = new Database();
        $db = $database->connect();
        $this->reservaModel = new Reserva($db);
        $this->resenaModel = new Resena($db);

        if (!isset($_SESSION['user_id'])) {
            header('Location: /Inkatours/iniciosesion');
            exit();
        }
    }

    public function escribir($reserva_id) {
        $reserva = $this->reservaModel->getReservaCompletaById($reserva_id);

        if (!$reserva || $reserva['usuario_id'] != $_SESSION['user_id']) {
            die('Acceso no autorizado.');
        }
        if (!in_array($reserva['estado'], ['confirmada', 'pagada', 'completada'])) {
            die('No puede dejar una reseña para una reserva no confirmada.');
        }

        if ($this->resenaModel->hasBeenReviewed($_SESSION['user_id'], $reserva['elemento_id'], $reserva['tipo'])) {
            die('Ya ha dejado una reseña para esta reserva.');
        }

        $data = [
            'title' => 'Escribir Reseña',
            'active_page' => 'perfil',
            'reserva' => $reserva
        ];

        $this->view('resena/escribir', $data);
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('Acceso no autorizado.');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $this->resenaModel->usuario_id = $_SESSION['user_id'];
        $this->resenaModel->elemento_id = $_POST['elemento_id'];
        $this->resenaModel->tipo = $_POST['tipo'];
        $this->resenaModel->calificacion = $_POST['calificacion'];
        $this->resenaModel->titulo = $_POST['titulo'];
        $this->resenaModel->comentario = $_POST['comentario'];
        
        if ($this->resenaModel->create()) {
            $_SESSION['message'] = 'Reseña guardada con éxito. Será visible una vez aprobada.';
            header('Location: /Inkatours/perfil/reservas');
            exit();
        } else {
            die('Error al guardar la reseña.');
        }
    }
}
