<?php require_once 'partials/header.php'; ?>

<div class="admin-header">
    <h1>Gestión de Blog</h1>
    <a href="/Inkatours/admin/blog_form" class="btn btn-primary">Crear Nuevo Artículo</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>Autor</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data['articulos'])): ?>
            <tr>
                <td colspan="6">No hay artículos para mostrar.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data['articulos'] as $articulo): ?>
                <tr>
                    <td><?php echo htmlspecialchars($articulo['id']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['categoria_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($articulo['autor_nombre']); ?></td>
                    <td>
                        <?php if ($articulo['activo']): ?>
                            <span class="status-active">Activo</span>
                        <?php else: ?>
                            <span class="status-inactive">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <?php if ($articulo['activo']): ?>
                            <a href="/Inkatours/admin/blog_disapprove/<?php echo $articulo['id']; ?>" class="btn-disapprove"><i class="fas fa-times-circle"></i> Desaprobar</a>
                        <?php else: ?>
                            <a href="/Inkatours/admin/blog_approve/<?php echo $articulo['id']; ?>" class="btn-approve"><i class="fas fa-check-circle"></i> Aprobar</a>
                        <?php endif; ?>
                        <a href="/Inkatours/admin/blog_edit/<?php echo $articulo['id']; ?>" class="btn-edit"><i class="fas fa-pencil-alt"></i> Editar</a>
                        <a href="/Inkatours/admin/blog_delete/<?php echo $articulo['id']; ?>" class="btn-delete" onclick="return confirm('¿Está seguro de que desea eliminar este artículo?');"><i class="fas fa-trash"></i> Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<style>
    .status-active, .status-approved {
        background-color: #d4edda;
        color: #155724;
        padding: 0.2rem 0.5rem;
        border-radius: 0.3rem;
        font-weight: 500;
    }
    .status-inactive, .status-pending {
        background-color: #fff3cd;
        color: #856404;
        padding: 0.2rem 0.5rem;
        border-radius: 0.3rem;
        font-weight: 500;
    }
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }
    .actions a {
        padding: 0.5rem 1rem;
        border-radius: 0.3rem;
        text-decoration: none;
        margin-right: 0.5rem;
        color: white;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: all 0.2s ease-in-out;
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
    .btn-edit {
        background-color: #17a2b8;
    }
    .btn-edit:hover {
        background-color: #138496;
        transform: translateY(-1px);
    }
    .btn-delete {
        background-color: #dc3545;
        border: 1px solid #dc3545;
    }
    .btn-delete:hover {
        background-color: #c82333;
        border-color: #bd2130;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<?php require_once 'partials/footer.php'; ?>
