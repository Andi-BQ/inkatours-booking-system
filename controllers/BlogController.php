<?php

class BlogController extends Controller {
    private $blogModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->blogModel = new Blog($db);
    }

    public function index() {
        $result = $this->blogModel->read();
        $articulos = $result->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Blog Sostenible - InkaTours',
            'active_page' => 'blog',
            'articulos' => $articulos
        ];
        $this->view('blog', $data);
    }

    public function show($id) {
        $this->blogModel->id = $id;
        $this->blogModel->read_single();

        $data = [
            'title' => $this->blogModel->titulo . ' - InkaTours',
            'active_page' => 'blog',
            'articulo' => $this->blogModel
        ];

        $this->view('blog_show', $data);
    }
}