<?php require_once 'partials/header.php'; ?>

<div class="admin-header">
    <h1>Gestión de Reseñas</h1>
</div>

<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Comentario</th>
            <th>Calificación</th>
            <th>Tipo</th>
            <th>Elemento ID</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data['reviews'])): ?>
            <tr>
                <td colspan="7">No hay reseñas para mostrar.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data['reviews'] as $review): ?>
                <tr>
                    <td><?php echo htmlspecialchars($review['usuario_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($review['comentario']); ?></td>
                    <td><?php echo htmlspecialchars($review['calificacion']); ?> ★</td>
                    <td><?php echo htmlspecialchars($review['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($review['elemento_id']); ?></td>
                    <td>
                        <?php if ($review['aprobado']): ?>
                            <span class="status-approved">Aprobado</span>
                        <?php else: ?>
                            <span class="status-pending">Pendiente</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <div style="display: flex; gap: 0.5rem;">
                            <?php if (!$review['aprobado']): ?>
                                <a href="/Inkatours/admin/approve/<?php echo $review['id']; ?>" class="btn-approve"><i class="fas fa-check"></i> Aprobar</a>
                            <?php else: ?>
                                <a href="/Inkatours/admin/disapprove_review/<?php echo $review['id']; ?>" class="btn-disapprove"><i class="fas fa-times"></i> Desaprobar</a>
                            <?php endif; ?>
                            <a href="/Inkatours/admin/reject/<?php echo $review['id']; ?>" class="btn-delete" onclick="return confirm('¿Está seguro de que desea eliminar esta reseña?');"><i class="fas fa-trash"></i> Eliminar</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<style>
    .status-approved {
        background-color: #d4edda;
        color: #155724;
        padding: 0.2rem 0.5rem;
        border-radius: 0.3rem;
        font-weight: 500;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        padding: 0.2rem 0.5rem;
        border-radius: 0.3rem;
        font-weight: 500;
    }
    .actions a {
        padding: 0.5rem 1rem; /* Slightly increased padding */
        border-radius: 0.3rem;
        text-decoration: none;
        margin-right: 0.5rem;
        color: white;
        font-size: 0.9rem;
        display: inline-flex; /* To align icon and text */
        align-items: center;
        gap: 0.3rem; /* Space between icon and text */
        transition: all 0.2s ease-in-out; /* Smooth transitions */
    }
    .btn-approve {
        background-color: #28a745;
    }
    .btn-approve:hover {
        background-color: #218838;
        transform: translateY(-1px);
    }
    .btn-disapprove {
        background-color: #ffc107;
    }
    .btn-disapprove:hover {
        background-color: #e0a800;
        transform: translateY(-1px);
    }
    .btn-delete {
        background-color: #dc3545;
        border: 1px solid #dc3545; /* Add a border */
    }
    .btn-delete:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
    }
</style>

<?php require_once 'partials/footer.php'; ?>
