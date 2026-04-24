// ===== SISTEMA DE CONTACTO =====

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar formulario de contacto
    configurarFormularioContacto();
    
    // Configurar validación en tiempo real
    configurarValidacionTiempoReal();
    
    console.log('Sistema de contacto inicializado');
});

function configurarFormularioContacto() {
    const formularioContacto = document.getElementById('form-contacto');
    
    if (formularioContacto) {
        formularioContacto.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if (validarFormularioContacto()) {
                // Enviar formulario
                enviarFormularioContacto();
            }
        });
    }
}

function configurarValidacionTiempoReal() {
    const campos = document.querySelectorAll('#form-contacto input, #form-contacto select, #form-contacto textarea');
    
    campos.forEach(campo => {
        campo.addEventListener('blur', function() {
            validarCampo(this);
        });
        
        campo.addEventListener('input', function() {
            limpiarError(this);
        });
    });
}

function validarFormularioContacto() {
    let esValido = true;
    
    const campos = [
        document.getElementById('nombre-contacto'),
        document.getElementById('email-contacto'),
        document.getElementById('asunto-contacto'),
        document.getElementById('mensaje-contacto')
    ];
    
    // Validar cada campo
    campos.forEach(campo => {
        if (!validarCampo(campo)) {
            esValido = false;
        }
    });
    
    return esValido;
}

function validarCampo(campo) {
    const valor = campo.value.trim();
    let esValido = true;
    let mensajeError = '';
    
    // Remover errores previos
    limpiarError(campo);
    
    // Validaciones específicas por tipo de campo
    switch(campo.type) {
        case 'email':
            if (!valor) {
                mensajeError = 'El email es obligatorio';
                esValido = false;
            } else if (!validarEmail(valor)) {
                mensajeError = 'Por favor ingresa un email válido';
                esValido = false;
            }
            break;
            
        case 'select-one':
            if (!valor) {
                mensajeError = 'Por favor selecciona un asunto';
                esValido = false;
            }
            break;
            
        default:
            if (!valor) {
                mensajeError = 'Este campo es obligatorio';
                esValido = false;
            } else if (campo.id === 'mensaje-contacto' && valor.length < 10) {
                mensajeError = 'El mensaje debe tener al menos 10 caracteres';
                esValido = false;
            }
    }
    
    // Mostrar error si es necesario
    if (!esValido) {
        mostrarError(campo, mensajeError);
    } else {
        mostrarExito(campo);
    }
    
    return esValido;
}

function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function mostrarError(campo, mensaje) {
    // Remover clases de éxito
    campo.classList.remove('valido');
    
    // Agregar clases de error
    campo.classList.add('error');
    
    // Crear o actualizar mensaje de error
    let mensajeError = campo.parentNode.querySelector('.mensaje-error');
    if (!mensajeError) {
        mensajeError = document.createElement('div');
        mensajeError.className = 'mensaje-error';
        campo.parentNode.appendChild(mensajeError);
    }
    
    mensajeError.textContent = mensaje;
    mensajeError.style.cssText = `
        color: #e74c3c;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    `;
}

function mostrarExito(campo) {
    // Remover clases de error
    campo.classList.remove('error');
    limpiarError(campo);
    
    // Agregar clases de éxito
    campo.classList.add('valido');
}

function limpiarError(campo) {
    campo.classList.remove('error');
    const mensajeError = campo.parentNode.querySelector('.mensaje-error');
    if (mensajeError) {
        mensajeError.remove();
    }
}

function enviarFormularioContacto() {
    const formulario = document.getElementById('form-contacto');
    const botonEnviar = formulario.querySelector('button[type="submit"]');
    
    // Mostrar estado de carga
    const textoOriginal = botonEnviar.textContent;
    botonEnviar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
    botonEnviar.disabled = true;
    
    // Simular envío (en una implementación real, aquí iría una petición AJAX)
    setTimeout(() => {
        // Mostrar mensaje de éxito
        mostrarNotificacion('¡Mensaje enviado exitosamente! Te contactaremos pronto.', 'success');
        
        // Restaurar botón
        botonEnviar.innerHTML = textoOriginal;
        botonEnviar.disabled = false;
        
        // Limpiar formulario
        formulario.reset();
        
        // Remover clases de validación
        const campos = formulario.querySelectorAll('input, select, textarea');
        campos.forEach(campo => {
            campo.classList.remove('valido');
        });
        
    }, 2000);
}

function mostrarNotificacion(mensaje, tipo = 'info') {
    // Usar MultiIdioma si está disponible, sino usar función local
    if (typeof MultiIdioma !== 'undefined' && MultiIdioma.mostrarNotificacion) {
        MultiIdioma.mostrarNotificacion(mensaje, tipo);
    } else if (typeof InkaToursApp !== 'undefined' && InkaToursApp.mostrarNotificacion) {
        InkaToursApp.mostrarNotificacion(mensaje, tipo);
    } else {
        // Implementación local básica
        alert(mensaje);
    }
}

// Agregar estilos para validación
if (!document.querySelector('style[data-validacion-contacto]')) {
    const style = document.createElement('style');
    style.setAttribute('data-validacion-contacto', 'true');
    style.textContent = `
        .contacto-formulario input.error,
        .contacto-formulario select.error,
        .contacto-formulario textarea.error {
            border-color: #e74c3c !important;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1) !important;
        }
        
        .contacto-formulario input.valido,
        .contacto-formulario select.valido,
        .contacto-formulario textarea.valido {
            border-color: #27ae60 !important;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1) !important;
        }
    `;
    document.head.appendChild(style);
}