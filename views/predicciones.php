<?php require_once 'partials/header.php'; ?>

<section class="page-hero">
    <div class="container">
        <h1>Planifica tu Aventura Andina con Inteligencia</h1>
        <p>Evita multitudes, descubre joyas ocultas y vive experiencias auténticas</p>
    </div>
</section>

<div class="container">
    <div class="search-box">
        <div class="search-tabs">
            <button class="search-tab active" data-tab="destinos">Destinos</button>
            <button class="search-tab" data-tab="actividades">Actividades</button>
            <button class="search-tab" data-tab="fechas">Por Fecha</button>
        </div>
        <div class="search-content active" id="destinos-search">
            <div class="search-row">
                <div class="search-group"><label for="destination-type"><i class="fas fa-map-marker-alt"></i> Tipo de Experiencia</label><select id="destination-type" class="search-select"><option value="">Todos los destinos</option><option value="cultural">Cultural e Histórico</option><option value="nature">Naturaleza y Aventura</option><option value="community">Turismo Comunitario</option><option value="trekking">Trekking</option></select></div>
                <div class="search-group"><label for="crowd-level"><i class="fas fa-users"></i> Nivel de Congestión</label><select id="crowd-level" class="search-select"><option value="">Cualquier nivel</option><option value="low">Baja (Menos del 30%)</option><option value="medium">Moderada (30-60%)</option><option value="high">Alta (61-80%)</option><option value="avoid">Evitar (>80%)</option></select></div>
                <button class="btn-primary btn-search" id="search-destinations"><i class="fas fa-search"></i> Buscar Destinos</button>
            </div>
        </div>
        <div class="search-content" id="actividades-search">
            <div class="search-row">
                <div class="search-group"><label for="activity-type"><i class="fas fa-hiking"></i> Tipo de Actividad</label><select id="activity-type" class="search-select"><option value="">Todas las actividades</option><option value="trekking">Trekking y Senderismo</option><option value="cultural">Cultural y Educativa</option><option value="adventure">Aventura Extrema</option><option value="community">Experiencia Comunitaria</option></select></div>
                <div class="search-group"><label for="difficulty"><i class="fas fa-mountain"></i> Dificultad</label><select id="difficulty" class="search-select"><option value="">Cualquier dificultad</option><option value="easy">Fácil</option><option value="moderate">Moderada</option><option value="difficult">Difícil</option></select></div>
                <button class="btn-primary btn-search" id="search-activities"><i class="fas fa-search"></i> Buscar Actividades</button>
            </div>
        </div>
        <div class="search-content" id="fechas-search">
            <div class="search-row">
                <div class="search-group"><label for="visit-date"><i class="fas fa-calendar-alt"></i> Fecha de Visita</label><input type="date" id="visit-date" class="search-input" value="<?php echo date('Y-m-d', strtotime('+3 days')); ?>"></div>
                <div class="search-group"><label for="preferred-time"><i class="fas fa-clock"></i> Hora Preferida</label><select id="preferred-time" class="search-select"><option value="">Cualquier hora</option><option value="early">Temprano (6:00 - 9:00)</option><option value="morning">Mañana (9:00 - 12:00)</option><option value="afternoon">Tarde (12:00 - 15:00)</option><option value="late">Tarde-Noche (15:00+)</option></select></div>
                <button class="btn-primary btn-search" id="search-by-date"><i class="fas fa-search"></i> Ver Predicciones</button>
            </div>
        </div>
    </div>
</div>

<section class="tourist-dashboard">
    <div class="real-time-alerts">
        <div class="alert-header">
            <h2><i class="fas fa-bell"></i> Alertas en Tiempo Real</h2>
            <div class="alert-timestamp">Actualizado: <?php echo date('H:i'); ?></div>
        </div>
        <div class="alert-scroll">
            <?php if (isset($data['alertas_tiempo_real']) && !empty($data['alertas_tiempo_real'])): foreach ($data['alertas_tiempo_real'] as $alerta): ?>
            <div class="live-alert alert-<?php echo $alerta['nivel']; ?>">
                <div class="alert-icon"><?php if ($alerta['nivel'] == 'critical'): ?><i class="fas fa-exclamation-triangle"></i><?php elseif ($alerta['nivel'] == 'warning'): ?><i class="fas fa-exclamation-circle"></i><?php else: ?><i class="fas fa-info-circle"></i><?php endif; ?></div>
                <div class="alert-content"><strong><?php echo $alerta['titulo']; ?></strong><span><?php echo $alerta['mensaje']; ?></span></div>
                <div class="alert-time"><?php echo $alerta['tiempo']; ?></div>
            </div>
            <?php endforeach; else: ?>
            <div class="live-alert alert-info">
                <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                <div class="alert-content"><strong>Condiciones normales</strong><span>Todos los destinos están operando dentro de parámetros normales</span></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="dashboard-section">
        <div class="section-header">
            <h2><i class="fas fa-map-marked-alt"></i> Mapa de Congestión en Tiempo Real</h2>
        </div>
        <div class="crowd-map-container">
            <div class="map-sidebar">
                <div class="map-legend">
                    <h4>Leyenda de Congestión</h4>
                    <div class="legend-items">
                        <div class="legend-item"><span class="legend-dot dot-free"></span><span class="legend-label">Libre (0-30%)</span><span class="legend-count"><?php echo $data['estadisticas']['libre'] ?? 0; ?> lugares</span></div>
                        <div class="legend-item"><span class="legend-dot dot-moderate"></span><span class="legend-label">Moderado (31-60%)</span><span class="legend-count"><?php echo $data['estadisticas']['moderado'] ?? 0; ?> lugares</span></div>
                        <div class="legend-item"><span class="legend-dot dot-busy"></span><span class="legend-label">Ocupado (61-80%)</span><span class="legend-count"><?php echo $data['estadisticas']['ocupado'] ?? 0; ?> lugares</span></div>
                        <div class="legend-item"><span class="legend-dot dot-crowded"></span><span class="legend-label">Congestionado (>80%)</span><span class="legend-count"><?php echo $data['estadisticas']['congestionado'] ?? 0; ?> lugares</span></div>
                    </div>
                </div>
                <div class="peak-hours">
                    <h4>Horas Pico para Hoy</h4>
                    <div class="peak-chart"><canvas id="peakHoursChart" height="120"></canvas></div>
                </div>
            </div>
            <div class="map-main">
                <div id="mapaAfluencia" data-locations="<?php echo htmlspecialchars(json_encode($data['locations']), ENT_QUOTES, 'UTF-8'); ?>"></div>
            </div>
        </div>
    </div>
    <div class="dashboard-section">
        <div class="section-header">
            <h2><i class="fas fa-calendar-check"></i> Predicciones de Congestión por Día</h2>
        </div>
        <div class="daily-predictions">
            <?php $days = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom']; $today = date('N') - 1; ?>
            <?php foreach ($days as $index => $day): ?>
                <?php $dayDate = date('Y-m-d', strtotime("monday this week +$index days")); $isToday = ($index == $today); ?>
                <div class="day-card <?php echo $isToday ? 'today' : ''; ?>">
                    <div class="day-header"><div class="day-name"><?php echo $day; ?></div><div class="day-date"><?php echo date('d/m', strtotime($dayDate)); ?></div><?php if ($isToday): ?><span class="day-badge">Hoy</span><?php endif; ?></div>
                    <div class="day-weather"><i class="fas fa-sun"></i><span class="weather-temp">22°C</span></div>
                    <div class="day-prediction">
                        <div class="prediction-bar">
                            <?php $prediction = $data['predicciones_semana'][$index] ?? rand(40, 90); $barClass = 'low'; if ($prediction >= 85) $barClass = 'very-high'; elseif ($prediction >= 70) $barClass = 'high'; elseif ($prediction >= 40) $barClass = 'medium'; ?>
                            <div class="prediction-fill fill-<?php echo $barClass; ?>" style="height: <?php echo $prediction; ?>%"></div>
                        </div>
                        <div class="prediction-value"><?php echo $prediction; ?>%</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="dashboard-section">
        <div class="section-header"><h2><i class="fas fa-lightbulb"></i> Recomendaciones Inteligentes para Ti</h2></div>
        <div class="recommendations-grid">
            <div class="recommendation-card">
                <div class="rec-image-container">
                    <img src="https://www.libertrekperutravel.com/wp-content/uploads/2023/10/exploring-cuscos-south-valley-9_wUtMKf4.jpg" alt="Valle Sur" class="rec-image" loading="lazy">
                    <div class="rec-badge"><i class="fas fa-gem"></i> Joya Oculta</div>
                </div>
                <div class="rec-content">
                    <div class="rec-main">
                        <h3 class="rec-title">Valle Sur de Cusco</h3>
                        <p class="rec-description">Ruta menos conocida con sitios arqueológicos impresionantes.</p>
                        <div class="rec-metrics">
                            <div class="rec-metric">
                                <i class="fas fa-users"></i>
                                <span class="metric-value">25%</span>
                                <span class="metric-label">Congestión</span>
                            </div>
                            <div class="rec-metric">
                                <i class="fas fa-star"></i>
                                <span class="metric-value">4.8</span>
                                <span class="metric-label">Rating</span>
                            </div>
                        </div>
                    </div>
                    <div class="rec-actions"><button class="btn-primary btn-sm">Ver detalles</button></div>
                </div>
            </div>
            <div class="recommendation-card">
                <div class="rec-image-container">
                    <img src="static/img/actividades/taller-textiles.jpg" alt="Chinchero" class="rec-image" loading="lazy">
                    <div class="rec-badge"><i class="fas fa-hands-helping"></i> Experiencia Comunitaria</div>
                </div>
                <div class="rec-content">
                    <div class="rec-main">
                        <h3 class="rec-title">Taller de Tejidos en Chinchero</h3>
                        <p class="rec-description">Aprende técnicas ancestrales de tejido.</p>
                        <div class="rec-metrics">
                            <div class="rec-metric">
                                <i class="fas fa-users"></i>
                                <span class="metric-value">35%</span>
                                <span class="metric-label">Congestión</span>
                            </div>
                            <div class="rec-metric">
                                <i class="fas fa-leaf"></i>
                                <span class="metric-value">100%</span>
                                <span class="metric-label">Sostenible</span>
                            </div>
                        </div>
                    </div>
                    <div class="rec-actions"><button class="btn-primary btn-sm">Reservar ahora</button></div>
                </div>
            </div>
            <div class="recommendation-card">
                <div class="rec-image-container">
                    <img src="https://www.alpacaexpeditions.com/wp-content/uploads/road-choquequirao.jpg" alt="Choquequirao" class="rec-image" loading="lazy">
                    <div class="rec-badge"><i class="fas fa-exchange-alt"></i> Alternativa Recomendada</div>
                </div>
                <div class="rec-content">
                    <div class="rec-main">
                        <h3 class="rec-title">Choquequirao en lugar de Machu Picchu</h3>
                        <p class="rec-description">La "hermana sagrada" con la misma magia pero sin las multitudes.</p>
                        <div class="rec-comparison">
                            <div class="comparison-item"><span class="comp-destination">Machu Picchu</span><span class="comp-crowd crowded">85%</span></div>
                            <div class="comparison-item"><span class="comp-destination">Choquequirao</span><span class="comp-crowd low">30%</span></div>
                        </div>
                    </div>
                    <div class="rec-actions"><button class="btn-primary btn-sm">Comparar</button></div>
                </div>
            </div>
            <div class="recommendation-card no-image">
                 <div class="rec-badge"><i class="fas fa-clock"></i> Horario Óptimo</div>
                <div class="rec-content">
                    <div class="rec-main">
                        <h3 class="rec-title">Machu Picchu - Horas Recomendadas</h3>
                        <p class="rec-description">Evita las multitudes visitando en estos horarios:</p>
                        <div class="time-slots">
                            <div class="time-slot good"><span class="slot-time">6:00 - 8:00 AM</span><span class="slot-crowd">40% congestión</span></div>
                            <div class="time-slot moderate"><span class="slot-time">3:00 - 5:00 PM</span><span class="slot-crowd">60% congestión</span></div>
                            <div class="time-slot avoid"><span class="slot-time">10:00 AM - 2:00 PM</span><span class="slot-crowd">90% congestión</span></div>
                        </div>
                    </div>
                    <div class="rec-actions"><button class="btn-primary btn-sm">Ver disponibilidad</button></div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal" id="destination-modal"><div class="modal-content modal-lg"><span class="close-modal">&times;</span><div id="destination-detail-content"></div></div></div>

<style>
    .tourist-dashboard { max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        .search-box {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: 20px;
            margin-bottom: 40px;
            position: relative;
            z-index: 10;
        }
    .search-tabs { display: flex; border-bottom: 2px solid #eee; margin-bottom: 20px; }
    .search-tab { padding: 14px 28px; background: none; border: none; font-size: 1.1rem; color: #666; cursor: pointer; position: relative; border-radius: 6px 6px 0 0; transition: all 0.3s ease; }
    .search-tab:hover { background-color: #f8f9fa; color: #333; }
    .search-tab.active { color: #2A9D8F; font-weight: 600; background-color: white; }
    .search-tab.active::after { content: ''; position: absolute; bottom: -2px; left: 0; right: 0; height: 2px; background: #2A9D8F; }
    .search-content { display: none; } .search-content.active { display: block; }
    .search-row { display: flex; gap: 15px; align-items: flex-end; }
    .search-group { flex: 1; }
    .search-group label { display: block; margin-bottom: 8px; color: #555; font-weight: 500; }
    .search-select, .search-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; }
    .btn-search { padding: 12px 30px; height: 44px; width: auto; }
    .real-time-alerts { background: #f8f9fa; border-radius: 10px; padding: 20px; margin-bottom: 30px; border-left: 4px solid #2A9D8F; }
    .alert-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .alert-timestamp { color: #666; font-size: 0.9rem; }
        .alert-scroll {
            max-height: 400px;
        }
    .live-alert { display: flex; align-items: center; padding: 12px 15px; margin-bottom: 8px; border-radius: 6px; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    .alert-critical { border-left: 4px solid #E74C3C; }
    .alert-warning { border-left: 4px solid #F39C12; }
    .alert-info { border-left: 4px solid #3498DB; }
    .dashboard-section { margin-bottom: 40px; }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .crowd-map-container { display: grid; grid-template-columns: 300px 1fr; gap: 20px; }
    .map-sidebar { background: #f8f9fa; padding: 20px; border-radius: 10px; }
    .map-legend h4, .peak-hours h4 { margin-bottom: 15px; }
    .legend-items { display: flex; flex-direction: column; gap: 10px; }
    .legend-item { display: flex; align-items: center; }
    .legend-dot { width: 12px; height: 12px; border-radius: 50%; margin-right: 10px; }
    .dot-free { background: #27AE60; } .dot-moderate { background: #F39C12; } .dot-busy { background: #E74C3C; } .dot-crowded { background: #8B0000; }
    .legend-label { flex: 1; font-size: 0.9rem; }
    .legend-count { background: #eee; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem; }
    #mapaAfluencia { height: 500px; width: 100%; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); background: #e9ecef; }
    .daily-predictions { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
    .day-card { background: white; border-radius: 10px; padding: 20px; text-align: center; box-shadow: 0 3px 10px rgba(0,0,0,0.08); }
    .day-card.today { border: 2px solid #2A9D8F; }
    .day-header { margin-bottom: 15px; }
    .day-name { font-size: 1.2rem; font-weight: 600; }
    .day-date { font-size: 0.9rem; color: #7F8C8D; }
    .day-badge { background: #2A9D8F; color: white; padding: 3px 8px; border-radius: 12px; font-size: 0.7rem; margin-top: 5px; display: inline-block; }
    .prediction-bar { width: 20px; height: 100px; background: #eee; border-radius: 10px; position: relative; overflow: hidden; margin: 10px auto; }
    .prediction-fill { position: absolute; bottom: 0; left: 0; right: 0; }
    .fill-low { background: #27AE60; } .fill-medium { background: #F39C12; } .fill-high { background: #E74C3C; } .fill-very-high { background: #8B0000; }
    .prediction-value { font-size: 1.5rem; font-weight: bold; }
    .recommendations-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
    .recommendation-card { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; display: flex; flex-direction: column; position: relative; }
    .recommendation-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
    .rec-image-container { position: relative; }
    .rec-badge { position: absolute; top: 15px; left: 15px; background: rgba(42, 157, 143, 0.9); color: white; padding: 8px 15px; font-size: 0.8rem; border-radius: 6px; z-index: 1; }
    .recommendation-card.no-image .rec-badge { position: static; margin: 20px 20px 0; display: inline-block; width: fit-content; }
    .rec-image { width: 100%; height: 180px; object-fit: cover; }
    .rec-content { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
    .rec-main { flex-grow: 1; }
    .rec-title { font-size: 1.2rem; margin-bottom: 10px; }
    .rec-description { color: #666; margin-bottom: 20px; font-size: 0.95rem; }
    .rec-metrics { display: flex; gap: 15px; margin-bottom: 20px; justify-content: space-around; }
    .rec-metric { text-align: center; }
    .rec-metric .fas { font-size: 1.5rem; color: #2A9D8F; margin-bottom: 8px; }
    .metric-value { display: block; font-size: 1.2rem; font-weight: 600; }
    .metric-label { font-size: 0.8rem; color: #7f8c8d; }
    .rec-comparison { margin-bottom: 20px; }
    .time-slots { margin: 20px 0; }
    .rec-actions { margin-top: auto; }
    .custom-div-icon {
        background: none;
        border: none;
    }
    .map-marker {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 13px;
        font-weight: bold;
        text-shadow: 0 0 3px rgba(0,0,0,0.7);
        box-shadow: 0 2px 5px rgba(0,0,0,0.4);
        border: 2px solid; /* Color will be set inline */
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
    }
    .map-marker.pulse {
        animation: pulse 2s infinite;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.showModal = function(title, content) {
        const modal = document.getElementById('destination-modal');
        const modalContent = document.getElementById('destination-detail-content');
        if (modal && modalContent) { modalContent.innerHTML = '<h2>' + title + '</h2>' + content; modal.style.display = 'block'; }
    }
    const closeModalBtn = document.querySelector('.close-modal');
    if(closeModalBtn) { closeModalBtn.addEventListener('click', () => document.getElementById('destination-modal').style.display = 'none'); }
    window.addEventListener('click', (event) => { if (event.target == document.getElementById('destination-modal')) { document.getElementById('destination-modal').style.display = 'none'; } });

    document.querySelectorAll('.search-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            document.querySelectorAll('.search-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.search-content').forEach(content => content.classList.remove('active'));
            document.getElementById(tabId + '-search').classList.add('active');
        });
    });

    const peakCtx = document.getElementById('peakHoursChart');
    if (peakCtx) { new Chart(peakCtx, { type: 'bar', data: { labels: ['6-8', '8-10', '10-12', '12-14', '14-16', '16-18'], datasets: [{ label: 'Congestión %', data: [40, 85, 90, 80, 65, 45], backgroundColor: ['#27AE60', '#E74C3C', '#E74C3C', '#F39C12', '#27AE60', '#27AE60'] }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 100 } } } }); }

    const mapaElement = document.getElementById('mapaAfluencia');
    if (mapaElement) {
        let locations = [];
        try {
            const locationsData = mapaElement.dataset.locations;
            if (locationsData) { locations = JSON.parse(locationsData); }
        } catch (e) {
            console.error('Error parsing location data:', e);
            mapaElement.innerHTML = '<p style="text-align:center; padding: 50px;">Error al cargar datos del mapa.</p>';
            return;
        }

        if (locations.length > 0) {
            const map = L.map('mapaAfluencia').setView([-13.525, -71.972], 10);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors' }).addTo(map);
            
            const getColor = (c) => { return c > 80 ? '#8B0000' : c > 60 ? '#E74C3C' : c > 30 ? '#F39C12' : '#27AE60'; };
            const getBackgroundColor = (c) => { return c > 80 ? 'rgba(139, 0, 0, 0.7)' : c > 60 ? 'rgba(231, 76, 60, 0.7)' : c > 30 ? 'rgba(243, 156, 18, 0.7)' : 'rgba(39, 174, 96, 0.7)'; };
            const shouldPulse = (c) => { return c > 80; };

            locations.forEach(loc => {
                const lat = parseFloat(loc.lat);
                const lng = parseFloat(loc.lng);

                if (!isNaN(lat) && !isNaN(lng)) {
                    L.marker([lng, lat], { 
                        icon: L.divIcon({
                            className: 'custom-div-icon',
                            html: `<div class='map-marker ${shouldPulse(loc.congestion) ? 'pulse' : ''}' style='background-color:${getBackgroundColor(loc.congestion)}; border-color:${getColor(loc.congestion)};'>${loc.congestion}%</div>`,
                            iconSize: [34, 34],
                            iconAnchor: [17, 17]
                        })
                    }).addTo(map)
                    .bindTooltip('<strong>' + loc.nombre + '</strong>')
                    .on('click', () => {
                        const content = '<div>Congestión: ' + loc.congestion + '%</div><div>Tipo: ' + loc.tipo + '</div>';
                        window.showModal(loc.nombre, content);
                    });
                }
            });
        } else {
             mapaElement.innerHTML = '<p style="text-align:center; padding: 50px;">No hay datos de ubicación para mostrar.</p>';
        }
    }
});
</script>

<?php require_once 'partials/footer.php'; ?>
