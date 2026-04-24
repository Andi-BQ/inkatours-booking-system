<?php

class ContactoController extends Controller {
    private $contactoModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->contactoModel = new Contacto($db);
    }

    public function index() {
        $data = [
            'title' => 'Contacto - InkaTours',
            'active_page' => 'contacto',
            'nombre' => '',
            'email' => '',
            'telefono' => '',
            'asunto' => '',
            'mensaje' => '',
            'nombre_err' => '',
            'email_err' => '',
            'asunto_err' => '',
            'mensaje_err' => '',
            'success' => false
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data['nombre'] = trim($_POST['nombre']);
            $data['email'] = trim($_POST['email']);
            $data['telefono'] = trim($_POST['telefono']);
            $data['asunto'] = trim($_POST['asunto']);
            $data['mensaje'] = trim($_POST['mensaje']);

            if (empty($data['nombre'])) {
                $data['nombre_err'] = 'Por favor, ingrese su nombre.';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Por favor, ingrese su email.';
            }
            if (empty($data['asunto'])) {
                $data['asunto_err'] = 'Por favor, seleccione un asunto.';
            }
            if (empty($data['mensaje'])) {
                $data['mensaje_err'] = 'Por favor, escriba su mensaje.';
            }

            if (empty($data['nombre_err']) && empty($data['email_err']) && empty($data['asunto_err']) && empty($data['mensaje_err'])) {
                $this->contactoModel->nombre = $data['nombre'];
                $this->contactoModel->email = $data['email'];
                $this->contactoModel->telefono = $data['telefono'];
                $this->contactoModel->asunto = $data['asunto'];
                $this->contactoModel->mensaje = $data['mensaje'];

                if ($this->contactoModel->create()) {
                    $data['success'] = true;
                } else {
                    die('Algo salió mal.');
                }
            }
        }

        $this->view('contacto', $data);
    }
}