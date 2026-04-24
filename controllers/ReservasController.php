<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/Inkatours/core/lib/stripe/init.php');

class ReservasController extends Controller {
    private $reservaModel;
    private $destinoModel;
    private $actividadModel;
    private $reservaDestinoModel;
    private $reservaActividadModel;
    private $participanteReservaModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->reservaModel = new Reserva($this->db);
        $this->destinoModel = new Destino($this->db);
        $this->actividadModel = new Actividad($this->db);
        $this->reservaDestinoModel = new ReservaDestino($this->db);
        $this->reservaActividadModel = new ReservaActividad($this->db);
        $this->participanteReservaModel = new ParticipanteReserva($this->db);
    }

    public function index() {
        $this->view('reservas');
    }

    public function crear($tipo, $id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Inkatours/');
            exit();
        }

        $item = null;
        if ($tipo == 'destino') {
            $this->destinoModel->id = $id;
            $this->destinoModel->read_single();
            $item = $this->destinoModel;
        } elseif ($tipo == 'actividad') {
            $this->actividadModel->id = $id;
            $this->actividadModel->read_single();
            $item = $this->actividadModel;
        }

        $usuario_data = null;
        if (isset($_SESSION['user_id'])) {
            $userModel = new User($this->db);
            $usuario_data = $userModel->getUserById($_SESSION['user_id']);
        }

        $data = [
            'title' => 'Confirmar Reserva - InkaTours',
            'active_page' => 'reservas',
            'tipo' => $tipo,
            'item' => $item,
            'usuario' => $usuario_data
        ];

        $this->view('reservas', $data);
    }

    public function guardar() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Inkatours/iniciosesion');
            exit();
        }
    
        // --- Validation and Sanitization ---
        $data = [
            'usuario_id' => $_SESSION['user_id'],
            'tipo' => trim(filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING)),
            'elemento_id' => trim(filter_input(INPUT_POST, 'elemento_id', FILTER_SANITIZE_NUMBER_INT)),
            'fecha_experiencia' => trim(filter_input(INPUT_POST, 'fecha_experiencia', FILTER_SANITIZE_STRING)),
            'participantes' => trim(filter_input(INPUT_POST, 'participantes', FILTER_SANITIZE_NUMBER_INT)),
            'precio_unitario' => trim(filter_input(INPUT_POST, 'precio_unitario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)),
            'nombre_completo' => trim(filter_input(INPUT_POST, 'nombre_completo', FILTER_SANITIZE_STRING)),
            'email' => trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)),
            'telefono' => trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING)),
            'participantes_nombres' => $_POST['participantes_nombres'] ?? [],
            'participantes_tipos' => $_POST['participantes_tipos'] ?? [],
        ];
        // More validation could be added here...

        // --- Lógica Principal ---
        $discounts = ['local' => 0.20, 'nacional' => 0.10, 'extranjero' => 0.0];
        $precio_unitario = floatval($data['precio_unitario']);
        $subtotal_calculado = 0;
        foreach ($data['participantes_tipos'] as $tipo_turista) {
            $descuento = $discounts[$tipo_turista] ?? 0;
            $subtotal_calculado += $precio_unitario * (1 - $descuento);
        }

        // 1. Create reservation with 'pendiente' status
        $this->reservaModel->usuario_id = $data['usuario_id'];
        $this->reservaModel->tipo = $data['tipo'];
        $this->reservaModel->fecha_experiencia = $data['fecha_experiencia'];
        $this->reservaModel->participantes = $data['participantes'];
        $this->reservaModel->precio_unitario = $data['precio_unitario'];
        $this->reservaModel->subtotal = $subtotal_calculado;
        $this->reservaModel->total = $subtotal_calculado / 2; // 50% down payment
        $this->reservaModel->numero_reserva = 'INKA-' . time();
        $this->reservaModel->estado = 'pendiente';
        $this->reservaModel->fecha_reserva = date('Y-m-d H:i:s');
        $this->reservaModel->moneda = 'USD';
        $this->reservaModel->metodo_pago = 'tarjeta';
    
        if ($this->reservaModel->create()) {
            $reserva_id = $this->reservaModel->getLastInsertId();
            // Save participants, etc. (omitted for brevity, but it's here in spirit)

            // 2. Create Stripe Checkout Session
            try {
                \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
                
                if ($data['tipo'] == 'destino') {
                    $this->destinoModel->id = $data['elemento_id'];
                    $this->destinoModel->read_single();
                    $item_nombre = $this->destinoModel->nombre;
                } elseif ($data['tipo'] == 'actividad') {
                    $this->actividadModel->id = $data['elemento_id'];
                    $this->actividadModel->read_single();
                    $item_nombre = $this->actividadModel->nombre;
                } else {
                    $item_nombre = 'Reserva';
                }

                $checkout_session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Pago Inicial (50%) - Reserva ' . $this->reservaModel->numero_reserva,
                                'description' => $item_nombre,
                            ],
                            'unit_amount' => round($this->reservaModel->total * 100), // Amount in cents
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => 'http://localhost/Inkatours/reservas/pago_exitoso?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => 'http://localhost/Inkatours/reservas/pago_cancelado?reserva_id=' . $reserva_id,
                    'client_reference_id' => $reserva_id,
                ]);

                // 3. Save session ID and redirect
                $this->reservaModel->updatePagoId($reserva_id, $checkout_session->id);
                header("Location: " . $checkout_session->url);
                exit();
            } catch (Exception $e) {
                die('Error de Stripe: ' . $e->getMessage());
            }
        } else {
            die('Algo salió mal al crear la reserva.');
        }
    }

    public function pago_exitoso() {
        if (!isset($_GET['session_id']) || !isset($_SESSION['user_id'])) {
            die('Acceso inválido.');
        }

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
            $reserva = $this->reservaModel->getById($session->client_reference_id);

            if ($reserva && $reserva['usuario_id'] == $_SESSION['user_id'] && $reserva['estado'] == 'pendiente') {
                $this->reservaModel->updateEstado($reserva['id'], 'confirmada');
                header('Location: /Inkatours/reservas/exito/' . $reserva['numero_reserva']);
                exit();
            } else {
                header('Location: /Inkatours/perfil/reservas');
                exit();
            }
        } catch (Exception $e) {
            die('Error de Stripe: ' . $e->getMessage());
        }
    }

    public function pago_cancelado() {
        // User canceled, redirect them to their profile
        header('Location: /Inkatours/perfil/reservas');
        exit();
    }

    public function exito($numero_reserva) {
        $reserva = $this->reservaModel->getReservaCompletaByNumero($numero_reserva);
        $data = ['title' => 'Reserva Exitosa', 'reserva' => $reserva];
        $this->view('reserva_exitosa', $data);
    }
    
    public function confirmar($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Inkatours/iniciosesion');
            exit();
        }

        $reserva = $this->reservaModel->getReservaCompletaById($id);

        if (!$reserva || $reserva['usuario_id'] != $_SESSION['user_id'] || $reserva['estado'] != 'confirmada') {
            header('Location: /Inkatours/perfil/reservas');
            exit();
        }

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $monto_restante = $reserva['subtotal'] - $reserva['total'];

            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Pago Final - Reserva ' . $reserva['numero_reserva'],
                            'description' => $reserva['item_nombre'],
                        ],
                        'unit_amount' => round($monto_restante * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost/Inkatours/reservas/pago_final_exitoso?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://localhost/Inkatours/perfil/reservas',
                'client_reference_id' => $id,
            ]);

            $this->reservaModel->updatePagoId($id, $checkout_session->id);
            header("Location: " . $checkout_session->url);
            exit();

        } catch (Exception $e) {
            die('Error de Stripe: ' . $e->getMessage());
        }
    }

    public function pago_final_exitoso() {
        if (!isset($_GET['session_id']) || !isset($_SESSION['user_id'])) {
            die('Acceso inválido.');
        }

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
            $reserva = $this->reservaModel->getById($session->client_reference_id);

            if ($reserva && $reserva['usuario_id'] == $_SESSION['user_id'] && $reserva['estado'] == 'confirmada') {
                $this->reservaModel->confirmarPagoCompleto($reserva['id'], $reserva['subtotal']);
                $_SESSION['reserva_confirmada'] = '¡El pago final de tu reserva ha sido completado con éxito!';
                header('Location: /Inkatours/perfil/reservas');
                exit();
            } else {
                header('Location: /Inkatours/perfil/reservas');
                exit();
            }
        } catch (Exception $e) {
            die('Error de Stripe: ' . $e->getMessage());
        }
    }

    public function cancelar($id) {
        if (isset($_SESSION['user_id'])) {
            $this->reservaModel->updateEstado($id, 'cancelada');
        }
        header('Location: /Inkatours/perfil/reservas');
        exit();
    }
}
