<?php
// Muestra un mensaje de confirmación si existe en la sesión.
if (isset($_SESSION['reserva_confirmada'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['reserva_confirmada']) . '</div>';
    unset($_SESSION['reserva_confirmada']);
}
?>
<div class="profile-card">
    <h3><i class="fas fa-calendar-check"></i> Mis Reservas</h3>

    <?php if (isset($data['reservas']) && !empty($data['reservas'])): ?>
        <div class="reservas-list">
            <?php foreach ($data['reservas'] as $reserva): ?>
                <div class="reserva-card">
                    <div class="reserva-card-img">
                        <a href="/Inkatours/<?php echo htmlspecialchars($reserva['item_path']); ?>/<?php echo htmlspecialchars($reserva['item_slug']); ?>">
                            <img src="/Inkatours/static/img/<?php echo htmlspecialchars($reserva['item_path']); ?>/<?php echo htmlspecialchars($reserva['item_imagen']); ?>" alt="<?php echo htmlspecialchars($reserva['item_nombre']); ?>" loading="lazy">
                        </a>
                    </div>
                    <div class="reserva-card-body">
                        <span class="reserva-status status-<?php echo htmlspecialchars($reserva['estado']); ?>"><?php echo htmlspecialchars(ucfirst($reserva['estado'])); ?></span>
                        <h4 class="reserva-title">
                            <a href="/Inkatours/<?php echo htmlspecialchars($reserva['item_path']); ?>/<?php echo htmlspecialchars($reserva['item_slug']); ?>">
                                <?php echo htmlspecialchars($reserva['item_nombre']); ?>
                            </a>
                        </h4>
                        <p class="reserva-number"><strong># Reserva:</strong> <?php echo htmlspecialchars($reserva['numero_reserva']); ?></p>
                        <div class="reserva-details">
                            <p><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($reserva['fecha_experiencia'])); ?></p>
                            <p><i class="fas fa-users"></i> <strong>Participantes:</strong> <?php echo htmlspecialchars($reserva['participantes']); ?></p>
                            <p><i class="fas fa-dollar-sign"></i> <strong>Total:</strong> S/ <?php echo htmlspecialchars(number_format($reserva['total'], 2)); ?></p>
                        </div>
                        
                        <div class="reserva-actions">
                        <?php if ($reserva['estado'] == 'pendiente'): ?>
                            <a href="/Inkatours/reservas/pagar/<?php echo $reserva['id']; ?>" class="btn-reserva-action btn-confirmar">
                                <i class="fas fa-credit-card"></i> Pagar 50% Inicial
                            </a>
                            <a href="/Inkatours/reservas/cancelar/<?php echo $reserva['id']; ?>" class="btn-reserva-action btn-cancelar" onclick="return confirm('¿Está seguro de que desea cancelar esta reserva?');">
                                <i class="fas fa-times-circle"></i> Cancelar
                            </a>
                        <?php elseif ($reserva['estado'] == 'confirmada'): ?>
                             <a href="/Inkatours/reservas/confirmar/<?php echo $reserva['id']; ?>" class="btn-reserva-action btn-confirmar">
                                <i class="fas fa-credit-card"></i> Pagar Saldo Restante
                            </a>
                            <?php if (!$reserva['has_reviewed']): ?>
                                <a href="/Inkatours/resena/escribir/<?php echo $reserva['id']; ?>" class="btn-reserva-action btn-review">
                                    <i class="fas fa-star"></i> Escribir Reseña
                                </a>
                            <?php endif; ?>
                        <?php elseif (in_array($reserva['estado'], ['pagada', 'completada'])): ?>
                            <p class="reserva-confirmada-texto"><i class="fas fa-check-double"></i> Reserva Pagada</p>
                            <?php if (!$reserva['has_reviewed']): ?>
                                <a href="/Inkatours/resena/escribir/<?php echo $reserva['id']; ?>" class="btn-reserva-action btn-review">
                                    <i class="fas fa-star"></i> Escribir Reseña
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-reservas">
            <i class="fas fa-folder-open"></i>
            <p>Aún no has realizado ninguna reserva.</p>
            <a href="/Inkatours/destinos" class="btn-primary">Explorar Destinos</a>
        </div>
    <?php endif; ?>
</div>

<style>
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: var(--border-radius);
        text-align: center;
        font-weight: 500;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .reservas-list {
        display: grid;
        gap: 1.5rem;
        margin-top: 1.5rem;
    }
    .reserva-card {
        display: flex;
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid var(--light-gray);
    }
    .reserva-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .reserva-card-img {
        flex: 0 0 180px;
    }
    .reserva-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .reserva-card-body {
        padding: 1.5rem;
        flex: 1;
        position: relative;
    }
    .reserva-title {
        margin: 0.25rem 0 0.5rem;
        font-size: 1.25rem;
    }
    .reserva-title a {
        text-decoration: none;
        color: var(--dark);
        transition: var(--transition);
    }
    .reserva-title a:hover {
        color: var(--primary);
    }
    .reserva-number {
        font-size: 0.9rem;
        color: var(--gray);
        margin-bottom: 1rem;
    }
    .reserva-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
        font-size: 0.9rem;
    }
    .reserva-details p {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .reserva-details .fas {
        color: var(--primary);
    }
    .reserva-actions {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--light-gray);
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    .reserva-confirmada-texto {
        margin: 0;
        font-weight: 600;
        color: var(--green-badge);
    }
    .btn-reserva-action {
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        color: white;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    .btn-confirmar {
        background-color: var(--primary);
    }
    .btn-confirmar:hover {
        background-color: var(--primary-dark);
    }
    .btn-cancelar {
        background-color: var(--secondary);
    }
    .btn-cancelar:hover {
        background-color: var(--secondary-dark);
    }
    .btn-review {
        background-color: #f39c12;
    }
    .btn-review:hover {
        background-color: #e67e22;
    }
    .btn-comprobante, .btn-comprobante-final {
        background-color: #3498db;
    }
    .btn-comprobante:hover, .btn-comprobante-final:hover {
        background-color: #2980b9;
    }
    .reserva-status {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #fff;
        text-transform: capitalize;
    }
    .status-pendiente { background-color: #f4a261; }
    .status-confirmada { background-color: #2a9d8f; }
    .status-pagada { background-color: #27ae60; }
    .status-completada { background-color: #3498db; }
    .status-cancelada { background-color: #e74c3c; }

    .no-reservas {
        text-align: center;
        padding: 3rem 1rem;
        border: 2px dashed var(--light-gray);
        border-radius: var(--border-radius);
        margin-top: 2rem;
    }
    .no-reservas .fas {
        font-size: 3rem;
        color: var(--light-gray);
        margin-bottom: 1rem;
    }
    .no-reservas p {
        font-size: 1.1rem;
        color: var(--gray);
        margin-bottom: 1.5rem;
    }
    .no-reservas .btn-primary {
        margin-top: 2.5rem; /* Increased to give more space */
    }
</style>
