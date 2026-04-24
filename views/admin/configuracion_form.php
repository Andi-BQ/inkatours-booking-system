<?php require_once 'partials/header.php'; ?>

<div class="admin-header">
    <h1>Configuración de la Empresa</h1>
</div>

<div class="form-container">
    <form action="/Inkatours/admin/guardar_configuracion" method="POST">
        <div class="form-grid">
            <div class="form-group">
                <label for="empresa_nombre">Nombre de la Empresa</label>
                <input type="text" id="empresa_nombre" name="empresa_nombre" value="<?php echo htmlspecialchars($data['config']['empresa_nombre'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="email_contacto">Email de Contacto Principal</label>
                <input type="email" id="email_contacto" name="email_contacto" value="<?php echo htmlspecialchars($data['config']['email_contacto'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="telefono_contacto">Teléfono de Contacto</label>
                <input type="text" id="telefono_contacto" name="telefono_contacto" value="<?php echo htmlspecialchars($data['config']['telefono_contacto'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="direccion_contacto">Dirección Física</label>
                <input type="text" id="direccion_contacto" name="direccion_contacto" value="<?php echo htmlspecialchars($data['config']['direccion_contacto'] ?? ''); ?>">
            </div>
            <div class="form-group full-width">
                <label for="horario_atencion">Horario de Atención</label>
                <input type="text" id="horario_atencion" name="horario_atencion" value="<?php echo htmlspecialchars($data['config']['horario_atencion'] ?? ''); ?>">
            </div>
            <div class="form-group full-width">
                <label for="empresa_descripcion_corta">Descripción Corta (para el pie de página)</label>
                <textarea id="empresa_descripcion_corta" name="empresa_descripcion_corta"><?php echo htmlspecialchars($data['config']['empresa_descripcion_corta'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="social_facebook">URL de Facebook</label>
                <input type="url" id="social_facebook" name="social_facebook" value="<?php echo htmlspecialchars($data['config']['social_facebook'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="social_instagram">URL de Instagram</label>
                <input type="url" id="social_instagram" name="social_instagram" value="<?php echo htmlspecialchars($data['config']['social_instagram'] ?? ''); ?>">
            </div>
             <div class="form-group">
                <label for="social_twitter">URL de Twitter</label>
                <input type="url" id="social_twitter" name="social_twitter" value="<?php echo htmlspecialchars($data['config']['social_twitter'] ?? ''); ?>">
            </div>
             <div class="form-group">
                <label for="social_youtube">URL de Youtube</label>
                <input type="url" id="social_youtube" name="social_youtube" value="<?php echo htmlspecialchars($data['config']['social_youtube'] ?? ''); ?>">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<?php require_once 'partials/footer.php'; ?>
