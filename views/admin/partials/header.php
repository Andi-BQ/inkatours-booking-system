<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? htmlspecialchars($data['title']) : 'Admin Panel'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2A9D8F;
            --dark: #264653;
            --light: #F8F9FA;
            --white: #FFFFFF;
            --gray: #6C757D;
            --light-gray: #e9ecef;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            margin: 0;
            padding: 0;
        }
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 250px;
            background-color: var(--dark);
            color: var(--white);
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }
        .sidebar-header {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-header a {
            color: var(--white);
            text-decoration: none;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            color: var(--light-gray);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background-color: var(--primary);
            color: var(--white);
        }
        .sidebar-footer {
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            color: var(--light-gray);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .sidebar-footer a:hover {
            color: var(--white);
        }
        .admin-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--light-gray);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        .admin-header h1 {
            color: var(--dark);
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: #23867a;
        }
        .btn-secondary {
            background-color: var(--light-gray);
            color: var(--dark);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
            box-shadow: var(--shadow);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }
        th {
            background-color: #f9f9f9;
        }
        .form-container {
            background: var(--white);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="/Inkatours/admin/dashboard">InkaTours Admin</a>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="/Inkatours/admin/dashboard" class="<?php echo $data['active_page'] === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-comment-dots"></i> Reseñas
                    </a>
                </li>
                <li>
                    <a href="/Inkatours/admin/predicciones" class="<?php echo $data['active_page'] === 'predicciones' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/Inkatours/admin/destinos" class="<?php echo $data['active_page'] === 'destinos' ? 'active' : ''; ?>">
                        <i class="fas fa-map-signs"></i> Destinos
                    </a>
                </li>
                 <li>
                    <a href="/Inkatours/admin/actividades" class="<?php echo $data['active_page'] === 'actividades' ? 'active' : ''; ?>">
                        <i class="fas fa-hiking"></i> Actividades
                    </a>
                </li>
                <li>
                    <a href="/Inkatours/admin/blog" class="<?php echo $data['active_page'] === 'blog' ? 'active' : ''; ?>">
                        <i class="fas fa-newspaper"></i> Blog
                    </a>
                </li>
                <li>
                    <a href="/Inkatours/admin/configuracion" class="<?php echo $data['active_page'] === 'configuracion' ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i> Configuración
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="/Inkatours/iniciosesion/logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </div>
        </aside>

        <main class="admin-content">
