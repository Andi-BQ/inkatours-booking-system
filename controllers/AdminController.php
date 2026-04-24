<?php

class AdminController extends Controller {

    private $db;
    private $userModel;
    private $resenaModel;
    private $destinoModel;
    private $actividadModel;
    private $blogModel;
    private $configModel;
    private $dashboardModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new User($this->db);
        $this->resenaModel = new Resena($this->db);
        $this->destinoModel = new Destino($this->db);
        $this->actividadModel = new Actividad($this->db);
        $this->blogModel = new Blog($this->db);
        $this->configModel = new Config($this->db);
        $this->dashboardModel = new DashboardModel($this->db);
    }

    // Admin dashboard - lists reviews for moderation
    public function dashboard() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $reviews = $this->resenaModel->getAllReviews();

        $data = [
            'title' => 'Admin Dashboard - InkaTours',
            'reviews' => $reviews,
            'active_page' => 'dashboard'
        ];

        $this->view('admin/dashboard', $data);
    }
    
    //=============== DESTINOS ===============//

    public function destinos() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $stmt = $this->destinoModel->read();
        $destinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Gestión de Destinos - InkaTours',
            'destinos' => $destinos,
            'active_page' => 'destinos'
        ];

        $this->view('admin/destinos', $data);
    }
    
    public function destino_form() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $data = [
            'title' => 'Formulario de Destino - InkaTours',
            'active_page' => 'destinos'
        ];

        $this->view('admin/destino_form', $data);
    }

    public function create_destino() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/destinos');

        $upload_dir = 'static/img/destinos/';
        $new_filename = '';

        // Handle file upload
        if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] == 0) {
            $file = $_FILES['imagen_principal'];

            // 1. Validate MIME Types
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file['tmp_name']);
            $allowed_types = [
                'image/jpeg' => '.jpg',
                'image/png'  => '.png',
                'image/webp' => '.webp'
            ];

            if (!isset($allowed_types[$mime_type])) $this->redirect('/admin/destino_form?error=InvalidFileType');

            // 2. Validate file size (max 2MB)
            if ($file['size'] > 2 * 1024 * 1024) $this->redirect('/admin/destino_form?error=FileSizeTooLarge');
            
            // 3. Generate unique name (cryptographically secure)
            $extension = $allowed_types[$mime_type];
            $new_filename = 'destino_' . bin2hex(random_bytes(16)) . $extension;
            $target_path = $upload_dir . $new_filename;

            if (!move_uploaded_file($file['tmp_name'], $target_path)) $this->redirect('/admin/destino_form?error=UploadFailed');
        } else {
            $this->redirect('/admin/destino_form?error=NoFileUploaded');
        }

        // 4. Secure Allowlist mapping
        $safeData = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'descripcion_corta' => trim($_POST['descripcion_corta'] ?? ''),
            'precio_base' => floatval($_POST['precio_base'] ?? 0),
            'duracion_horas' => intval($_POST['duracion_horas'] ?? 0),
            'distancia' => floatval($_POST['distancia'] ?? 0),
            'dificultad' => $_POST['dificultad'] ?? 'moderada',
            'tipo' => $_POST['tipo'] ?? 'aventura',
            'categoria_id' => intval($_POST['categoria_id'] ?? 1),
            'latitud' => floatval($_POST['latitud'] ?? 0),
            'longitud' => floatval($_POST['longitud'] ?? 0),
            'imagen_principal' => $new_filename,
            'destacado' => isset($_POST['destacado']) ? 1 : 0
        ];

        if ($this->destinoModel->create($safeData)) {
            $this->redirect('/admin/destinos');
        } else {
            // Optional: Delete uploaded file if DB insertion fails
            if (file_exists($target_path)) {
                unlink($target_path);
            }
            $this->redirect('/admin/destino_form?error=DBCreateFailed');
        }
    }
    
    //=============== ACTIVIDADES ===============//

    public function actividades() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $stmt = $this->actividadModel->read();
        $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Gestión de Actividades - InkaTours',
            'actividades' => $actividades,
            'active_page' => 'actividades'
        ];

        $this->view('admin/actividades', $data);
    }

    public function actividad_form() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $data = [
            'title' => 'Formulario de Actividad - InkaTours',
            'active_page' => 'actividades'
        ];

        $this->view('admin/actividad_form', $data);
    }

    public function create_actividad() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/actividades');

        if ($this->actividadModel->create($_POST)) {
            $this->redirect('/admin/actividades');
        } else {
            $this->redirect('/admin/actividad_form?error=1');
        }
    }

    //=============== BLOG ===============//

    public function blog() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $stmt = $this->blogModel->read();
        $articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Gestión de Blog - InkaTours',
            'articulos' => $articulos,
            'active_page' => 'blog'
        ];

        $this->view('admin/blog', $data);
    }

    public function blog_approve($id) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $this->blogModel->id = $id;
        if ($this->blogModel->approve()) {
            // Success
        }
        $this->redirect('/admin/blog');
    }

    public function blog_disapprove($id) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $this->blogModel->id = $id;
        if ($this->blogModel->disapprove()) {
            // Success
        }
        $this->redirect('/admin/blog');
    }

    public function blog_delete($id) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $this->blogModel->id = $id;
        if ($this->blogModel->delete()) {
            // Success
        }
        $this->redirect('/admin/blog');
    }

    public function blog_form() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $data = [
            'title' => 'Formulario de Artículo - InkaTours',
            'active_page' => 'blog'
        ];

        $this->view('admin/blog_form', $data);
    }

    public function create_blog() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/blog');

        $upload_dir = 'static/img/blog/';
        $new_filename = '';

        if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] == 0) {
            $file = $_FILES['imagen_principal'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file['tmp_name']);

            if ($mime_type === 'image/png') {
                if ($file['size'] <= 2 * 1024 * 1024) {
                    $new_filename = 'blog_' . time() . '.png';
                    $target_path = $upload_dir . $new_filename;

                    if (move_uploaded_file($file['tmp_name'], $target_path)) {
                        $data = $_POST;
                        $data['imagen_principal'] = $new_filename;

                        if ($this->blogModel->create($data)) {
                            $this->redirect('/admin/blog');
                        } else {
                            if (file_exists($target_path)) {
                                unlink($target_path);
                            }
                            $this->redirect('/admin/blog_form?error=DBCreateFailed');
                        }
                    } else {
                        $this->redirect('/admin/blog_form?error=UploadFailed');
                    }
                } else {
                    $this->redirect('/admin/blog_form?error=FileSizeTooLarge');
                }
            } else {
                $this->redirect('/admin/blog_form?error=InvalidFileType');
            }
        } else {
            $data = $_POST;
            $data['imagen_principal'] = 'default.png'; // Asignar imagen por defecto

            if ($this->blogModel->create($data)) {
                $this->redirect('/admin/blog');
            } else {
                $this->redirect('/admin/blog_form?error=DBCreateFailed');
            }
        }
    }

    public function blog_edit($id = null) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        if (!$id) $this->redirect('/admin/blog');

        $this->blogModel->id = $id;
        $this->blogModel->read_single();

        $data = [
            'title' => 'Editar Artículo',
            'articulo' => (array)$this->blogModel,
            'active_page' => 'blog'
        ];
        $this->view('admin/blog_form', $data);
    }

    public function blog_guardar() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/blog');

        $id = $_POST['id'];
        $datos = $_POST;

        if (isset($_FILES['imagen_principal']) && $_FILES['imagen_principal']['error'] == 0) {
            $upload_dir = 'static/img/blog/';
            $file = $_FILES['imagen_principal'];
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file['tmp_name']);

            if ($mime_type === 'image/png' && $file['size'] <= 2 * 1024 * 1024) {
                $new_filename = 'blog_' . time() . '.png';
                $target_path = $upload_dir . $new_filename;

                if (move_uploaded_file($file['tmp_name'], $target_path)) {
                    $datos['imagen_principal'] = $new_filename;
                }
            }
        }

        $this->blogModel->update($id, $datos);
        $this->redirect('/admin/blog');
    }



    //=============== RESEÑAS ===============//

    public function approve($id) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        if ($this->resenaModel->approve($id)) {
            // Success
        }
        $this->redirect('/admin/dashboard');
    }

    public function reject($id) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        if ($this->resenaModel->reject($id)) {
            // Success
        }
        $this->redirect('/admin/dashboard');
    }

    public function disapprove_review($id) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        if ($this->resenaModel->disapprove($id)) {
            // Success
        }
        $this->redirect('/admin/dashboard');
    }

    //=============== GENERAL ===============//

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        $this->redirect('/');
    }
    
    // --- Gestión de Destinos (Versión Corregida Final) ---

    public function destino_editar($id = null) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        if (!$id) $this->redirect('/admin/destinos');

        $this->destinoModel->id = $id;
        $this->destinoModel->read_single(); // Carga los datos en el objeto

        $data = [ 
            'title' => 'Editar Destino', 
            'destino' => (array)$this->destinoModel, // Convertimos el objeto a array para la vista
            'active_page' => 'destinos' 
        ];
        $this->view('admin/destino_form', $data);
    }

    public function destino_guardar() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/destinos');
        
        $id = $_POST['id'];
        $datos = [ 'nombre' => $_POST['nombre'], 'descripcion' => $_POST['descripcion'] ];

        $this->destinoModel->update($id, $datos);
        $this->redirect('/admin/destinos');
    }

    public function destino_eliminar($id = null) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        if ($id) {
            $this->destinoModel->delete($id);
        }
        $this->redirect('/admin/destinos');
    }

    public function destino_destacar($id = null) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        
        if ($id) {
            $count = $this->destinoModel->count_featured();
            if ($count >= 6) {
                $this->redirect('/admin/destinos?error=max_featured');
            }
            $this->destinoModel->toggleDestacado($id, 1);
        }
        $this->redirect('/admin/destinos');
    }

    public function destino_no_destacar($id = null) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        if ($id) {
            $this->destinoModel->toggleDestacado($id, 0);
        }
        $this->redirect('/admin/destinos');
    }

    // --- Gestión de Actividades (Versión Corregida Final) ---

    public function actividad_editar($id = null) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        if (!$id) $this->redirect('/admin/actividades');

        // Asumiendo que Actividad.php tiene la misma estructura que Destino.php
        $this->actividadModel->id = $id;
        $this->actividadModel->read_single();

        $data = [ 
            'title' => 'Editar Actividad', 
            'actividad' => (array)$this->actividadModel, 
            'active_page' => 'actividades' 
        ];
        $this->view('admin/actividad_form', $data);
    }

    public function actividad_guardar() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/actividades');

        $id = $_POST['id'];
        $datos = [ 'nombre' => $_POST['nombre'], 'descripcion' => $_POST['descripcion'] ];
        
        // Asumiendo que Actividad.php también tendrá un método update
        $this->actividadModel->update($id, $datos);
        $this->redirect('/admin/actividades');
    }

    public function actividad_eliminar($id = null) {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        if ($id) {
            // Asumiendo que Actividad.php también tendrá un método delete
            $this->actividadModel->delete($id);
        }
        $this->redirect('/admin/actividades');
    }

    //=============== CONFIGURACIÓN ===============//

    public function configuracion() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        $configs = $this->configModel->get_all();

        $data = [
            'title' => 'Configuración de la Empresa - InkaTours',
            'config' => $configs,
            'active_page' => 'configuracion'
        ];

        $this->view('admin/configuracion_form', $data);
    }

    public function guardar_configuracion() {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/admin/configuracion');

        $settings = $_POST;
        foreach ($settings as $key => $value) {
            $this->configModel->update_setting($key, $value);
        }

        $this->redirect('/admin/configuracion?success=1');
    }

    //=============== DASHBOARD DE AFLUENCIA ===============//

    public function afluencia() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');

        // 1. Afluencia Actual por Reservas
        $afluencia_actual = $this->dashboardModel->getAfluenciaActual();

        // 2. Predicción de Afluencia
        $predicciones = $this->dashboardModel->getPrediccionesRecientes();

        // 3. Datos para el Mapa
        $map_data = $this->dashboardModel->getDestinosConAfluenciaActual();

        $data = [
            'title' => 'Dashboard de Afluencia Turística - InkaTours',
            'active_page' => 'afluencia',
            'afluencia_actual' => $afluencia_actual,
            'predicciones' => $predicciones,
            'map_data_json' => json_encode($map_data)
        ];

        $this->view('admin/dashboard_afluencia', $data);
    }

    public function predicciones() {
        if (!$this->isAdmin()) $this->redirect('/iniciosesion');
        
        // This data structure is a placeholder for the complex backend logic
        // that would be needed to generate these analytics in a real application.
        $data = [
            'title' => 'Dashboard de Inteligencia Turística - InkaTours',
            'active_page' => 'predicciones',
            'kpis' => [
                'total_visitantes' => 1250,
                'tendencia_visitantes' => 5,
                'sitios_criticos' => 2,
                'capacidad_disponible' => 65,
                'indice_sostenibilidad' => 8.2
            ],
            'destinos' => [
                ['nombre' => 'Machu Picchu', 'afluencia' => 92, 'capacidad' => 2500, 'recomendacion' => 'Visitar en horarios de baja afluencia.', 'nivel_clase' => 'critical'],
                ['nombre' => 'Montaña 7 Colores', 'afluencia' => 75, 'capacidad' => 500, 'recomendacion' => 'Se recomienda buena aclimatación.', 'nivel_clase' => 'high'],
                ['nombre' => 'Valle Sagrado', 'afluencia' => 55, 'capacidad' => 1500, 'recomendacion' => 'Ideal para visitas de día completo.', 'nivel_clase' => 'medium'],
                ['nombre' => 'Camino Inca', 'afluencia' => 100, 'capacidad' => 500, 'recomendacion' => 'Permisos agotados.', 'nivel_clase' => 'critical'],
                ['nombre' => 'Laguna Humantay', 'afluencia' => 65, 'capacidad' => 300, 'recomendacion' => 'Llevar ropa abrigadora.', 'nivel_clase' => 'high'],
                ['nombre' => 'Salineras de Maras', 'afluencia' => 40, 'capacidad' => 200, 'recomendacion' => 'Excelente para fotografía.', 'nivel_clase' => 'medium'],
            ],
            'destino_focus' => 'Machu Picchu',
            'alertas' => [
                ['nivel' => 'critica', 'titulo' => 'Alerta de Capacidad: Camino Inca', 'descripcion' => 'Permisos para el Camino Inca están al 100% para los próximos 15 días.', 'timestamp' => 'Hace 15 minutos'],
                ['nivel' => 'advertencia', 'titulo' => 'Afluencia Alta en Machu Picchu', 'descripcion' => 'Se espera que la afluencia supere el 90% entre las 10:00 y las 14:00.', 'timestamp' => 'Hace 1 hora'],
            ],
            'reservas' => [
                ['destino' => 'Machu Picchu', 'fecha' => '2025-12-10', 'grupos' => 15, 'personas' => 120, 'estado' => 'confirmada'],
                ['destino' => 'Valle Sagrado', 'fecha' => '2025-12-10', 'grupos' => 8, 'personas' => 60, 'estado' => 'pagada'],
            ],
            'recomendaciones' => [
                ['tipo' => 'distribucion', 'titulo' => 'Distribuir visitantes de Machu Picchu', 'descripcion' => 'Promocionar Piquillacta y Tipón como alternativas.', 'impacto' => 85],
                ['tipo' => 'horario', 'titulo' => 'Extender Horarios en Valle Sagrado', 'descripcion' => 'Abrir Ollantaytambo hasta las 19:00.', 'impacto' => 60],
            ],
            'tendencias' => [
                'machu_picchu_tendencia' => 7.5,
                'vinicunca_tendencia' => 12.2,
                'comunitario_tendencia' => 4.8,
            ],
            // Data for JS charts
            'hourly_prediction' => [
                'labels' => ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00'],
                'prediction' => [15, 45, 85, 90, 70, 50, 30],
                'historic' => [12, 40, 80, 85, 65, 45, 25],
                'capacity' => [100, 100, 100, 100, 100, 100, 100]
            ],
            'trend_data_mp' => ['labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'], 'data' => [65, 70, 75, 80, 85, 90, 85]],
            'trend_data_vc' => ['labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'], 'data' => [45, 50, 55, 60, 65, 70, 65]],
            'trend_data_com' => ['labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'], 'data' => [20, 25, 30, 35, 40, 45, 40]],
        ];

        $this->view('admin/dashboard_predicciones', $data);
    }
}


