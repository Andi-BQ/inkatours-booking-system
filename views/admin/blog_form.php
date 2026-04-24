<?php require_once 'partials/header.php'; ?>

<?php
// Lógica para determinar si estamos creando o editando
$es_edicion = isset($data['articulo']) && !empty($data['articulo']['id']);
$articulo = $data['articulo'] ?? [];
?>

<div class="admin-header">
    <h1><?php echo $es_edicion ? 'Editar Artículo' : 'Crear Nuevo Artículo'; ?></h1>
    <a href="/Inkatours/admin/blog" class="btn btn-secondary">Volver a la lista</a>
</div>

<div class="form-container">
    <form action="/Inkatours/admin/<?php echo $es_edicion ? 'blog_guardar' : 'create_blog'; ?>" method="POST" class="form-grid" enctype="multipart/form-data">
        
        <?php if ($es_edicion): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($articulo['id']); ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($articulo['titulo'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($articulo['slug'] ?? ''); ?>" <?php echo $es_edicion ? 'readonly' : 'required'; ?>>
        </div>
        
        <div class="form-group full-width">
            <label for="contenido">Contenido</label>
            <textarea id="contenido" name="contenido" required><?php echo htmlspecialchars($articulo['contenido'] ?? ''); ?></textarea>
        </div>

        <div class="form-group full-width">
            <label for="resumen">Resumen</label>
            <textarea id="resumen" name="resumen" required><?php echo htmlspecialchars($articulo['resumen'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="imagen_principal">Imagen Principal (PNG)</label>
            <input type="file" id="imagen_principal" name="imagen_principal" accept="image/png" <?php echo $es_edicion ? '' : 'required'; ?>>
            <?php if ($es_edicion && !empty($articulo['imagen_principal'])): ?>
                <small>Imagen actual: <?php echo htmlspecialchars($articulo['imagen_principal']); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" name="categoria_id" required>
                <!-- TODO: Populate with categories from DB -->
                <option value="1" <?php echo ($articulo['categoria_id'] ?? '') == '1' ? 'selected' : ''; ?>>Sostenibilidad</option>
                <option value="2" <?php echo ($articulo['categoria_id'] ?? '') == '2' ? 'selected' : ''; ?>>Aventura</option>
                <option value="3" <?php echo ($articulo['categoria_id'] ?? '') == '3' ? 'selected' : ''; ?>>Conservación</option>
            </select>
        </div>

        <div class="form-group">
            <label for="autor_id">Autor</label>
            <select id="autor_id" name="autor_id" required>
                <!-- TODO: Populate with users from DB -->
                <option value="1" <?php echo ($articulo['autor_id'] ?? '') == '1' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tiempo_lectura">Tiempo de lectura (min)</label>
            <input type="number" id="tiempo_lectura" name="tiempo_lectura" value="<?php echo htmlspecialchars($articulo['tiempo_lectura'] ?? '5'); ?>" required>
        </div>

        <div class="form-group">
            <label for="palabras_clave">Palabras Clave (separadas por coma)</label>
            <input type="text" id="palabras_clave" name="palabras_clave" value="<?php echo htmlspecialchars($articulo['palabras_clave'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="destacado">Destacado</label>
            <select id="destacado" name="destacado" required>
                <option value="1" <?php echo ($articulo['destacado'] ?? '0') == '1' ? 'selected' : ''; ?>>Sí</option>
                <option value="0" <?php echo ($articulo['destacado'] ?? '0') == '0' ? 'selected' : ''; ?>>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="activo">Estado</label>
            <select id="activo" name="activo" required>
                <option value="1" <?php echo ($articulo['activo'] ?? '0') == '1' ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo ($articulo['activo'] ?? '0') == '0' ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?php echo $es_edicion ? 'Guardar Cambios' : 'Crear Artículo'; ?></button>
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>
