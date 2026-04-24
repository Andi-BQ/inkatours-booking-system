<?php require_once 'partials/header.php'; ?>

<?php
// Lógica para determinar si estamos creando o editando
$es_edicion = isset($data['destino']) && !empty($data['destino']['id']);
$destino = $data['destino'] ?? [];
?>

<div class="admin-header">
    <h1><?php echo e($es_edicion ? 'Editar Destino' : 'Crear Nuevo Destino'); ?></h1>
    <a href="/Inkatours/admin/destinos" class="btn btn-secondary">Volver a la lista</a>
</div>

<div class="form-container">
    <form action="/Inkatours/admin/<?php echo e($es_edicion ? 'destino_guardar' : 'create_destino'); ?>" method="POST" class="form-grid" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <?php if ($es_edicion): ?>
            <input type="hidden" name="id" value="<?php echo e($destino['id']); ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo e($destino['nombre'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" value="<?php echo e($destino['slug'] ?? ''); ?>" <?php echo $es_edicion ? 'readonly' : 'required'; ?>>
        </div>
        
        <div class="form-group full-width">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required><?php echo e($destino['descripcion'] ?? ''); ?></textarea>
        </div>

        <div class="form-group full-width">
            <label for="descripcion_corta">Descripción Corta</label>
            <textarea id="descripcion_corta" name="descripcion_corta" required><?php echo e($destino['descripcion_corta'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="imagen_principal">Imagen Principal (PNG)</label>
            <input type="file" id="imagen_principal" name="imagen_principal" accept="image/png" <?php echo $es_edicion ? '' : 'required'; ?>>
            <?php if ($es_edicion && !empty($destino['imagen_principal'])): ?>
                <small>Imagen actual: <?php echo e($destino['imagen_principal']); ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" name="categoria_id" required>
                <!-- TODO: Populate with categories from DB -->
                <option value="1" <?php echo ($destino['categoria_id'] ?? '') == '1' ? 'selected' : ''; ?>>Sitios Arqueológicos</option>
                <option value="2" <?php echo ($destino['categoria_id'] ?? '') == '2' ? 'selected' : ''; ?>>Naturaleza y Aventura</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo</label>
            <select id="tipo" name="tipo" required>
                <option value="cultural" <?php echo ($destino['tipo'] ?? '') == 'cultural' ? 'selected' : ''; ?>>Cultural</option>
                <option value="naturaleza" <?php echo ($destino['tipo'] ?? '') == 'naturaleza' ? 'selected' : ''; ?>>Naturaleza</option>
                <option value="aventura" <?php echo ($destino['tipo'] ?? '') == 'aventura' ? 'selected' : ''; ?>>Aventura</option>
                <option value="comunitario" <?php echo ($destino['tipo'] ?? '') == 'comunitario' ? 'selected' : ''; ?>>Comunitario</option>
            </select>
        </div>

        <div class="form-group">
            <label for="dificultad">Dificultad</label>
            <select id="dificultad" name="dificultad" required>
                <option value="facil" <?php echo ($destino['dificultad'] ?? '') == 'facil' ? 'selected' : ''; ?>>Fácil</option>
                <option value="moderada" <?php echo ($destino['dificultad'] ?? '') == 'moderada' ? 'selected' : ''; ?>>Moderada</option>
                <option value="dificil" <?php echo ($destino['dificultad'] ?? '') == 'dificil' ? 'selected' : ''; ?>>Difícil</option>
            </select>
        </div>

        <div class="form-group">
            <label for="precio_base">Precio Base</label>
            <input type="number" step="0.01" id="precio_base" name="precio_base" value="<?php echo e($destino['precio_base'] ?? '0.00'); ?>" required>
        </div>

        <div class="form-group">
            <label for="duracion_horas">Duración (Horas)</label>
            <input type="number" id="duracion_horas" name="duracion_horas" value="<?php echo e($destino['duracion_horas'] ?? '0'); ?>" required>
        </div>

        <div class="form-group">
            <label for="latitud">Latitud</label>
            <input type="text" id="latitud" name="latitud" value="<?php echo e($destino['lat'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="longitud">Longitud</label>
            <input type="text" id="longitud" name="longitud" value="<?php echo e($destino['lng'] ?? ''); ?>" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?php echo e($es_edicion ? 'Guardar Cambios' : 'Crear Destino'); ?></button>
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>