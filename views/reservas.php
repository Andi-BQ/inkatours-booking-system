<?php require_once 'partials/header.php'; ?>

<main id="main-content">
    <section class="page-hero" aria-labelledby="page-title">
        <div class="container">
            <h1 id="page-title">Confirmar tu Reserva</h1>
            <p>Completa tu reserva de forma sencilla y segura.</p>
        </div>
    </section>

    <section class="reservation-process" aria-labelledby="reservation-process-title">
        <div class="container">
            <?php if (isset($data['item'])): ?>
                <!-- Indicador de Pasos Mejorado -->
                <div class="pasos-reserva" role="tablist" aria-label="Pasos del proceso de reserva">
                    <div class="paso activo" id="paso-1" role="tab" aria-selected="true" aria-controls="contenido-paso-1">
                        <span>1</span>
                        <div class="paso-label">Detalles</div>
                    </div>
                    <div class="paso" id="paso-2" role="tab" aria-selected="false" aria-controls="contenido-paso-2" tabindex="-1">
                        <span>2</span>
                        <div class="paso-label">Tus Datos</div>
                    </div>
                    <div class="paso" id="paso-3" role="tab" aria-selected="false" aria-controls="contenido-paso-3" tabindex="-1">
                        <span>3</span>
                        <div class="paso-label">Pago</div>
                    </div>
                </div>

                <!-- Formulario de Reserva -->
                <form id="reserva-form" action="/Inkatours/reservas/guardar" method="post" novalidate>
                    <input type="hidden" name="tipo" value="<?php echo htmlspecialchars($data['tipo']); ?>">
                    <input type="hidden" name="elemento_id" value="<?php echo htmlspecialchars($data['item']->id); ?>">
                    <input type="hidden" name="precio_unitario" id="precio_unitario" value="<?php echo htmlspecialchars($data['item']->precio_base ?? $data['item']->precio); ?>">

                    <!-- Paso 1: Detalles -->
                    <div class="paso-contenido activo" id="contenido-paso-1" role="tabpanel" aria-labelledby="paso-1">
                        <h2><i class="fas fa-calendar-alt"></i> <span>1. Detalles de la Reserva</span></h2>
                        <div class="carrito-item">
                            <div class="carrito-info">
                                <h3><?php echo htmlspecialchars($data['item']->nombre); ?></h3>
                                <p><?php echo htmlspecialchars($data['item']->descripcion_corta); ?></p>
                            </div>
                            <div class="carrito-precio">
                                <div class="precio-total" id="precio-display">$<?php echo htmlspecialchars($data['item']->precio_base ?? $data['item']->precio); ?></div>
                                <div class="precio-persona">por persona</div>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="fecha_experiencia">Fecha de la Experiencia <span class="required">*</span></label>
                                <input type="date" id="fecha_experiencia" name="fecha_experiencia" class="form-control" required>
                                <div class="error-message" id="fecha-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="participantes">Número de Participantes <span class="required">*</span></label>
                                <input type="number" id="participantes" name="participantes" class="form-control" value="1" min="1" max="15" required>
                                <div class="error-message" id="participantes-error"></div>
                            </div>
                        </div>
                        <div id="participantes-detalles-container" class="form-grid" style="margin-top: 25px;"></div>
                        <div class="reserva-total" aria-live="polite">Total Estimado: <span id="total-estimado"></span></div>
                        <div class="reserva-acciones">
                            <button type="button" class="btn-continuar" data-siguiente-paso="2">Siguiente <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <!-- Paso 2: Tus Datos -->
                    <div class="paso-contenido" id="contenido-paso-2" role="tabpanel" aria-labelledby="paso-2" hidden>
                        <h2><i class="fas fa-user"></i> <span>2. Tus Datos Personales</span></h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="nombre_completo">Nombre Completo <span class="required">*</span></label>
                                <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" value="<?php echo htmlspecialchars($data['usuario']['nombre'] ?? ''); ?>" required>
                                <div class="error-message" id="nombre-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico <span class="required">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($data['usuario']['email'] ?? ''); ?>" required>
                                <div class="error-message" id="email-error"></div>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono de Contacto</label>
                                <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($data['usuario']['telefono'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="reserva-acciones">
                            <button type="button" class="btn-atras" data-paso-anterior="1"><i class="fas fa-arrow-left"></i> Atrás</button>
                            <button type="button" class="btn-continuar" data-siguiente-paso="3">Siguiente <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <!-- Paso 3: Pago -->
                    <div class="paso-contenido" id="contenido-paso-3" role="tabpanel" aria-labelledby="paso-3" hidden>
                        <h2><i class="fas fa-credit-card"></i> <span>3. Confirmar y Pagar</span></h2>
                        <div class="resumen-reserva">
                            <h3>Resumen de tu Aventura</h3>
                            <div class="resumen-grid">
                                <p><strong><i class="fas fa-map-marked-alt"></i> Experiencia:</strong> <?php echo htmlspecialchars($data['item']->nombre); ?></p>
                                <p><strong><i class="fas fa-calendar-day"></i> Fecha:</strong> <span id="resumen-fecha"></span></p>
                                <p><strong><i class="fas fa-users"></i> Participantes:</strong> <span id="resumen-participantes"></span></p>
                            </div>
                            <div class="resumen-total">
                                <p>Pago Inicial (50%): <span id="resumen-total"></span></p>
                                <p class="small-text">* El 50% restante se pagará el día de la experiencia</p>
                            </div>
                            <hr>
                            <div class="payment-info">
                                <h4><i class="fas fa-lock"></i> Pago Seguro</h4>
                                <p>Serás redirigido a nuestra pasarela de pago segura (Stripe) para completar la transacción.</p>
                            </div>
                        </div>
                        <div class="reserva-acciones">
                            <button type="button" class="btn-atras" data-paso-anterior="2"><i class="fas fa-arrow-left"></i> Atrás</button>
                            <button type="submit" class="btn-continuar" id="btn-confirmar-pago"><i class="fas fa-lock"></i> Confirmar y Proceder al Pago</button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <p>No se ha seleccionado ningún ítem para reservar.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reserva-form');
    if (!form) return;

    const DISCOUNTS = { local: 0.20, nacional: 0.10, extranjero: 0.0 };
    const precioUnitario = parseFloat(document.getElementById('precio_unitario').value);
    
    const participantesInput = document.getElementById('participantes');
    const totalEstimadoSpan = document.getElementById('total-estimado');
    const detallesContainer = document.getElementById('participantes-detalles-container');
    
    let pasoActual = 1;
    const allSteps = Array.from(document.querySelectorAll('.paso'));
    const allContents = Array.from(document.querySelectorAll('.paso-contenido'));
    
    function goToStep(stepNumber) {
        if (stepNumber > pasoActual && !validarPaso(pasoActual)) return;

        pasoActual = stepNumber;
        allContents.forEach((content, index) => content.classList.toggle('activo', (index + 1) === stepNumber));
        allSteps.forEach((step, index) => {
            step.classList.remove('activo', 'completed');
            if ((index + 1) < stepNumber) step.classList.add('completed');
            if ((index + 1) === stepNumber) step.classList.add('activo');
        });
        
        if (stepNumber === 3) actualizarResumen();
        window.scrollTo(0, 0);
    }

    function validarPaso(numeroPaso) {
        const contenido = document.getElementById(`contenido-paso-${numeroPaso}`);
        const inputs = contenido.querySelectorAll('input[required]');
        let esValido = true;
        inputs.forEach(input => {
            input.style.borderColor = '';
            if (!input.value.trim()) {
                esValido = false;
                input.style.borderColor = 'red';
            }
        });
        return esValido;
    }

    form.addEventListener('click', e => {
        if (e.target.matches('.btn-continuar')) goToStep(parseInt(e.target.dataset.siguientePaso));
        if (e.target.matches('.btn-atras')) goToStep(parseInt(e.target.dataset.pasoAnterior));
    });

    const actualizarTotal = () => {
        const tipoSelects = detallesContainer.querySelectorAll('select[name="participantes_tipos[]"]');
        let total = 0;
        tipoSelects.forEach(select => {
            total += precioUnitario * (1 - (DISCOUNTS[select.value] || 0));
        });
        totalEstimadoSpan.textContent = `$${total.toFixed(2)}`;
    };

    const generarCamposParticipantes = () => {
        const num = parseInt(participantesInput.value) || 0;
        detallesContainer.innerHTML = '';
        if (num > 0 && num <= 15) {
            let fieldsHTML = '<div class="form-group-title" style="grid-column: 1 / -1;"><h4>Detalles de los Participantes</h4></div>';
            for (let i = 1; i <= num; i++) {
                fieldsHTML += `
                    <div class="form-group">
                        <label for="participante_nombre_${i}">Nombre (Part. ${i})*</label>
                        <input type="text" name="participantes_nombres[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="participante_tipo_${i}">Tipo (Part. ${i})*</label>
                        <select name="participantes_tipos[]" class="form-control" required>
                            <option value="extranjero" selected>Extranjero</option>
                            <option value="nacional">Nacional (10% Dcto.)</option>
                            <option value="local">Local (20% Dcto.)</option>
                        </select>
                    </div>`;
            }
            detallesContainer.innerHTML = fieldsHTML;
        }
        actualizarTotal();
    };

    participantesInput.addEventListener('input', generarCamposParticipantes);
    detallesContainer.addEventListener('change', e => {
        if (e.target.matches('select')) actualizarTotal();
    });

    function actualizarResumen() {
        document.getElementById('resumen-fecha').textContent = document.getElementById('fecha_experiencia').value;
        document.getElementById('resumen-participantes').textContent = document.getElementById('participantes').value;
        const total = parseFloat(totalEstimadoSpan.textContent.replace('$', ''));
        document.getElementById('resumen-total').textContent = `$${(total / 2).toFixed(2)}`;
    }

    generarCamposParticipantes();
});
</script>

<?php require_once 'partials/footer.php'; ?>
