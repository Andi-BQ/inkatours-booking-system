<?php
// Default values for parameters
$mapId = $mapId ?? 'mapa-completo';
$height = $height ?? '100vh';
$locations = $locations ?? '[]';
$showControls = $showControls ?? true;

// Extract unique categories for dynamic filter generation
$decodedLocations = json_decode($locations, true);
$allCategories = [];
if (is_array($decodedLocations)) {
    foreach ($decodedLocations as $loc) {
        if (isset($loc['categoria']) && !empty($loc['categoria'])) {
            $allCategories[] = trim($loc['categoria']);
        }
    }
}
$uniqueCategories = array_unique($allCategories);
sort($uniqueCategories); // Sort alphabetically
?>

<style>
    /* CSS for custom map markers */
    .marker-image-container {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        background-color: #eee;
    }
    .marker-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<section class="map-section map-flex-container" style="height: <?php echo htmlspecialchars($height); ?>; position: relative;">
    <div id="<?php echo htmlspecialchars($mapId); ?>" class="map-main-area" style="height: 100%; width: 100%; border-radius: 10px;"></div>
    
    <?php if ($showControls): ?>
    <div class="map-controls-panel">
        <h3>Filtros del Mapa</h3>
        <div class="filter-options">
            <label><input type="checkbox" checked data-categoria="todas"> Todas</label>
            <?php foreach ($uniqueCategories as $category): ?>
                <label><input type="checkbox" checked data-categoria="<?php echo htmlspecialchars(strtolower($category)); ?>"> <?php echo htmlspecialchars($category); ?></label>
            <?php endforeach; ?>
        </div>
        <div class="map-stats">
            <p><strong>Mostrando: </strong><span id="contador-destinos-<?php echo htmlspecialchars($mapId); ?>">0</span></p>
        </div>
    </div>
    <?php endif; ?>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.mapInitialized && window.mapInitialized['<?php echo $mapId; ?>']) {
        return;
    }
    if (!window.mapInitialized) {
        window.mapInitialized = {};
    }
    window.mapInitialized['<?php echo $mapId; ?>'] = true;

    let mapa;
    let marcadores = [];

    const locations = <?php echo $locations; ?>;

    function inicializarMapa() {
        const cuscoCoords = [-13.53195, -71.96746];
        
        try {
            mapa = L.map('<?php echo $mapId; ?>').setView(cuscoCoords, 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18
            }).addTo(mapa);
            
            crearMarcadores();
            configurarEventos();
            filtrarMarcadores(); // Initial filter application
            
            setTimeout(() => mapa.invalidateSize(), 100);
            
        } catch (error) {
            console.error('Error al inicializar el mapa:', error);
            const mapContainer = document.getElementById('<?php echo $mapId; ?>');
            if(mapContainer) {
                mapContainer.innerHTML = '<p style="padding: 20px; text-align:center;">Error al cargar el mapa.</p>';
            }
        }
    }

    function crearMarcadores() {
        if (!locations || !Array.isArray(locations)) return;

        locations.forEach(location => {
            const lat = parseFloat(location.lng);
            const lng = parseFloat(location.lat);

            if (isNaN(lat) || isNaN(lng)) return;

            const tipoPath = location.tipo === 'destino' ? 'destinos' : 'actividades';
            const imageUrl = `/Inkatours/static/img/${tipoPath}/${location.imagen_principal}`;

            const iconoPersonalizado = L.divIcon({
                html: `
                    <div class="marker-image-container">
                        <img src="${imageUrl}" alt="${location.nombre}" class="marker-image" onerror="this.style.display='none'">
                    </div>`,
                className: 'marker-personalizado',
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            const url = location.tipo === 'destino'
                ? `/Inkatours/destinos/show/${location.id}`
                : `/Inkatours/actividades/show/${location.id}`;

            const popupContent = `
                <div class="map-popup">
                    <h3 style="margin-bottom: 5px;">${location.nombre}</h3>
                    <p style="font-size: 0.9rem;">${location.descripcion_corta}</p>
                    <a href="${url}" class="btn-primary btn-sm" style="margin-top: 10px;">Ver detalles</a>
                </div>`;

            const marcador = L.marker([lat, lng], { icon: iconoPersonalizado })
                .bindPopup(popupContent);
            
            marcador.locationData = location; // Associate full data with marker
            marcadores.push(marcador);
        });
    }

    function filtrarMarcadores() {
        const checkboxes = document.querySelectorAll('.map-controls-panel .filter-options input[type="checkbox"]');
        let categoriasActivas = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.getAttribute('data-categoria').toLowerCase());

        // If 'todas' is checked, or no specific category is checked, show all
        const mostrarTodas = categoriasActivas.includes('todas') || categoriasActivas.length === 0;

        let contador = 0;
        marcadores.forEach(marcador => {
            const categoriaMarcador = (marcador.locationData.categoria || '').toLowerCase();
            
            let debeMostrarse = false;
            if (mostrarTodas) {
                debeMostrarse = true;
            } else {
                // Check if marker's category matches any active category
                debeMostrarse = categoriasActivas.some(cat => categoriaMarcador.includes(cat));
            }

            if (debeMostrarse) {
                if (!mapa.hasLayer(marcador)) {
                    marcador.addTo(mapa);
                }
                contador++;
            } else {
                if (mapa.hasLayer(marcador)) {
                    mapa.removeLayer(marcador);
                }
            }
        });
        actualizarContadorDestinos(contador);
    }

    function configurarEventos() {
        const checkboxes = document.querySelectorAll('.map-controls-panel .filter-options input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // If 'todas' is clicked, uncheck/check other categories
                if (this.dataset.categoria === 'todas') {
                    checkboxes.forEach(cb => {
                        if (cb !== this) cb.checked = this.checked;
                    });
                } else {
                    // If any other category is unchecked, 'todas' should also be unchecked
                    const todasCheckbox = document.querySelector('.map-controls-panel .filter-options input[data-categoria="todas"]');
                    if (todasCheckbox && !this.checked) {
                        todasCheckbox.checked = false;
                    }
                    // If all others are checked, 'todas' should be checked
                    const allOthersChecked = Array.from(checkboxes).filter(cb => cb.dataset.categoria !== 'todas').every(cb => cb.checked);
                    if (todasCheckbox && allOthersChecked) {
                        todasCheckbox.checked = true;
                    }
                }
                filtrarMarcadores();
            });
        });
    }

    function actualizarContadorDestinos(count) {
        const elementoContador = document.getElementById('contador-destinos-<?php echo htmlspecialchars($mapId); ?>');
        if (elementoContador) {
            elementoContador.textContent = count;
        }
    }

    inicializarMapa();
});
</script>
