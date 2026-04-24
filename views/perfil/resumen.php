<div class="profile-card">
    <h3><i class="fas fa-info-circle"></i> Tu Información</h3>
    <div class="info-grid">
        <div class="info-item">
            <strong>Nombre Completo:</strong>
            <span><?php echo htmlspecialchars($user->nombre); ?></span>
        </div>
        <div class="info-item">
            <strong>Email:</strong>
            <span><?php echo htmlspecialchars($user->email); ?></span>
        </div>
        <div class="info-item">
            <strong>Teléfono:</strong>
            <span><?php echo htmlspecialchars($user->telefono ?: 'No especificado'); ?></span>
        </div>
        <div class="info-item">
            <strong>País:</strong>
            <span><?php echo htmlspecialchars($user->pais ?: 'No especificado'); ?></span>
        </div>
        <div class="info-item">
            <strong>Rol:</strong>
            <span><?php echo htmlspecialchars(ucfirst($user->rol)); ?></span>
        </div>
        <div class="info-item">
            <strong>Último Inicio de Sesión:</strong>
            <span><?php echo date('d M Y, H:i', strtotime($user->ultimo_login)); ?></span>
        </div>
    </div>
</div>

<div class="profile-card">
    <h3><i class="fas fa-chart-line"></i> Actividad Reciente</h3>
    <p>Aquí se mostrará un resumen de tus últimas reservas y actividades.</p>
    <!-- Placeholder for activity -->
</div>
