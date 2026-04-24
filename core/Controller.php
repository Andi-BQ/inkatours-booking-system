<?php

class Controller {
    public function model($model) {
        require_once 'models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        if (file_exists('views/' . $view . '.php')) {
            // CSRF validation helper for POST requests
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->checkCsrf();
            }

            // Centralized session data for all views
            $data['isLoggedIn'] = $this->isLoggedIn();
            $data['isAdmin'] = $this->isAdmin();
            $data['user_name'] = $_SESSION['user_name'] ?? '';

            // Extract data to variables
            extract($data);
            
            // Start output buffering
            ob_start();
            require_once 'views/' . $view . '.php';
            echo ob_get_clean();
        } else {
            die('View does not exist');
        }
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function isAdmin() {
        return isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'admin';
    }

    protected function redirect($url) {
        header('Location: /Inkatours' . $url);
        exit;
    }

    protected function checkCsrf() {
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            header('HTTP/1.1 403 Forbidden');
            die('Error de validación CSRF.');
        }
    }
}