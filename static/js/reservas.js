document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reserva-form');
    if (!form) return;

    // --- CONFIGURACIÓN ---
    const DISCOUNTS = {
        local: 0.20,      // 20% de descuento
        nacional: 0.10,   // 10% de descuento
        extranjero: 0.0   //  0% de descuento
    };

    // --- NAVEGACIÓN DE PASOS ---
    const pasos = document.querySelectorAll('.paso');
    const contenidosPasos = document.querySelectorAll('.paso-contenido');
    const botonesSiguiente = document.querySelectorAll('.btn-continuar');
    const botonesAtras = document.querySelectorAll('.btn-atras');
    let pasoActual = 1;

    const navegarA = (numeroPaso) => {
        contenidosPasos.forEach(c => c.classList.remove('activo'));
        pasos.forEach(p => p.classList.remove('activo'));
        document.getElementById(`contenido-paso-${numeroPaso}`).classList.add('activo');
        document.getElementById(`paso-${numeroPaso}`).classList.add('activo');
        pasoActual = numeroPaso;
        window.scrollTo(0, 0);
    };

    const validarPaso = (numeroPaso) => {
        const contenido = document.getElementById(`contenido-paso-${numeroPaso}`);
        const inputs = contenido.querySelectorAll('input[required], select[required]');
        let esValido = true;
        inputs.forEach(input => {
            if (!input.value || (input.type === 'number' && input.value < 1)) {
                esValido = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = '';
            }
        });
        return esValido;
    };

    botonesSiguiente.forEach(boton => {
        boton.addEventListener('click', () => {
            if (validarPaso(pasoActual)) {
                const siguientePaso = parseInt(boton.dataset.siguientePaso);
                if (siguientePaso === 4) {
                    actualizarResumen();
                }
                navegarA(siguientePaso);
            }
        });
    });

    botonesAtras.forEach(boton => {
        boton.addEventListener('click', () => {
            const pasoAnterior = parseInt(boton.dataset.pasoAnterior);
            navegarA(pasoAnterior);
        });
    });

    // --- LÓGICA DE PRECIOS Y PARTICIPANTES ---
    const precioUnitarioInput = document.getElementById('precio_unitario');
    const participantesInput = document.getElementById('participantes');
    const totalEstimadoSpan = document.getElementById('total-estimado');
    const detallesContainer = document.getElementById('participantes-detalles-container');

    const actualizarTotal = () => {
        const precioUnitario = parseFloat(precioUnitarioInput.value);
        if (isNaN(precioUnitario)) return;

        const tipoParticipanteSelects = detallesContainer.querySelectorAll('select[name="participantes_tipos[]"]');
        let totalCalculado = 0;

        tipoParticipanteSelects.forEach(select => {
            const tipo = select.value;
            const descuento = DISCOUNTS[tipo] || 0;
            totalCalculado += precioUnitario * (1 - descuento);
        });
        
        totalEstimadoSpan.textContent = `$${totalCalculado.toFixed(0)}`;
    };

    const generarCamposParticipantes = (num) => {
        detallesContainer.innerHTML = ''; // Limpiar campos previos
        if (num > 0 && num <= 20) {
            let fieldsHTML = '<div class="form-group-title"><h4>Detalles de los Participantes</h4><p>Se aplicará un 20% de descuento para locales y 10% para nacionales.</p></div>';
            for (let i = 1; i <= num; i++) {
                fieldsHTML += `
                    <div class="form-group">
                        <label for="participante_nombre_${i}">Nombre Completo (Participante ${i})*</label>
                        <input type="text" id="participante_nombre_${i}" name="participantes_nombres[]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="participante_tipo_${i}">Tipo de Turista (Participante ${i})*</label>
                        <select id="participante_tipo_${i}" name="participantes_tipos[]" class="form-control custom-select" style="width: 250px;" required>
                            <option value="extranjero" data-discount="${DISCOUNTS.extranjero}">Extranjero (Precio normal)</option>
                            <option value="nacional" data-discount="${DISCOUNTS.nacional}" selected>Nacional (10% Dcto.)</option>
                            <option value="local" data-discount="${DISCOUNTS.local}">Local (20% Dcto.)</option>
                        </select>
                    </div>
                `;
            }
            detallesContainer.innerHTML = fieldsHTML;
        }
        actualizarTotal(); // Actualizar total después de generar los campos
    };
    
    if (participantesInput && detallesContainer && precioUnitarioInput) {
        // Generar campos iniciales y calcular total
        generarCamposParticipantes(parseInt(participantesInput.value));

        // Listener para cambios en el número de participantes
        participantesInput.addEventListener('input', () => {
            let num = parseInt(participantesInput.value);
            if (isNaN(num) || num < 1) { num = 1; participantesInput.value = 1; }
            if (num > 20) { num = 20; participantesInput.value = 20; }
            generarCamposParticipantes(num);
        });

        // Listener para cambios en el tipo de turista (usando delegación de eventos)
        detallesContainer.addEventListener('change', (e) => {
            if (e.target && e.target.matches('select[name="participantes_tipos[]"]')) {
                actualizarTotal();
            }
        });
    }

    // --- RESUMEN FINAL ---
    const actualizarResumen = () => {
        document.getElementById('resumen-fecha').textContent = document.getElementById('fecha_experiencia').value;
        document.getElementById('resumen-participantes').textContent = document.getElementById('participantes').value;
        document.getElementById('resumen-nombre').textContent = document.getElementById('nombre_completo').value;
        document.getElementById('resumen-email').textContent = document.getElementById('email').value;
        document.getElementById('resumen-total').textContent = document.getElementById('total-estimado').textContent;
    };
    
    // --- ESTILOS DINÁMICOS ---
    const style = document.createElement('style');
    style.innerHTML = `
        .form-group-title {
            grid-column: 1 / -1;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 10px;
        }
        .form-group-title h4 { margin: 0 0 5px 0; font-size: 1.2em; color: #333; }
        .form-group-title p { margin: 0; font-size: 0.9em; color: #666; }
    `;
    document.head.appendChild(style);
});

