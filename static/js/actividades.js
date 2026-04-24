// ===== SISTEMA DE ACTIVIDADES =====

// Variables globales
let filtrosActivos = {
    categoria: 'all',
    dificultad: 'all',
    duracion: 'all',
    destacado: false
};

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar filtros
    configurarFiltros();
    
    // Aplicar filtros iniciales
    aplicarFiltros();

    console.log('Sistema de actividades inicializado');
});

function configurarFiltros() {
    const filtroCategoria = document.getElementById('filtro-categoria');
    const filtroDificultad = document.getElementById('filtro-dificultad');
    const filtroDuracion = document.getElementById('filtro-duracion');
    const filtroDestacado = document.getElementById('filtro-destacado');

    if (filtroCategoria) {
        filtroCategoria.addEventListener('change', function() {
            filtrosActivos.categoria = this.value;
            aplicarFiltros();
        });
    }
    
    if (filtroDificultad) {
        filtroDificultad.addEventListener('change', function() {
            filtrosActivos.dificultad = this.value;
            aplicarFiltros();
        });
    }
    
    if (filtroDuracion) {
        filtroDuracion.addEventListener('change', function() {
            filtrosActivos.duracion = this.value;
            aplicarFiltros();
        });
    }
    
    if (filtroDestacado) {
        filtroDestacado.addEventListener('change', function() {
            filtrosActivos.destacado = this.checked;
            aplicarFiltros();
        });
    }
}

function aplicarFiltros() {
    const activityCards = document.querySelectorAll('.destination-card');
    const actividadesContainer = document.getElementById('actividades-container');
    let visibleCount = 0;

    activityCards.forEach(card => {
        const cardCategoria = card.dataset.categoria;
        const cardDificultad = card.dataset.dificultad;
        const cardDuracion = parseInt(card.dataset.duracion);
        const cardDestacado = card.dataset.destacado === '1';

        let mostrar = true;

        // Filtro por categoria
        if (filtrosActivos.categoria !== 'all' && cardCategoria !== filtrosActivos.categoria) {
            mostrar = false;
        }

        // Filtro por dificultad
        if (filtrosActivos.dificultad !== 'all' && cardDificultad !== filtrosActivos.dificultad.toLowerCase()) {
            mostrar = false;
        }

        // Filtro por duracion
        if (filtrosActivos.duracion !== 'all') {
            if (filtrosActivos.duracion === 'corta' && cardDuracion >= 4) {
                mostrar = false;
            } else if (filtrosActivos.duracion === 'media' && (cardDuracion < 4 || cardDuracion > 8)) {
                mostrar = false;
            } else if (filtrosActivos.duracion === 'larga' && cardDuracion <= 8) {
                mostrar = false;
            }
        }

        // Filtro por destacado
        if (filtrosActivos.destacado && !cardDestacado) {
            mostrar = false;
        }

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
                    <h3>No se encontraron actividades</h3>
                    <p>Intenta ajustar los filtros para ver más opciones</p>
                </div>
            `;
            actividadesContainer.innerHTML = noResultsHTML;
        }
    } else if (noResults) {
        noResults.remove();
        // Re-renderizar los destinos si se eliminó el mensaje de no resultados
        // (Esto es necesario si el mensaje de no resultados reemplazó el contenido del contenedor)
        // En este caso, como el PHP ya renderiza los destinos, solo necesitamos asegurarnos de que estén visibles
        activityCards.forEach(card => {
            if (card.style.display === 'none') {
                card.style.display = 'block'; // Make sure all previously hidden cards are shown if filters are cleared
            }
        });
    }
}
