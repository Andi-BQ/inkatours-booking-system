<?php

class ApiController extends Controller {

    private $db;
    private $destinoModel;
    private $actividadModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->destinoModel = new Destino($this->db);
        $this->actividadModel = new Actividad($this->db);
    }

    public function search() {
        $query = $_GET['q'] ?? '';
        
        $destinos = [];
        $actividades = [];

        if (!empty($query)) {
            $destinos = $this->destinoModel->search($query);
            $actividades = $this->actividadModel->search($query);
        }

        $results = [
            'destinos' => $destinos,
            'actividades' => $actividades
        ];

        header('Content-Type: application/json');
        echo json_encode($results);
    }
}
