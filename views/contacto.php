<?php require_once 'partials/header.php'; ?>

    <section class="page-hero">
        <div class="container">
            <h1>Contáctanos</h1>
            <p>Estamos aquí para ayudarte a planificar tu viaje sostenible perfecto</p>
        </div>
    </section>

    <section class="contacto-contenido">
        <div class="container">
            <div class="contacto-grid">
                <div class="contacto-info">
                    <h2>Información de Contacto</h2>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3>Dirección</h3>
                            <p>Plaza de Armas, Cusco, Perú</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3>Teléfono</h3>
                            <p>+51 984 123 456</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3>Email</h3>
                            <p>info@inkatours.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3>Horario de Atención</h3>
                            <p>Lunes a Viernes: 8:00 - 18:00<br>Sábados: 9:00 - 14:00</p>
                        </div>
                    </div>
                    
                    <div class="mapa-contacto">
                        <h3>Ubícanos</h3>
                        <div class="mapa-miniatura">
                            <!-- Mapa estático como placeholder -->
                            <div style="background: #e9ecef; height: 200px; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; color: var(--gray);">
                                <i class="fas fa-map" style="font-size: 2rem; margin-right: 1rem;"></i>
                                <span>Mapa interactivo de Cusco</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contacto-formulario">
                    <h2>Envíanos un Mensaje</h2>
                    <?php if ($data['success']): ?>
                        <div class="alert alert-success">¡Mensaje enviado con éxito! Te responderemos pronto.</div>
                    <?php else: ?>
                        <form action="/Inkatours/contacto" method="post">
                            <div class="form-group">
                                <label for="nombre">Nombre completo *</label>
                                <input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nombre']; ?>">
                                <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="<?php echo $data['telefono']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="asunto">Asunto *</label>
                                <select name="asunto" class="form-control <?php echo (!empty($data['asunto_err'])) ? 'is-invalid' : ''; ?>">
                                    <option value="">Selecciona un asunto</option>
                                    <option value="reserva" <?php echo ($data['asunto'] == 'reserva') ? 'selected' : ''; ?>>Consulta sobre reservas</option>
                                    <option value="info" <?php echo ($data['asunto'] == 'info') ? 'selected' : ''; ?>>Información general</option>
                                    <option value="sostenibilidad" <?php echo ($data['asunto'] == 'sostenibilidad') ? 'selected' : ''; ?>>Consultas sobre sostenibilidad</option>
                                    <option value="grupos" <?php echo ($data['asunto'] == 'grupos') ? 'selected' : ''; ?>>Viajes en grupo</option>
                                    <option value="otro" <?php echo ($data['asunto'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
                                </select>
                                <span class="invalid-feedback"><?php echo $data['asunto_err']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="mensaje">Mensaje *</label>
                                <textarea name="mensaje" rows="5" class="form-control <?php echo (!empty($data['mensaje_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['mensaje']; ?></textarea>
                                <span class="invalid-feedback"><?php echo $data['mensaje_err']; ?></span>
                            </div>
                            <button type="submit" class="btn-primary">Enviar Mensaje</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php require_once 'partials/footer.php'; ?>