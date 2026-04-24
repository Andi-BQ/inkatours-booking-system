<?php require_once 'partials/header.php'; ?>

<?php $reserva = $data['reserva']; ?>

<style>
.confirmation-container {
    padding: 4rem 0;
    background-color: #f8f9fa;
}
.confirmation-box {
    max-width: 800px;
    margin: auto;
    background-color: #fff;
    padding: 3rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
}
.confirmation-icon {
    font-size: 4rem;
    color: var(--success);
    margin-bottom: 1.5rem;
}
.confirmation-box h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
}
.confirmation-box p {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 2rem;
}
.reserva-summary {
    text-align: left;
    margin-bottom: 2rem;
    border-top: 1px solid #dee2e6;
    padding-top: 2rem;
}
.reserva-summary h3 {
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
}
.reserva-summary ul {
    list-style: none;
    padding: 0;
}
.reserva-summary ul li {
    padding: 0.5rem 0;
    font-size: 1.1rem;
}
.participantes-list {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}
.participantes-list h4 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
}
.participantes-list ul {
    padding-left: 1rem;
    list-style: '→ ';
}
.participantes-list ul li {
    padding: 0.25rem 0;
    color: #495057;
}
.participantes-list .tipo-turista {
    font-style: italic;
    font-size: 0.9em;
    color: #6c757d;
}

.confirmation-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<section class="page-hero">
    <div class="container">
        <h1>¡Reserva Exitosa!</h1>
        <p>Gracias por confiar en InkaTours para tu próxima aventura.</p>
    </div>
</section>

<section class="confirmation-container">
    <div class="container">
        <div class="confirmation-box">
            <div class="confirmation-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>¡Gracias, <?php echo htmlspecialchars(explode(' ', $reserva['usuario_nombre'])[0]); ?>! Tu reserva está en proceso.</h2>
            <p>Hemos realizado el primer cargo y enviado un email de confirmación a <strong><?php echo htmlspecialchars($reserva['usuario_email']); ?></strong>. Recuerda completar el pago final desde tu perfil.</p>
            
            <div class="reserva-summary">
                <h3>Resumen de tu Reserva</h3>
                <ul>
                    <li><strong>Número de Reserva:</strong> <?php echo htmlspecialchars($reserva['numero_reserva']); ?></li>
                    <li><strong>Actividad/Destino:</strong> <?php echo htmlspecialchars($reserva['item_nombre']); ?></li>
                    <li><strong>Fecha de la Experiencia:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_experiencia'])); ?></li>
                    <li><strong>Participantes:</strong> <?php echo htmlspecialchars($reserva['participantes']); ?></li>
                    <li><strong>Total Pagado (50%):</strong> $<?php echo number_format($reserva['total'], 2); ?> <?php echo htmlspecialchars($reserva['moneda']); ?></li>
                </ul>

                <?php if (isset($reserva['participantes_detalle']) && !empty($reserva['participantes_detalle'])): ?>
                <div class="participantes-list">
                    <h4>Participantes:</h4>
                    <ul>
                        <?php foreach ($reserva['participantes_detalle'] as $participante): ?>
                            <li><?php echo htmlspecialchars($participante['nombre']); ?> - <span class="tipo-turista">Tipo: <?php echo htmlspecialchars(ucfirst($participante['tipo_documento'])); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>

            <div class="confirmation-actions">
                <a href="/Inkatours/reservas/comprobante/<?php echo htmlspecialchars($reserva['numero_reserva']); ?>" class="btn-primary" target="_blank"><i class="fas fa-file-pdf"></i> Descargar Comprobante en PDF</a>
                <a href="/Inkatours/perfil/reservas" class="btn-secondary">Ir a Mis Reservas</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>