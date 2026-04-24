<?php require_once 'partials/header.php'; ?>

    <section class="fullscreen-map">
        <div id="mapa-completo"></div>
        <div class="map-controls-panel">
            <h3>Filtros del Mapa</h3>
            <div class="filter-options">
                <label><input type="checkbox" checked data-categoria="cultural"> Cultural</label>
                <label><input type="checkbox" checked data-categoria="naturaleza"> Naturaleza</label>
                <label><input type="checkbox" checked data-categoria="aventura"> Aventura</label>
                <label><input type="checkbox" checked data-categoria="sostenible"> Sostenible</label>
            </div>
            <div class="map-stats">
                <p><strong>Destinos mostrados: </strong><span id="contador-destinos">0</span></p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let mapa;
            let marcadores = [];

            const locations = <?php echo $data['locations']; ?>;

            function inicializarMapa() {
                const cuscoCoords = [-13.53195, -71.96746];
                
                try {
                    mapa = L.map('mapa-completo').setView(cuscoCoords, 10);
                    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 18
                    }).addTo(mapa);
                    
                    crearMarcadores();
                    
                    setTimeout(() => {
                        mapa.invalidateSize();
                    }, 100);
                    
                } catch (error) {
                    console.error('Error al inicializar el mapa:', error);
                    document.getElementById('mapa-completo').innerHTML = '<p>Error al cargar el mapa.</p>';
                }
            }

            function crearMarcadores() {
                if (!locations) return;

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

                    const marcador = L.marker([location.lng, location.lat], { icon: iconoPersonalizado })
                        .addTo(mapa)
                        .bindPopup(popupContent);
                    
                    marcadores.push(marcador);
                });

                actualizarContadorDestinos();
            }

            function actualizarContadorDestinos() {
                const elementoContador = document.getElementById('contador-destinos');
                if (elementoContador) {
                    elementoContador.textContent = marcadores.length;
                }
            }

            // Inicialización
            inicializarMapa();
        });
    </script>

<?php require_once 'partials/footer.php'; ?>