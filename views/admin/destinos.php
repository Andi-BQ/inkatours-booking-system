<?php require_once 'partials/header.php'; ?>

<div class="admin-header">
    <h1>Gestión de Destinos</h1>
    <a href="/Inkatours/admin/destino_form" class="btn btn-primary">Crear Nuevo Destino</a>
</div>

<?php if (isset($_GET['error']) && $_GET['error'] === 'max_featured'): ?>
    <div class="notice error">
        <p><strong>Error:</strong> No se pueden destacar más de 6 destinos. Por favor, quite un destino de destacados antes de agregar uno nuevo.</p>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Dificultad</th>
            <th>Precio</th>
            <th>Activo</th>
            <th>Destacado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data['destinos'])): ?>
            <tr>
                <td colspan="8">No hay destinos para mostrar.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data['destinos'] as $destino): ?>
                <tr>
                    <td><?php echo htmlspecialchars($destino['id']); ?></td>
                    <td><?php echo htmlspecialchars($destino['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($destino['tipo']); ?></td>
                    <td><?php echo htmlspecialchars($destino['dificultad']); ?></td>
                    <td>$<?php echo htmlspecialchars($destino['precio_base']); ?></td>
                    <td>
                        <?php if ($destino['activo']): ?>
                            <span class="status-active">Activo</span>
                        <?php else: ?>
                            <span class="status-inactive">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($destino['destacado']) && $destino['destacado']): ?>
                            <span class="status-featured">Sí</span>
                        <?php else: ?>
                            <span class="status-not-featured">No</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="/Inkatours/admin/destino_editar/<?php echo $destino['id']; ?>" class="btn-edit"><i class="fas fa-pencil-alt"></i> Editar</a>
                        <?php if (isset($destino['destacado']) && $destino['destacado']): ?>
                            <a href="/Inkatours/admin/destino_no_destacar/<?php echo $destino['id']; ?>" class="btn-unfeature"><i class="fas fa-star-slash"></i> No Destacar</a>
                        <?php else: ?>
                            <a href="/Inkatours/admin/destino_destacar/<?php echo $destino['id']; ?>" class="btn-feature"><i class="fas fa-star"></i> Destacar</a>
                        <?php endif; ?>
                        <a href="/Inkatours/admin/destino_eliminar/<?php echo $destino['id']; ?>" class="btn-delete" onclick="return confirm('¿Está seguro de que desea eliminar este destino?');"><i class="fas fa-trash"></i> Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<style>
    .status-active {
        background-color: #d4edda; color: #155724; padding: 0.2rem 0.5rem; border-radius: 0.3rem; font-weight: 500;
    }
    .status-inactive {
        background-color: #f8d7da; color: #721c24; padding: 0.2rem 0.5rem; border-radius: 0.3rem; font-weight: 500;
    }
    .status-featured {
        background-color: #fff3cd; color: #856404; padding: 0.2rem 0.5rem; border-radius: 0.3rem; font-weight: 500;
    }
    .status-not-featured {
        color: #6c757d;
    }
    .actions a {
        padding: 0.4rem 0.8rem; border-radius: 0.3rem; text-decoration: none; margin-right: 0.5rem; color: white; font-size: 0.9rem;
    }
    .btn-edit { background-color: #ffc107; }
    .btn-feature { background-color: #17a2b8; }
    .btn-unfeature { background-color: #6c757d; }
    .btn-delete { background-color: #dc3545; }
</style>

<?php require_once 'partials/footer.php'; ?>