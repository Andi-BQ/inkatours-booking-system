<?php require_once 'partials/header.php'; ?>

<div class="admin-header">
    <h1>Gestión de Actividades</h1>
    <a href="/Inkatours/admin/actividad_form" class="btn btn-primary">Crear Nueva Actividad</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Dificultad</th>
            <th>Precio</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data['actividades'])): ?>
            <tr>
                <td colspan="7">No hay actividades para mostrar.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data['actividades'] as $actividad): ?>
                <tr>
                    <td><?php echo htmlspecialchars($actividad['id']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['categoria']); ?></td>
                    <td><?php echo htmlspecialchars($actividad['dificultad']); ?></td>
                    <td>$<?php echo htmlspecialchars($actividad['precio']); ?></td>
                    <td>
                        <?php if ($actividad['activo']): ?>
                            <span class="status-active">Activo</span>
                        <?php else: ?>
                            <span class="status-inactive">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="/Inkatours/admin/actividad_editar/<?php echo $actividad['id']; ?>" class="btn-edit"><i class="fas fa-pencil-alt"></i> Editar</a>
                        <a href="/Inkatours/admin/actividad_eliminar/<?php echo $actividad['id']; ?>" class="btn-delete" onclick="return confirm('¿Está seguro de que desea eliminar esta actividad?');"><i class="fas fa-trash"></i> Eliminar</a>
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
    .actions a {
        padding: 0.4rem 0.8rem; border-radius: 0.3rem; text-decoration: none; margin-right: 0.5rem; color: white; font-size: 0.9rem;
    }
    .btn-edit { background-color: #ffc107; }
    .btn-delete { background-color: #dc3545; }
</style>

<?php require_once 'partials/footer.php'; ?>
