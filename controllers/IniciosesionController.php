<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once $_SERVER['DOCUMENT_ROOT'] . '/Inkatours/core/lib/PHPMailer/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Inkatours/core/lib/PHPMailer/PHPMailer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Inkatours/core/lib/PHPMailer/SMTP.php';

class IniciosesionController extends Controller {

    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new User($this->db);
    }

    public function index() {
        if ($this->isLoggedIn()) {
            header('Location: /Inkatours/');
            exit();
        }

        $data = [
            'title' => 'Iniciar Sesión - InkaTours',
            'active_page' => 'iniciosesion'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['register'])) {
                $this->register();
            } elseif (isset($_POST['login'])) {
                $this->login();
            }
        } else {
            $this->view('iniciosesion', $data);
        }
    }

    public function register() {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'nombre' => trim($_POST['nombre']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'nombre_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        // Validate data
        if (empty($data['nombre'])) {
            $data['nombre_err'] = 'Por favor, ingrese su nombre';
        }
        if (empty($data['email'])) {
            $data['email_err'] = 'Por favor, ingrese su email';
        } else {
            if ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'El email ya está registrado';
            }
        }
        if (empty($data['password'])) {
            $data['password_err'] = 'Por favor, ingrese su contraseña';
        } elseif (strlen($data['password']) < 6) {
            $data['password_err'] = 'La contraseña debe tener al menos 6 caracteres';
        }
        if (empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Por favor, confirme su contraseña';
        } else {
            if ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Las contraseñas no coinciden';
            }
        }

        // Make sure errors are empty
        if (empty($data['nombre_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
            
            $this->userModel->nombre = $data['nombre'];
            $this->userModel->email = $data['email'];
            $this->userModel->password = $data['password'];
            $this->userModel->rol = 'usuario'; // Default role
            $this->userModel->avatar = 'default.jpg';
            $this->userModel->telefono = '';
            $this->userModel->pais = '';
            $this->userModel->fecha_nacimiento = null;
            $this->userModel->idioma_preferido = 'es';
            $this->userModel->notificaciones = true;
            $this->userModel->verificado = false;
            $this->userModel->token_verificacion = bin2hex(random_bytes(50));


            if ($this->userModel->register()) {
                // Redirect to login
                header('Location: /Inkatours/iniciosesion?registro=exitoso');
            } else {
                die('Algo salió mal.');
            }
        } else {
            // Load view with errors
            $this->view('iniciosesion', $data);
        }
    }

    public function login() {
        // DO NOT Sanitize password, it needs to be raw for password_verify
        $data = [
            'email' => trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)),
            'password' => trim($_POST['password']),
            'email_err' => '',
            'password_err' => '',
        ];

        // Validate empty fields
        if (empty($data['email'])) {
            $data['email_err'] = 'Por favor, ingrese su email';
        }
        if (empty($data['password'])) {
            $data['password_err'] = 'Por favor, ingrese su contraseña';
        }

        // Check for user/email
        if(empty($data['email_err']) && empty($data['password_err'])){
            $this->userModel->email = $data['email'];
            $this->userModel->password = $data['password'];

            $loggedInUser = $this->userModel->login();

            if (is_array($loggedInUser)) {
                // Login success, $loggedInUser contains user data
                $this->createUserSession($this->userModel);
                $this->sendLoginEmail($this->userModel->email, $this->userModel->nombre);

                // Redirect based on user role or previous page
                if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'admin') {
                    header('Location: /Inkatours/admin/dashboard');
                    exit();
                }
                header('Location: /Inkatours/');
                exit();

            } else {
                // Login failed, check the error type
                if ($loggedInUser === 'EMAIL_NOT_FOUND') {
                    $data['email_err'] = 'No se encontró ninguna cuenta con este email.';
                } elseif ($loggedInUser === 'PASSWORD_INCORRECT') {
                    $data['password_err'] = 'Contraseña incorrecta.';
                }
                $this->view('iniciosesion', $data);
            }
        } else {
            // Load view with errors if fields were empty
            $this->view('iniciosesion', $data);
        }
    }

    public function createUserSession($user) {
        session_regenerate_id(true); // Previene Session Fixation
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->nombre;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_rol'] = $user->rol;
    }

    private function sendLoginEmail($toEmail, $toName) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                        //Send using SMTP
            $mail->Host       = SMTP_HOST;                          //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                               //Enable SMTP authentication
            $mail->Username   = SMTP_USER;                          //SMTP username
            $mail->Password   = SMTP_PASS;                          //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = SMTP_PORT;                          //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom(SMTP_USER, 'InkaTours');
            $mail->addAddress($toEmail, $toName);                   //Add a recipient

            //Content
            $mail->isHTML(true);                                    //Set email format to HTML
            $mail->Subject = 'Inicio de Sesion Exitoso en InkaTours';
            $mail->Body    = 'Hola <strong>' . $toName . '</strong>,<br><br>
                              Hemos detectado un inicio de sesión exitoso en tu cuenta de InkaTours.<br>
                              Si fuiste tú, puedes ignorar este mensaje. Si no fuiste tú, por favor, contacta con nosotros inmediatamente.<br><br>
                              Gracias,<br>El equipo de InkaTours';
            $mail->AltBody = 'Hola ' . $toName . ',\nHemos detectado un inicio de sesión exitoso en tu cuenta de InkaTours.\nSi fuiste tú, puedes ignorar este mensaje. Si no fuiste tú, por favor, contacta con nosotros inmediatamente.\n\nGracias,\nEl equipo de InkaTours';

            $mail->send();
        } catch (Exception $e) {
            // Log the error, but don't stop the user's login process
            error_log("Error al enviar email de inicio de sesión: {$mail->ErrorInfo}");
        }
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: /Inkatours/');
    }

    public function isLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}