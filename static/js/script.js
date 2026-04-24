// ===== MÓDULO PRINCIPAL DE LA APLICACIÓN =====
const InkaToursApp = (() => {
    let state = {
        user: null,
        cart: JSON.parse(localStorage.getItem('inkatours_cart')) || [],
        language: 'es'
    };

    const init = () => {
        // Inicializar sistemas
        initMultiIdioma();
        initEventListeners();
        initMapa();
        initGraficos();
        initFiltros();
        
        console.log('InkaTours App inicializada correctamente');
    };

    const initMultiIdioma = () => {
        // Inicializar sistema de idiomas si existe
        if (typeof MultiIdioma !== 'undefined') {
            MultiIdioma.init();
        }
    };

    const initEventListeners = () => {
        // Navegación móvil
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('nav-menu');
        
        if (hamburger && navMenu) {
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                hamburger.classList.toggle('active');
            });
        }

        // Botones de detalles de destinos
        const detailButtons = document.querySelectorAll('.btn-secondary');
        detailButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const card = e.target.closest('.destination-card');
                if (card) {
                    const title = card.querySelector('h3').textContent;
                    mostrarNotificacion(`Ver detalles de: ${title}`, 'info');
                }
            });
        });

        // Botón de búsqueda en hero
        const searchBtn = document.querySelector('.hero-search button');
        if (searchBtn) {
            searchBtn.addEventListener('click', handleBusqueda);
        }

        // Tabs de actividades
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const category = e.target.getAttribute('data-tab');
                filtrarActividades(category);
            });
        });

        // Selector de idioma
        const languageSelect = document.getElementById('language-select');
        if (languageSelect) {
            languageSelect.addEventListener('change', (e) => {
                if (typeof MultiIdioma !== 'undefined') {
                    MultiIdioma.cambiarIdioma(e.target.value);
                }
            });
        }

        // User dropdown toggle
        const userInfo = document.querySelector('.user-info');
        const userDropdown = document.querySelector('.user-dropdown');

        if (userInfo && userDropdown) {
            userInfo.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent click from immediately closing the dropdown
                userDropdown.classList.toggle('show');
            });

            // Close dropdown if clicked outside
            window.addEventListener('click', (e) => {
                if (!userInfo.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });
        }
    };

    const initMapa = () => {
        const mapElement = document.getElementById('map');
        if (!mapElement) return;

        try {
            // Coordenadas de Cusco
            const cusco = [-13.53195, -71.96746];
            
            // Crear mapa
            const map = L.map('map').setView(cusco, 10);
            
            // Añadir capa de mapa
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            
            
            // Añadir marcadores para destinos y actividades
            if (typeof locations !== 'undefined' && locations) {
                locations.forEach(location => {
                    const esDestino = location.tipo === 'destino';
                    const iconHtml = esDestino 
                        ? '<i class="fas fa-map-marker-alt"></i>' 
                        : '<i class="fas fa-hiking"></i>';
                    
                    const color = esDestino ? '#007bff' : '#28a745';

                    const iconoPersonalizado = L.divIcon({
                        html: `<div style="background-color: ${color}; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-size: 15px; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">
                                ${iconHtml}
                               </div>`,
                        className: 'marker-personalizado',
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    });

                    const url = esDestino
                        ? `/Inkatours/destinos/show/${location.id}`
                        : `/Inkatours/actividades/show/${location.id}`;

                    const popupContent = `
                        <div class="map-popup">
                            <h3>${location.nombre}</h3>
                            <p>${location.descripcion_corta}</p>
                            <a href="${url}" class="btn-primary btn-sm">Ver detalles</a>
                        </div>`;

                    L.marker([location.lng, location.lat], { icon: iconoPersonalizado })
                        .addTo(map)
                        .bindPopup(popupContent);
                });
            }
            
        } catch (error) {
            console.error('Error al inicializar el mapa:', error);
        }
    };

    const initGraficos = () => {
        const chartElement = document.getElementById('crowdChart');
        if (!chartElement) return;

        try {
            const ctx = chartElement.getContext('2d');
            
            // Datos de ejemplo para la predicción de afluencia
            const crowdChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    datasets: [
                        {
                            label: 'Machu Picchu',
                            data: [85, 78, 92, 88, 95, 98, 90],
                            borderColor: '#f44336',
                            backgroundColor: 'rgba(244, 67, 54, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Valle Sagrado',
                            data: [65, 70, 68, 72, 75, 80, 78],
                            borderColor: '#ff9800',
                            backgroundColor: 'rgba(255, 152, 0, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Montaña 7 Colores',
                            data: [45, 50, 55, 60, 65, 75, 70],
                            borderColor: '#4caf50',
                            backgroundColor: 'rgba(76, 175, 80, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Afluencia (%)'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Predicción de Afluencia - Próxima Semana'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error al inicializar gráficos:', error);
        }
    };

    const initFiltros = () => {
        // Filtros de actividades
        const filterOptions = document.querySelectorAll('.filter-options input');
        filterOptions.forEach(option => {
            option.addEventListener('change', filtrarMapa);
        });
    };

    const handleBusqueda = () => {
        const searchTerm = document.querySelector('.hero-search input')?.value;
        if (searchTerm && searchTerm.trim()) {
            mostrarNotificacion(`Buscando: ${searchTerm}`, 'info');
        }
    };

    const filtrarActividades = (category) => {
        const activityCards = document.querySelectorAll('.activity-card');
        const tabButtons = document.querySelectorAll('.tab-button');
        
        // Actualizar botones activos
        tabButtons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Filtrar actividades
        activityCards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    };

    const filtrarMapa = () => {
        mostrarNotificacion('Filtros aplicados al mapa', 'info');
    };

    const mostrarNotificacion = (mensaje, tipo = 'info') => {
        // Crear elemento de notificación
        const notificacion = document.createElement('div');
        notificacion.className = `notification ${tipo}`;
        notificacion.innerHTML = `
            <span>${mensaje}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        `;
        
        document.body.appendChild(notificacion);
        
        // Remover después de 4 segundos
        setTimeout(() => {
            if (notificacion.parentElement) {
                notificacion.style.opacity = '0';
                setTimeout(() => {
                    if (notificacion.parentElement) {
                        notificacion.parentElement.removeChild(notificacion);
                    }
                }, 300);
            }
        }, 4000);
    };

    const agregarAlCarrito = (item) => {
        state.cart.push({
            id: Date.now(),
            ...item,
            fechaAgregado: new Date().toISOString()
        });
        
        localStorage.setItem('inkatours_cart', JSON.stringify(state.cart));
        mostrarNotificacion(`${item.nombre} agregado al carrito`, 'success');
        
        return state.cart.length;
    };

    const eliminarDelCarrito = (index) => {
        const item = state.cart[index];
        state.cart.splice(index, 1);
        localStorage.setItem('inkatours_cart', JSON.stringify(state.cart));
        mostrarNotificacion(`${item.nombre} eliminado del carrito`, 'info');
        
        return state.cart.length;
    };

    const vaciarCarrito = () => {
        state.cart = [];
        localStorage.setItem('inkatours_cart', JSON.stringify(state.cart));
        mostrarNotificacion('Carrito vaciado', 'info');
    };

    const obtenerCarrito = () => {
        return [...state.cart];
    };

    const calcularTotal = () => {
        return state.cart.reduce((total, item) => total + (item.precio || 0), 0);
    };

    // Métodos públicos
    return {
        init,
        agregarAlCarrito,
        eliminarDelCarrito,
        vaciarCarrito,
        obtenerCarrito,
        calcularTotal,
        
        addToCart: (id) => {
            const destinations = [
                { id: 1, name: "Machu Picchu", precio: 150 },
                { id: 2, name: "Valle Sagrado", precio: 120 },
                { id: 3, name: "Montaña de 7 Colores", precio: 100 }
            ];
            const destination = destinations.find(d => d.id === id);
            if (destination) {
                agregarAlCarrito({
                    tipo: 'destino',
                    nombre: destination.name,
                    precio: destination.precio,
                    fecha: new Date().toISOString().split('T')[0]
                });
            }
        },
        
        agregarAlCarritoDesdeMapa: (nombre, precio, tipo) => {
            agregarAlCarrito({
                tipo: tipo,
                nombre: nombre,
                precio: precio,
                fecha: new Date().toISOString().split('T')[0]
            });
        },
        
        verDetallesDestino: (nombreDestino) => {
            mostrarNotificacion(`Viendo detalles de: ${nombreDestino}`, 'info');
        },
        
        // Para compatibilidad con código existente
        mostrarNotificacion
    };
})();

// ===== INICIALIZACIÓN =====
document.addEventListener('DOMContentLoaded', () => {
    InkaToursApp.init();
});

// Hacer disponible globalmente para HTML
window.InkaToursApp = InkaToursApp;
window.MultiIdioma = typeof MultiIdioma !== 'undefined' ? MultiIdioma : null;