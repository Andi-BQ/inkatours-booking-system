<?php require_once 'partials/header.php'; ?>

<?php $user = $data['user']; ?>

<section class="page-hero">
    <div class="container">
        <h1>Mi Perfil</h1>
        <p>Hola, <?php echo htmlspecialchars($user->nombre); ?>. ¡Bienvenido a tu panel de control!</p>
    </div>
</section>

<section class="profile-container">
    <div class="container">
        <div class="profile-grid">
            <!-- Sidebar de Perfil -->
            <div class="profile-sidebar">
                <div class="profile-avatar">

                    <h3><?php echo htmlspecialchars($user->nombre); ?></h3>
                    <p>Miembro desde <?php echo date('M Y', strtotime($user->created_at)); ?></p>
                </div>
                <ul class="profile-menu">
                    <li class="<?php echo ($data['subpage'] == 'resumen') ? 'active' : ''; ?>"><a href="/Inkatours/perfil/resumen"><i class="fas fa-user-circle"></i> Resumen</a></li>
                    <li class="<?php echo ($data['subpage'] == 'reservas') ? 'active' : ''; ?>"><a href="/Inkatours/perfil/reservas"><i class="fas fa-calendar-check"></i> Mis Reservas</a></li>
                    <li class="<?php echo ($data['subpage'] == 'editar') ? 'active' : ''; ?>"><a href="/Inkatours/perfil/editar"><i class="fas fa-edit"></i> Editar Perfil</a></li>
                    <li class="<?php echo ($data['subpage'] == 'notificaciones') ? 'active' : ''; ?>"><a href="/Inkatours/perfil/notificaciones"><i class="fas fa-bell"></i> Notificaciones</a></li>
                    <li><a href="/Inkatours/iniciosesion/logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                </ul>
            </div>

            <!-- Contenido Principal del Perfil -->
            <div class="profile-content">
                <?php
                // Cargar la vista parcial según la subpágina
                $subpage_view = __DIR__ . '/perfil/' . $data['subpage'] . '.php';
                if (file_exists($subpage_view)) {
                    include $subpage_view;
                } else {
                    include __DIR__ . '/perfil/resumen.php'; // Vista por defecto
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
// Solo carga el script de perfil en la página de edición
if ($data['subpage'] == 'editar') {
    echo '<script src="/Inkatours/static/js/perfil.js"></script>';
}
?>

<?php require_once 'partials/footer.php'; ?>
