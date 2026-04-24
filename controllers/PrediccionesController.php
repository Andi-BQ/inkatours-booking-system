<?php

class PrediccionesController extends Controller {
    private $prediccionModel;
    private $destinoModel;
    private $actividadModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->prediccionModel = new Prediccion($db);
        $this->destinoModel = new Destino($db);
        $this->actividadModel = new Actividad($db);
    }

    public function index() {
        // Data for Alerts for the new view
        $alertas_tiempo_real = [
            ['nivel' => 'critical', 'titulo' => 'Alerta de Capacidad: Camino Inca', 'mensaje' => 'Permisos para el Camino Inca están al 100% de su capacidad para los próximos 15 días.', 'tiempo' => 'Hace 15 minutos'],
            ['nivel' => 'warning', 'titulo' => 'Afluencia Alta en Machu Picchu', 'mensaje' => 'Se espera que la afluencia supere el 90% entre las 10:00 y las 14:00.', 'tiempo' => 'Hace 1 hora'],
            ['nivel' => 'info', 'titulo' => 'Evento Cultural en Cusco', 'mensaje' => 'Festival Inti Raymi incrementará afluencia en zonas céntricas.', 'tiempo' => 'Hace 3 horas'],
        ];

        // Fetch real data for the map
        $locations = [];

        // Get destinations
        $destinos_result = $this->destinoModel->read();
        while($row = $destinos_result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            if (isset($lat) && isset($lng)) {
                $locations[] = [
                    'nombre' => $nombre,
                    'lat' => $lat,
                    'lng' => $lng,
                    'congestion' => rand(10, 100), // Dummy congestion
                    'tipo' => 'destino',
                    'pos_x' => rand(10, 90),
                    'pos_y' => rand(10, 90),
                ];
            }
        }

        // Get activities
        $actividades_result = $this->actividadModel->readWithLocation();
        while($row = $actividades_result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            if (isset($lat) && isset($lng)) {
                $locations[] = [
                    'nombre' => $nombre,
                    'lat' => $lat,
                    'lng' => $lng,
                    'congestion' => rand(10, 100), // Dummy congestion
                    'tipo' => 'actividad',
                    'pos_x' => rand(10, 90),
                    'pos_y' => rand(10, 90),
                ];
            }
        }
        
        if (empty($locations)) {
            // Fallback to dummy data if no real locations with coordinates are found
            $locations = [
                ['nombre' => 'Machu Picchu', 'lat' => -13.1631, 'lng' => -72.5450, 'congestion' => 92, 'tipo' => 'destino', 'pos_x' => 20, 'pos_y' => 30],
                ['nombre' => 'Montaña 7 Colores', 'lat' => -13.8713, 'lng' => -71.3033, 'congestion' => 75, 'tipo' => 'destino', 'pos_x' => 45, 'pos_y' => 60],
                ['nombre' => 'Valle Sagrado', 'lat' => -13.329, 'lng' => -72.079, 'congestion' => 55, 'tipo' => 'destino', 'pos_x' => 35, 'pos_y' => 45],
                ['nombre' => 'Laguna Humantay', 'lat' => -13.419, 'lng' => -72.571, 'congestion' => 65, 'tipo' => 'destino', 'pos_x' => 50, 'pos_y' => 70],
                ['nombre' => 'Salineras de Maras', 'lat' => -13.300, 'lng' => -72.152, 'congestion' => 40, 'tipo' => 'destino', 'pos_x' => 30, 'pos_y' => 55],
                ['nombre' => 'Taller de Tejidos (Actividad)', 'lat' => -13.415, 'lng' => -71.942, 'congestion' => 35, 'tipo' => 'actividad', 'pos_x' => 40, 'pos_y' => 50],
                ['nombre' => 'Rafting (Actividad)', 'lat' => -13.633, 'lng' => -72.48, 'congestion' => 50, 'tipo' => 'actividad', 'pos_x' => 60, 'pos_y' => 75],
            ];
        }

        // Calculate estadisticas based on the new real data
        $estadisticas = [
            'libre' => 0,
            'moderado' => 0,
            'ocupado' => 0,
            'congestionado' => 0,
        ];

        foreach ($locations as $location) {
            if ($location['congestion'] <= 30) {
                $estadisticas['libre']++;
            } elseif ($location['congestion'] <= 60) {
                $estadisticas['moderado']++;
            } elseif ($location['congestion'] <= 80) {
                $estadisticas['ocupado']++;
            } else {
                $estadisticas['congestionado']++;
            }
        }

        // Dummy data for weekly predictions
        $predicciones_semana = [];
        for ($i = 0; $i < 7; $i++) {
            $predicciones_semana[] = rand(40, 95); // Random prediction between 40% and 95%
        }

        $data = [
            'title' => 'InkaTours - Predicciones Inteligentes',
            'active_page' => 'predicciones', // Ensure this matches the menu
            'alertas_tiempo_real' => $alertas_tiempo_real,
            'estadisticas' => $estadisticas,
            'locations' => $locations, // Use the new combined array
            'predicciones_semana' => $predicciones_semana,
        ];
        
        $this->view('predicciones', $data);
    }
}