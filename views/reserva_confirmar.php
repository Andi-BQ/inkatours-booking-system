<?php require_once 'partials/header.php'; ?>

<?php
// Extrayendo datos para más fácil acceso
$reserva = $data['reserva'];
$monto_total = $reserva['subtotal'];
$monto_pagado = $reserva['total'];
$monto_restante = $monto_total - $monto_pagado;
?>

<style>
.confirmation-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #fff;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}
.confirmation-header h1 {
    text-align: center;
    margin-bottom: 2rem;
    color: var(--dark);
}
.reserva-summary {
    border: 1px solid var(--light-gray);
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 2rem;
}
.reserva-summary h3 {
    border-bottom: 1px solid var(--light-gray);
    padding-bottom: 1rem;
    margin-bottom: 1rem;
}
.summary-item {
    display: flex;
    justify-content: space-between;
    font-size: 1.1rem;
    margin-bottom: 0.75rem;
}
.summary-item strong {
    color: var(--dark);
}
.payment-details {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--primary);
}
.payment-details .summary-item {
    font-size: 1.2rem;
}
.monto-restante {
    font-weight: 700;
    color: var(--primary);
}
.payment-form {
    margin-top: 2rem;
}
.payment-form .form-group {
    margin-bottom: 1rem;
}
.payment-form label {
    font-weight: 600;
}
.payment-form input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ccc;
    border-radius: var(--border-radius);
}
.btn-pagar {
    display: block;
    width: 100%;
    padding: 1rem;
    font-size: 1.2rem;
    font-weight: 600;
    background-color: var(--primary);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
    text-align: center;
}
.btn-pagar:hover {
    background-color: var(--primary-dark);
}
.participantes-summary {
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
}
.participantes-summary h3 {
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--light-gray);
}
.participantes-summary ul {
    list-style: none;
    padding: 0;
}
.participantes-summary li {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}
.participantes-summary li:last-child {
    border-bottom: none;
}
.participantes-summary .nombre {
    font-weight: 500;
}
.participantes-summary .tipo-turista {
    font-style: italic;
    color: #6c757d;
}
</style>

<div class="confirmation-container">
    <div class="confirmation-header">
        <h1>Confirmar Pago Final de Reserva</h1>
        <p>Estás a un paso de confirmar tu aventura. Por favor, revisa los detalles y completa el pago.</p>
    </div>

    <div class="reserva-summary">
        <h3>Resumen de tu Reserva</h3>
        <div class="summary-item">
            <span>Número de Reserva:</span>
            <strong><?php echo htmlspecialchars($reserva['numero_reserva']); ?></strong>
        </div>
        <div class="summary-item">
            <span>Fecha de Experiencia:</span>
            <strong><?php echo date('d/m/Y', strtotime($reserva['fecha_experiencia'])); ?></strong>
        </div>
        <div class="summary-item">
            <span>Participantes:</span>
            <strong><?php echo htmlspecialchars($reserva['participantes']); ?></strong>
        </div>
    </div>

    <?php if (isset($reserva['participantes_detalle']) && !empty($reserva['participantes_detalle'])): ?>
    <div class="participantes-summary">
        <h3>Detalles de los Participantes</h3>
        <ul>
            <?php foreach ($reserva['participantes_detalle'] as $participante): ?>
                <li>
                    <span class="nombre"><?php echo htmlspecialchars($participante['nombre']); ?></span>
                    <span class="tipo-turista">Tipo: <?php echo htmlspecialchars(ucfirst($participante['tipo_documento'])); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="payment-details">
        <div class="summary-item">
            <span>Monto Total de la Reserva:</span>
            <strong>S/ <?php echo htmlspecialchars(number_format($monto_total, 2)); ?></strong>
        </div>
        <div class="summary-item">
            <span>Monto Pagado (50%):</span>
            <span>- S/ <?php echo htmlspecialchars(number_format($monto_pagado, 2)); ?></span>
        </div>
        <hr>
        <div class="summary-item">
            <span>Monto Restante a Pagar:</span>
            <strong class="monto-restante">S/ <?php echo htmlspecialchars(number_format($monto_restante, 2)); ?></strong>
        </div>
    </div>

    <form action="/Inkatours/reservas/procesar_confirmacion" method="POST" class="payment-form">
        <input type="hidden" name="reserva_id" value="<?php echo $reserva['id']; ?>">
        
        <!-- Simulación de campos de pago -->
        <p>Por favor, ingresa los detalles de tu tarjeta para completar el pago.</p>
        <div class="form-group">
            <label for="card_number">Número de Tarjeta</label>
            <input type="text" id="card_number" placeholder="xxxx-xxxx-xxxx-xxxx" required>
        </div>
        <div class="form-group">
            <label for="card_expiry">Fecha de Expiración</label>
            <input type="text" id="card_expiry" placeholder="MM/YY" required>
        </div>
        <div class="form-group">
            <label for="card_cvc">CVC</label>
            <input type="text" id="card_cvc" placeholder="123" required>
        </div>

        <button type="submit" class="btn-pagar">
            <i class="fas fa-lock"></i> Pagar y Confirmar (S/ <?php echo htmlspecialchars(number_format($monto_restante, 2)); ?>)
        </button>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>
