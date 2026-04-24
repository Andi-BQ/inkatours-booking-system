<?php

class DestinosController extends Controller {
    private $destinoModel;
    private $resenaModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->destinoModel = new Destino($db);
        $this->resenaModel = new Resena($db);
    }

    public function index() {
        $result = $this->destinoModel->read();
        $destinos = $result->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Destinos - InkaTours',
            'active_page' => 'destinos',
            'destinos' => $destinos
        ];
        $this->view('destinos', $data);
    }

    public function show($id) {
        $this->destinoModel->id = $id;
        $this->destinoModel->read_single();

        // Fetch reviews
        $reviews_stmt = $this->resenaModel->getReviewsByElemento($id, 'destino');
        $reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => $this->destinoModel->nombre . ' - InkaTours',
            'active_page' => 'destinos',
            'destino' => $this->destinoModel,
            'reviews' => $reviews
        ];

        $this->view('destinos_show', $data);
    }
}