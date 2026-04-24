// static/js/predicciones.js
class DashboardPredicciones {
    constructor() {
        this.map = null;
        this.chart = null;
        this.init();
    }

    init() {
        this.inicializarMapa();
        this.inicializarGrafico();
        this.configurarEventos();
        this.cargarDatosIniciales();
    }

    inicializarMapa() {
        if (document.getElementById('crowdMap')) {
            this.map = L.map('crowdMap').setView([-13.53195, -71.96746], 10);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);
            
            this.agregarMarcadores();
        }
    }

    agregarMarcadores() {
        const sites = [
            { 
                name: "Machu Picchu", 
                coords: [-13.1631, -72.5450], 
                capacity: "Alta",
                level: 85,
                color: "#E76F51"
            },
            { 
                name: "Valle Sagrado", 
                coords: [-13.3333, -72.0833], 
                capacity: "Media",
                level: 60,
                color: "#F4A261"
            },
            { 
                name: "Montaña 7 Colores", 
                coords: [-13.6000, -71.4333], 
                capacity: "Alta",
                level: 78,
                color: "#E76F51"
            },
            { 
                name: "Moray", 
                coords: [-13.3298, -72.1962], 
                capacity: "Baja",
                level: 35,
                color: "#2A9D8F"
            },
            { 
                name: "Ollantaytambo", 
                coords: [-13.2581, -72.2636], 
                capacity: "Media",
                level: 55,
                color: "#F4A261"
            }
        ];
        
        sites.forEach(site => {
            const marker = L.marker(site.coords, {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background-color: ${site.color}; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            }).addTo(this.map);
            
            marker.bindPopup(`
                <strong>${site.name}</strong><br>
                Nivel de afluencia: ${site.capacity}<br>
                Capacidad utilizada: ${site.level}%
            `);
        });
    }

    inicializarGrafico() {
        if (document.getElementById('predictionChart')) {
            const ctx = document.getElementById('predictionChart').getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Machu Picchu', 'Valle Sagrado', 'Montaña 7 Colores', 'Moray', 'Ollantaytambo'],
                    datasets: [{
                        label: 'Capacidad Utilizada (%)',
                        data: [85, 60, 78, 35, 55],
                        backgroundColor: [
                            '#E76F51',
                            '#F4A261',
                            '#E76F51',
                            '#2A9D8F',
                            '#F4A261'
                        ],
                        borderColor: [
                            '#E76F51',
                            '#F4A261',
                            '#E76F51',
                            '#2A9D8F',
                            '#F4A261'
                        ],
                        borderWidth: 1
                    }]
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
                                text: 'Porcentaje de Capacidad'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Capacidad utilizada: ${context.raw}%`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    configurarEventos() {
        const dateRangeSelect = document.getElementById('date-range');
        const customDateInput = document.getElementById('custom-date');
        
        if (dateRangeSelect) {
            dateRangeSelect.addEventListener('change', (e) => {
                if (e.target.value === 'custom') {
                    customDateInput.style.display = 'inline-block';
                } else {
                    customDateInput.style.display = 'none';
                    this.actualizarDatosDashboard(e.target.value);
                }
            });
        }

        if (customDateInput) {
            customDateInput.addEventListener('change', (e) => {
                this.actualizarDatosDashboard('custom', e.target.value);
            });
        }

        // Botones de alternativas
        document.querySelectorAll('.btn-alternative').forEach(button => {
            button.addEventListener('click', (e) => {
                const card = e.target.closest('.alternative-card');
                const title = card.querySelector('h4').textContent;
                this.mostrarDetallesAlternativa(title);
            });
        });
    }

    actualizarDatosDashboard(range, customDate = null) {
        console.log(`Actualizando dashboard para: ${range}`, customDate ? `Fecha: ${customDate}` : '');
        
        // Simular actualización de datos según el rango
        this.simularCambiosDatos(range);
        this.mostrarNotificacion(`Datos actualizados para ${this.obtenerNombreRango(range)}`);
    }

    simularCambiosDatos(range) {
        const alertItems = document.querySelectorAll('.alert-item');
        const recommendationItems = document.querySelectorAll('.recommendation-item');

        if (range === 'tomorrow') {
            if (alertItems.length > 0) {
                alertItems[0].querySelector('p').textContent = 'Alta saturación esperada entre 9:00 - 13:00 (88% capacidad)';
                alertItems[1].querySelector('p').textContent = 'Capacidad casi completa entre 7:00 - 9:00 (82% capacidad)';
            }
            
            if (recommendationItems.length > 0) {
                recommendationItems[0].querySelector('p').textContent = 'Mejor horario: Antes de las 9:00 o después de las 13:00';
                recommendationItems[2].querySelector('p').textContent = 'Mejor después de las 12:00 para evitar multitudes';
            }
        } else if (range === 'weekend') {
            if (alertItems.length > 0) {
                alertItems[0].querySelector('p').textContent = 'Alta saturación esperada todo el día (92% capacidad)';
                alertItems[1].querySelector('p').textContent = 'Capacidad completa entre 7:00 - 12:00 (95% capacidad)';
            }
            
            if (recommendationItems.length > 0) {
                recommendationItems[0].querySelector('p').textContent = 'Considerar visitar sitios alternativos';
                recommendationItems[1].querySelector('p').textContent = 'Afluencia media, mejor por la tarde';
            }
        }
    }

    obtenerNombreRango(range) {
        const nombres = {
            'today': 'hoy',
            'tomorrow': 'mañana',
            'weekend': 'este fin de semana',
            'nextweek': 'la próxima semana',
            'custom': 'la fecha seleccionada'
        };
        return nombres[range] || range;
    }

    mostrarNotificacion(mensaje) {
        const notificacion = document.createElement('div');
        notificacion.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2A9D8F;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            font-family: 'Open Sans', sans-serif;
            transition: transform 0.3s ease, opacity 0.3s ease;
            transform: translateX(100%);
            opacity: 0;
        `;
        notificacion.textContent = mensaje;
        
        document.body.appendChild(notificacion);
        
        setTimeout(() => {
            notificacion.style.transform = 'translateX(0)';
            notificacion.style.opacity = '1';
        }, 10);
        
        setTimeout(() => {
            notificacion.style.transform = 'translateX(100%)';
            notificacion.style.opacity = '0';
            setTimeout(() => {
                if (notificacion.parentNode) {
                    notificacion.parentNode.removeChild(notificacion);
                }
            }, 300);
        }, 3000);
    }

    mostrarDetallesAlternativa(titulo) {
        alert(`Redirigiendo a detalles de: ${titulo}`);
        // En una implementación real, redirigiría a la página de detalles
    }

    cargarDatosIniciales() {
        this.actualizarDatosDashboard('today');
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    new DashboardPredicciones();
});