<?php require_once 'partials/header.php'; ?>

<?php
// Lógica para determinar si estamos creando o editando
$es_edicion = isset($data['actividad']) && !empty($data['actividad']['id']);
$actividad = $data['actividad'] ?? [];
?>

<div class="admin-header">
    <h1><?php echo $es_edicion ? 'Editar Actividad' : 'Crear Nueva Actividad'; ?></h1>
    <a href="/Inkatours/admin/actividades" class="btn btn-secondary">Volver a la lista</a>
</div>

<div class="form-container">
    <form action="/Inkatours/admin/<?php echo $es_edicion ? 'actividad_guardar' : 'create_actividad'; ?>" method="POST" class="form-grid">
        
        <?php if ($es_edicion): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($actividad['id']); ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($actividad['nombre'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($actividad['slug'] ?? ''); ?>" <?php echo $es_edicion ? 'readonly' : 'required'; ?>>
        </div>
        
        <div class="form-group full-width">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($actividad['descripcion'] ?? ''); ?></textarea>
        </div>

        <div class="form-group full-width">
            <label for="descripcion_corta">Descripción Corta</label>
            <textarea id="descripcion_corta" name="descripcion_corta" required><?php echo htmlspecialchars($actividad['descripcion_corta'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="imagen_principal">Imagen Principal (URL)</label>
            <input type="text" id="imagen_principal" name="imagen_principal" value="<?php echo htmlspecialchars($actividad['imagen_principal'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria" required>
                <option value="cultural" <?php echo ($actividad['categoria'] ?? '') == 'cultural' ? 'selected' : ''; ?>>Cultural</option>
                <option value="aventura" <?php echo ($actividad['categoria'] ?? '') == 'aventura' ? 'selected' : ''; ?>>Aventura</option>
                <option value="comunidad" <?php echo ($actividad['categoria'] ?? '') == 'comunidad' ? 'selected' : ''; ?>>Comunidad</option>
                <option value="naturaleza" <?php echo ($actividad['categoria'] ?? '') == 'naturaleza' ? 'selected' : ''; ?>>Naturaleza</option>
            </select>
        </div>

        <div class="form-group">
            <label for="duracion">Duración (e.g., '4 horas')</label>
            <input type="text" id="duracion" name="duracion" value="<?php echo htmlspecialchars($actividad['duracion'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="dificultad">Dificultad</label>
            <input type="text" id="dificultad" name="dificultad" value="<?php echo htmlspecialchars($actividad['dificultad'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="impacto">Impacto</label>
            <select id="impacto" name="impacto" required>
                <option value="Bajo" <?php echo ($actividad['impacto'] ?? '') == 'Bajo' ? 'selected' : ''; ?>>Bajo</option>
                <option value="Medio" <?php echo ($actividad['impacto'] ?? '') == 'Medio' ? 'selected' : ''; ?>>Medio</option>
                <option value="Alto" <?php echo ($actividad['impacto'] ?? '') == 'Alto' ? 'selected' : ''; ?>>Alto</option>
            </select>
        </div>

        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" id="precio" name="precio" value="<?php echo htmlspecialchars($actividad['precio'] ?? '0.00'); ?>" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?php echo $es_edicion ? 'Guardar Cambios' : 'Crear Actividad'; ?></button>
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>
