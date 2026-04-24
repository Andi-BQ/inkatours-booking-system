<?php

class ActividadesController extends Controller {
    private $actividadModel;
    private $resenaModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->actividadModel = new Actividad($db);
        $this->resenaModel = new Resena($db);
    }

    public function index() {
        $result = $this->actividadModel->read();
        $actividades = $result->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Actividades - InkaTours',
            'active_page' => 'actividades',
            'actividades' => $actividades
        ];
        $this->view('actividades', $data);
    }

    public function show($id) {
        $this->actividadModel->id = $id;
        $this->actividadModel->read_single();

        // Fetch reviews
        $reviews_stmt = $this->resenaModel->getReviewsByElemento($id, 'actividad');
        $reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => $this->actividadModel->nombre . ' - InkaTours',
            'active_page' => 'actividades',
            'actividad' => $this->actividadModel,
            'reviews' => $reviews
        ];

        $this->view('actividades_show', $data);
    }
}