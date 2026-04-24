<?php

class MapaController extends Controller {
    private $destinoModel;
    private $actividadModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->destinoModel = new Destino($db);
        $this->actividadModel = new Actividad($db); // Añadir el modelo de Actividad
    }

    public function index() {
        // Cargar destinos
        $result_destinos = $this->destinoModel->read();
        $destinos = $result_destinos->fetchAll(PDO::FETCH_ASSOC);

        // Cargar actividades con ubicación
        $result_actividades = $this->actividadModel->readWithLocation();
        $actividades = $result_actividades->fetchAll(PDO::FETCH_ASSOC);

        $locations = [];

        // Procesar destinos
        foreach ($destinos as $destino) {
            $locations[] = [
                'lat' => (float)$destino['lat'],
                'lng' => (float)$destino['lng'],
                'nombre' => $destino['nombre'],
                'descripcion_corta' => $destino['descripcion_corta'],
                'imagen_principal' => $destino['imagen_principal'],
                'id' => $destino['id'],
                'tipo' => 'destino' // Añadir tipo
            ];
        }

        // Procesar actividades
        foreach ($actividades as $actividad) {
            $locations[] = [
                'lat' => (float)$actividad['lat'],
                'lng' => (float)$actividad['lng'],
                'nombre' => $actividad['nombre'],
                'descripcion_corta' => $actividad['descripcion'],
                'imagen_principal' => $actividad['imagen_url'],
                'id' => $actividad['id'],
                'tipo' => 'actividad' // Añadir tipo
            ];
        }

        $data = [
            'title' => 'Mapa Interactivo - InkaTours',
            'active_page' => 'mapa',
            'locations' => json_encode($locations)
        ];
        $this->view('mapa', $data);
    }
}