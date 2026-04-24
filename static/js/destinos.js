// ===== SISTEMA DE DESTINOS =====

// Variables globales
let filtrosActivos = {
    tipo: 'all',
    dificultad: 'all',
    distancia: 'all',
    sostenible: true
};

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar filtros
    configurarFiltros();
    
    // Aplicar filtros iniciales
    aplicarFiltros();
    
    // Configurar eventos de los destinos (solo para "Agregar al carrito")
    configurarEventosDestinos();

    console.log('Sistema de destinos inicializado');
});

function configurarFiltros() {
    const filtroTipo = document.getElementById('filtro-tipo');
    const filtroDificultad = document.getElementById('filtro-dificultad');
    const filtroDistancia = document.getElementById('filtro-distancia');
    const filtroSostenible = document.getElementById('filtro-sostenible');

    if (filtroTipo) {
        filtroTipo.addEventListener('change', function() {
            filtrosActivos.tipo = this.value;
            aplicarFiltros();
        });
    }
    
    if (filtroDificultad) {
        filtroDificultad.addEventListener('change', function() {
            filtrosActivos.dificultad = this.value;
            aplicarFiltros();
        });
    }
    
    if (filtroDistancia) {
        filtroDistancia.addEventListener('change', function() {
            filtrosActivos.distancia = this.value;
            aplicarFiltros();
        });
    }
    
    if (filtroSostenible) {
        filtroSostenible.addEventListener('change', function() {
            filtrosActivos.sostenible = this.checked;
            aplicarFiltros();
        });
    }
}

function aplicarFiltros() {
    const destinationCards = document.querySelectorAll('.destination-card');
    const destinosContainer = document.getElementById('destinos-container');
    let visibleCount = 0;

    destinationCards.forEach(card => {
        const cardTipo = card.dataset.tipo;
        const cardDificultad = card.dataset.dificultad;
        const cardDistancia = parseFloat(card.dataset.distancia);
        // const cardSostenible = card.dataset.sostenible === '1'; // Assuming a data-sostenible attribute

        let mostrar = true;

        // Filtro por tipo
        if (filtrosActivos.tipo !== 'all' && cardTipo !== filtrosActivos.tipo) {
            mostrar = false;
        }

        // Filtro por dificultad
        if (filtrosActivos.dificultad !== 'all' && cardDificultad !== filtrosActivos.dificultad) {
            mostrar = false;
        }

        // Filtro por distancia
        if (filtrosActivos.distancia !== 'all') {
            if (filtrosActivos.distancia === 'cercano' && cardDistancia >= 50) {
                mostrar = false;
            } else if (filtrosActivos.distancia === 'medio' && (cardDistancia < 50 || cardDistancia > 100)) {
                mostrar = false;
            } else if (filtrosActivos.distancia === 'lejano' && cardDistancia <= 100) {
                mostrar = false;
            }
        }

        // Filtro por sostenibilidad (assuming a data-sostenible attribute on the card)
        // if (filtrosActivos.sostenible && !cardSostenible) {
        //     mostrar = false;
        // }

        if (mostrar) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Mostrar mensaje si no hay resultados
    let noResults = document.querySelector('.no-results');
    if (visibleCount === 0) {
        if (!noResults) {
            const noResultsHTML = `
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>No se encontraron destinos</h3>
                    <p>Intenta ajustar los filtros para ver más opciones</p>
                </div>
            `;
            destinosContainer.innerHTML = noResultsHTML;
        }
    } else if (noResults) {
        noResults.remove();
        // Re-renderizar los destinos si se eliminó el mensaje de no resultados
        // (Esto es necesario si el mensaje de no resultados reemplazó el contenido del contenedor)
        // En este caso, como el PHP ya renderiza los destinos, solo necesitamos asegurarnos de que estén visibles
        destinationCards.forEach(card => {
            if (card.style.display === 'none') {
                card.style.display = 'block'; // Make sure all previously hidden cards are shown if filters are cleared
            }
        });
    }
}

function configurarEventosDestinos() {
    // Botones "Agregar al carrito"
    document.querySelectorAll('.agregar-carrito').forEach(btn => {
        btn.addEventListener('click', function() {
            const destinoId = parseInt(this.getAttribute('data-id'));
            // You would need to fetch the destination data from somewhere,
            // as destinosData is no longer available.
            // For now, this part will not work as expected without a backend call or data source.
            console.log('Agregar al carrito - Destino ID:', destinoId);
            // Example: Call a function to add to cart, potentially fetching details via AJAX
            // agregarDestinoAlCarrito(destinoId); 
        });
    });
}

// ===== FUNCIONALIDAD DE CARRITO PARA DESTINOS (simplified as data is not available in JS) =====

function agregarDestinoAlCarrito(destinoId) {
    // In a real application, you would likely send an AJAX request to a backend endpoint
    // to add the item to the cart, as the full destino object is not available in JS anymore.
    console.log(`Destino con ID ${destinoId} agregado al carrito (simulado).`);
    mostrarNotificacionFallback(`Destino ID ${destinoId} agregado al carrito`);
}

function mostrarNotificacionFallback(mensaje) {
    const notificacion = document.createElement('div');
    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--primary, #2A9D8F);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInRight 0.3s ease;
    `;
    notificacion.textContent = mensaje;
    
    document.body.appendChild(notificacion);
    
    setTimeout(() => {
        notificacion.remove();
    }, 3000);
}

function actualizarContadorCarritoFallback() {
    // This function would need to be updated to reflect actual cart contents,
    // possibly by fetching from localStorage or a backend.
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        // For now, just hide it or set to 0 as we don't have real data
        cartCount.textContent = '0';
        cartCount.style.display = 'none';
    }
}

function mostrarNotificacion(mensaje, tipo = 'info') {
    if (typeof MultiIdioma !== 'undefined' && MultiIdioma.mostrarNotificacion) {
        MultiIdioma.mostrarNotificacion(mensaje, tipo);
    } else if (typeof InkaToursApp !== 'undefined' && InkaToursApp.mostrarNotificacion) {
        InkaToursApp.mostrarNotificacion(mensaje, tipo);
    } else {
        alert(mensaje);
    }
}

// Inicializar contador del carrito al cargar
document.addEventListener('DOMContentLoaded', function() {
    if (typeof InkaToursApp === 'undefined') {
        actualizarContadorCarritoFallback();
    }
});

// Hacer funciones disponibles globalmente
window.aplicarFiltros = aplicarFiltros;
window.agregarDestinoAlCarrito = agregarDestinoAlCarrito;
