<div class="profile-card">
    <h3><i class="fas fa-edit"></i> Editar Perfil</h3>

    <form action="/Inkatours/perfil/update" method="POST" class="edit-profile-form">
        <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user->nombre); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user->telefono); ?>">
        </div>
        <div class="form-group">
            <label for="pais">País</label>
            <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($user->pais); ?>">
        </div>
        <div class="form-group">
            <label for="password">Nueva Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirmar Nueva Contraseña</label>
            <input type="password" id="password_confirm" name="password_confirm">
        </div>
        <button type="submit" class="btn-primary">Guardar Cambios</button>
    </form>
</div>
<style>
    .edit-profile-form {
        margin-top: 2rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark);
    }
    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--light-gray);
        border-radius: var(--border-radius);
        transition: var(--transition);
    }
    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(42, 157, 143, 0.1);
    }
    .btn-primary {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        margin-top: 1rem;
    }
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: var(--border-radius);
    }
    .alert-success {
        background-color: var(--primary-light);
        color: var(--primary-dark);
        border: 1px solid var(--primary);
    }
    .alert-danger {
        background-color: var(--accent-light);
        color: var(--secondary-dark);
        border: 1px solid var(--secondary);
    }
</style>