// ===== SISTEMA DE RESERVAS =====

// Variables globales
let pasoActual = 1;

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar navegación entre pasos
    configurarNavegacion();
    
    // Configurar eventos de los métodos de pago
    configurarMetodosPago();
    
    // Configurar formularios
    configurarFormularios();
    
    // Actualizar número de reserva aleatorio
    actualizarNumeroReserva();
    
    console.log('Sistema de reservas inicializado');
});

function configurarNavegacion() {
    // Botón anterior del paso 2 (ahora paso 1)
    const anteriorPaso2 = document.getElementById('anterior-paso-2');
    if (anteriorPaso2) {
        anteriorPaso2.addEventListener('click', function() {
            // Opcional: redirigir a la página de inicio o a la de destinos
            window.location.href = 'index.php';
        });
    }
    
    // Botón anterior del paso 3 (ahora paso 2)
    const anteriorPaso3 = document.getElementById('anterior-paso-3');
    if (anteriorPaso3) {
        anteriorPaso3.addEventListener('click', function() {
            navegarAPaso(1);
        });
    }
}

function configurarMetodosPago() {
    const metodosPago = document.querySelectorAll('.metodo-pago');
    
    metodosPago.forEach(metodo => {
        metodo.addEventListener('click', function() {
            // Remover clase activa de todos los métodos
            metodosPago.forEach(m => m.classList.remove('activo'));
            
            // Agregar clase activa al método seleccionado
            this.classList.add('activo');
            
            // Mostrar formulario correspondiente
            const metodoSeleccionado = this.getAttribute('data-metodo');
            mostrarFormularioPago(metodoSeleccionado);
        });
    });
}

function configurarFormularios() {
    // Formulario de datos personales
    const formDatosPersonales = document.getElementById('form-datos-personales');
    if (formDatosPersonales) {
        formDatosPersonales.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if (validarFormularioDatos()) {
                navegarAPaso(2);
            }
        });
    }
    
    // Formulario de pago
    const formPagoTarjeta = document.getElementById('form-pago-tarjeta');
    if (formPagoTarjeta) {
        formPagoTarjeta.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if (validarFormularioPago()) {
                // Simular procesamiento de pago
                simularProcesamientoPago();
            }
        });
    }
}

function mostrarFormularioPago(metodo) {
    // Ocultar todos los formularios de pago
    const formulariosPago = document.querySelectorAll('.form-pago');
    formulariosPago.forEach(form => form.style.display = 'none');
    
    // Mostrar formulario seleccionado
    const formularioSeleccionado = document.getElementById(`form-pago-${metodo}`);
    if (formularioSeleccionado) {
        formularioSeleccionado.style.display = 'block';
    }
}

function validarFormularioDatos() {
    const nombre = document.getElementById('nombre')?.value.trim();
    const email = document.getElementById('email')?.value.trim();
    const telefono = document.getElementById('telefono')?.value.trim();
    const pais = document.getElementById('pais')?.value;
    
    if (!nombre) {
        InkaToursApp.mostrarNotificacion('Por favor, ingresa tu nombre completo.', 'error');
        return false;
    }
    
    if (!email || !validarEmail(email)) {
        InkaToursApp.mostrarNotificacion('Por favor, ingresa un email válido.', 'error');
        return false;
    }
    
    if (!telefono) {
        InkaToursApp.mostrarNotificacion('Por favor, ingresa tu número de teléfono.', 'error');
        return false;
    }
    
    if (!pais) {
        InkaToursApp.mostrarNotificacion('Por favor, selecciona tu país.', 'error');
        return false;
    }
    
    return true;
}

function validarFormularioPago() {
    // En una implementación real, aquí se validarían los datos de la tarjeta
    // Por simplicidad, asumimos que son válidos
    return true;
}

function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function navegarAPaso(paso) {
    // Ocultar paso actual
    const pasoActualElement = document.getElementById(`paso-${pasoActual}`);
    const pasoIndicadorActual = document.querySelector(`.paso[data-paso="${pasoActual}"]`);
    
    if (pasoActualElement) pasoActualElement.classList.remove('activo');
    if (pasoIndicadorActual) pasoIndicadorActual.classList.remove('activo');
    
    // Mostrar nuevo paso
    const nuevoPasoElement = document.getElementById(`paso-${paso}`);
    const nuevoPasoIndicador = document.querySelector(`.paso[data-paso="${paso}"]`);
    
    if (nuevoPasoElement) nuevoPasoElement.classList.add('activo');
    if (nuevoPasoIndicador) nuevoPasoIndicador.classList.add('activo');
    
    // Actualizar paso actual
    pasoActual = paso;
}

async function simularProcesamientoPago() {
    const botonPagar = document.querySelector('#form-pago-tarjeta button[type="submit"]');
    if (!botonPagar) return;

    // 1. UI: Estado de carga
    const textoOriginal = botonPagar.textContent;
    botonPagar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando pago...';
    botonPagar.disabled = true;

    // Simulación de la llamada al backend
    setTimeout(() => {
        // Navegar al paso de confirmación
        navegarAPaso(3);
        InkaToursApp.mostrarNotificacion('¡Reserva confirmada exitosamente!', 'success');
    }, 2000);
}

function actualizarNumeroReserva() {
    // Generar número de reserva aleatorio
    const numero = 'INK-' + Math.floor(Math.random() * 10000).toString().padStart(4, '0');
    const elementoNumero = document.getElementById('numero-reserva');
    if (elementoNumero) {
        elementoNumero.textContent = numero;
    }
}

// Hacer funciones disponibles globalmente
window.navegarAPaso = navegarAPaso;
window.actualizarNumeroReserva = actualizarNumeroReserva;