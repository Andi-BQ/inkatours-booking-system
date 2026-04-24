<?php require_once 'partials/header.php'; ?>
<link rel="stylesheet" href="/Inkatours/static/css/style.css">

<!-- Dashboard de Afluencia Mejorado -->
<section class="dashboard-container">
    <!-- Header con KPI principales -->
    <div class="dashboard-header">
        <div class="header-left">
            <h1 class="dashboard-title">Dashboard de Inteligencia Turística</h1>
            <p class="dashboard-subtitle">Datos en tiempo real para la toma de decisiones estratégicas</p>
        </div>
        <div class="header-right">
            <div class="time-selector">
                <div class="time-buttons">
                    <button class="time-btn active" data-time="today">Hoy</button>
                    <button class="time-btn" data-time="tomorrow">Mañana</button>
                    <button class="time-btn" data-time="weekend">Fin de Semana</button>
                    <button class="time-btn" data-time="nextweek">Próxima Semana</button>
                </div>
                <div class="date-range">
                    <input type="date" id="start-date" value="<?php echo date('Y-m-d'); ?>">
                    <span>a</span>
                    <input type="date" id="end-date" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>">
                    <button class="btn-primary" id="apply-date">Aplicar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tarjetas de KPI principales -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-header">
                <h3 class="kpi-title">Total Visitantes Estimados</h3>
                <i class="fas fa-users kpi-icon"></i>
            </div>
            <div class="kpi-value" id="total-visitors"><?php echo number_format($data['kpis']['total_visitantes'] ?? 0); ?></div>
            <div class="kpi-trend <?php echo ($data['kpis']['tendencia_visitantes'] ?? 0) >= 0 ? 'trend-up' : 'trend-down'; ?>">
                <i class="fas fa-arrow-<?php echo ($data['kpis']['tendencia_visitantes'] ?? 0) >= 0 ? 'up' : 'down'; ?>"></i>
                <?php echo abs($data['kpis']['tendencia_visitantes'] ?? 0); ?>% vs período anterior
            </div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-header">
                <h3 class="kpi-title">Saturación Crítica</h3>
                <i class="fas fa-exclamation-triangle kpi-icon warning"></i>
            </div>
            <div class="kpi-value" id="critical-sites"><?php echo $data['kpis']['sitios_criticos'] ?? 0; ?></div>
            <div class="kpi-subtext">Sitios con >80% capacidad</div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-header">
                <h3 class="kpi-title">Capacidad Disponible</h3>
                <i class="fas fa-check-circle kpi-icon success"></i>
            </div>
            <div class="kpi-value" id="available-capacity"><?php echo $data['kpis']['capacidad_disponible'] ?? 0; ?>%</div>
            <div class="kpi-subtext">Promedio de todos los destinos</div>
        </div>
        
        <div class="kpi-card">
            <div class="kpi-header">
                <h3 class="kpi-title">Índice de Sostenibilidad</h3>
                <i class="fas fa-leaf kpi-icon eco"></i>
            </div>
            <div class="kpi-value" id="sustainability-index"><?php echo $data['kpis']['indice_sostenibilidad'] ?? 0; ?>/10</div>
            <div class="kpi-progress">
                <div class="progress-bar" style="width: <?php echo ($data['kpis']['indice_sostenibilidad'] ?? 0) * 10; ?>%"></div>
            </div>
        </div>
    </div>
    
    <!-- Gráficos principales -->
    <div class="dashboard-grid">
        <!-- Mapa de Calor de Afluencia -->
        <div class="dashboard-card full-width">
            <div class="card-header">
                <h2 class="card-title">Mapa de Calor - Afluencia por Destino</h2>
                <div class="card-actions">
                    <button class="btn-icon" id="refresh-heatmap"><i class="fas fa-sync-alt"></i></button>
                    <button class="btn-icon" id="download-heatmap"><i class="fas fa-download"></i></button>
                </div>
            </div>
            <div class="heatmap-container">
                <div class="heatmap-legend">
                    <div class="legend-item">
                        <span class="legend-color low"></span> Baja (0-30%)
                    </div>
                    <div class="legend-item">
                        <span class="legend-color medium"></span> Media (31-60%)
                    </div>
                    <div class="legend-item">
                        <span class="legend-color high"></span> Alta (61-80%)
                    </div>
                    <div class="legend-item">
                        <span class="legend-color critical"></span> Crítica (81-100%)
                    </div>
                </div>
                <div class="heatmap-grid">
                    <?php if (isset($data['destinos']) && !empty($data['destinos'])): ?>
                        <?php foreach ($data['destinos'] as $destino): ?>
                            <div class="heatmap-item <?php echo $destino['nivel_clase']; ?>">
                                <div class="heatmap-value"><?php echo $destino['afluencia']; ?>%</div>
                                <div class="heatmap-label"><?php echo $destino['nombre']; ?></div>
                                <div class="heatmap-tooltip">
                                    <strong><?php echo $destino['nombre']; ?></strong><br>
                                    Afluencia: <?php echo $destino['afluencia']; ?>%<br>
                                    Capacidad: <?php echo $destino['capacidad']; ?> personas<br>
                                    Recomendación: <?php echo $destino['recomendacion']; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de Predicción Temporal -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Predicción por Horas - <?php echo $data['destino_focus'] ?? 'Machu Picchu'; ?></h2>
                <select id="destination-select" class="select-sm">
                    <option value="1">Machu Picchu</option>
                    <option value="2">Montaña 7 Colores</option>
                    <option value="3">Valle Sagrado</option>
                    <option value="8">Camino Inca</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="hourlyPredictionChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item"><span style="background-color: #2E86C1"></span> Predicción</div>
                <div class="legend-item"><span style="background-color: #F39C12"></span> Histórico</div>
                <div class="legend-item"><span style="background-color: #E74C3C"></span> Capacidad Máxima</div>
            </div>
        </div>
        
        <!-- Análisis de Tendencias -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Análisis de Tendencias</h2>
                <div class="time-filter">
                    <select id="trend-period">
                        <option value="week">Última semana</option>
                        <option value="month">Último mes</option>
                        <option value="quarter">Último trimestre</option>
                    </select>
                </div>
            </div>
            <div class="trend-analysis">
                <div class="trend-item">
                    <div class="trend-header">
                        <span class="trend-title">Tendencia Machu Picchu</span>
                        <span class="trend-value <?php echo ($data['tendencias']['machu_picchu_tendencia'] ?? 0) >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo ($data['tendencias']['machu_picchu_tendencia'] ?? 0) >= 0 ? '+' : ''; ?>
                            <?php echo $data['tendencias']['machu_picchu_tendencia'] ?? 0; ?>%
                        </span>
                    </div>
                    <div class="trend-chart-mini">
                        <canvas id="trendChartMP" height="40"></canvas>
                    </div>
                </div>
                
                <div class="trend-item">
                    <div class="trend-header">
                        <span class="trend-title">Tendencia Montaña 7 Colores</span>
                        <span class="trend-value <?php echo ($data['tendencias']['vinicunca_tendencia'] ?? 0) >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo ($data['tendencias']['vinicunca_tendencia'] ?? 0) >= 0 ? '+' : ''; ?>
                            <?php echo $data['tendencias']['vinicunca_tendencia'] ?? 0; ?>%
                        </span>
                    </div>
                    <div class="trend-chart-mini">
                        <canvas id="trendChartVC" height="40"></canvas>
                    </div>
                </div>
                
                <div class="trend-item">
                    <div class="trend-header">
                        <span class="trend-title">Preferencia Turismo Comunitario</span>
                        <span class="trend-value <?php echo ($data['tendencias']['comunitario_tendencia'] ?? 0) >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo ($data['tendencias']['comunitario_tendencia'] ?? 0) >= 0 ? '+' : ''; ?>
                            <?php echo $data['tendencias']['comunitario_tendencia'] ?? 0; ?>%
                        </span>
                    </div>
                    <div class="trend-chart-mini">
                        <canvas id="trendChartCom" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alertas y Recomendaciones -->
    <div class="dashboard-card full-width">
        <div class="card-header">
            <h2 class="card-title">Alertas del Sistema</h2>
            <span class="badge badge-danger"><?php echo count($data['alertas'] ?? []); ?> alertas activas</span>
        </div>
        <div class="alerts-container">
            <?php if (isset($data['alertas']) && !empty($data['alertas'])): ?>
                <?php foreach ($data['alertas'] as $alerta): ?>
                    <div class="alert-item alert-<?php echo $alerta['nivel']; ?>">
                        <div class="alert-icon">
                            <?php if ($alerta['nivel'] == 'critica'): ?>
                                <i class="fas fa-exclamation-circle"></i>
                            <?php elseif ($alerta['nivel'] == 'advertencia'): ?>
                                <i class="fas fa-exclamation-triangle"></i>
                            <?php else: ?>
                                <i class="fas fa-info-circle"></i>
                            <?php endif; ?>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title"><?php echo $alerta['titulo']; ?></div>
                            <div class="alert-description"><?php echo $alerta['descripcion']; ?></div>
                            <div class="alert-time"><?php echo $alerta['timestamp']; ?></div>
                        </div>
                        <div class="alert-actions">
                            <button class="btn-sm btn-primary">Ver detalles</button>
                            <button class="btn-sm btn-secondary">Marcar como leída</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert-item alert-success">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">Sin alertas críticas</div>
                        <div class="alert-description">Todos los destinos operan dentro de los parámetros normales</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Tablas de Datos Detallados -->
    <div class="dashboard-grid">
        <!-- Tabla de Reservas Confirmadas -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Reservas Confirmadas</h2>
                <div class="card-actions">
                    <button class="btn-icon" id="export-reservas"><i class="fas fa-file-export"></i></button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Destino</th>
                            <th>Fecha</th>
                            <th>Grupos</th>
                            <th>Personas</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['reservas']) && !empty($data['reservas'])): ?>
                            <?php foreach ($data['reservas'] as $reserva): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reserva['destino']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($reserva['fecha'])); ?></td>
                                    <td><?php echo $reserva['grupos']; ?></td>
                                    <td>
                                        <span class="badge <?php echo $reserva['personas'] > 10 ? 'badge-warning' : 'badge-info'; ?>">
                                            <?php echo $reserva['personas']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $reserva['estado']; ?>">
                                            <?php echo ucfirst($reserva['estado']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recomendaciones de Distribución -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">Recomendaciones Inteligentes</h2>
                <i class="fas fa-robot card-icon"></i>
            </div>
            <div class="recommendations">
                <?php if (isset($data['recomendaciones']) && !empty($data['recomendaciones'])): ?>
                    <?php foreach ($data['recomendaciones'] as $recomendacion): ?>
                        <div class="recommendation-item">
                            <div class="recommendation-icon">
                                <?php if ($recomendacion['tipo'] == 'distribucion'): ?>
                                    <i class="fas fa-exchange-alt"></i>
                                <?php elseif ($recomendacion['tipo'] == 'horario'): ?>
                                    <i class="fas fa-clock"></i>
                                <?php else: ?>
                                    <i class="fas fa-lightbulb"></i>
                                <?php endif; ?>
                            </div>
                            <div class="recommendation-content">
                                <div class="recommendation-title"><?php echo $recomendacion['titulo']; ?></div>
                                <div class="recommendation-description"><?php echo $recomendacion['descripcion']; ?></div>
                                <div class="recommendation-impact">
                                    <span class="impact-badge">Impacto: <?php echo $recomendacion['impacto']; ?>%</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Note: The controller is passing dummy data for now.
    // This script is ready to use real data once the backend logic is fully implemented.

    const hourlyPredictionData = <?php echo json_encode($data['hourly_prediction'] ?? []); ?>;
    const trendDataMP = <?php echo json_encode($data['trend_data_mp'] ?? []); ?>;
    const trendDataVC = <?php echo json_encode($data['trend_data_vc'] ?? []); ?>;
    const trendDataCom = <?php echo json_encode($data['trend_data_com'] ?? []); ?>;

    // Gráfico de predicción por horas
    const ctxHourly = document.getElementById('hourlyPredictionChart').getContext('2d');
    const hourlyChart = new Chart(ctxHourly, {
        type: 'line',
        data: {
            labels: hourlyPredictionData.labels,
            datasets: [{
                label: 'Predicción',
                data: hourlyPredictionData.prediction,
                borderColor: '#2E86C1',
                backgroundColor: 'rgba(46, 134, 193, 0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Histórico',
                data: hourlyPredictionData.historic,
                borderColor: '#F39C12',
                borderDash: [5, 5],
                fill: false
            }, {
                label: 'Capacidad Máxima',
                data: hourlyPredictionData.capacity,
                borderColor: '#E74C3C',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, max: 100, title: { display: true, text: 'Porcentaje de Afluencia' }},
                x: { title: { display: true, text: 'Hora del Día' }}
            }
        }
    });

    // Gráficos de tendencia mini
    const trendOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { x: { display: false }, y: { display: false } }
    };

    new Chart(document.getElementById('trendChartMP'), {
        type: 'line',
        data: { labels: trendDataMP.labels, datasets: [{ data: trendDataMP.data, borderColor: '#2A9D8F', borderWidth: 2, fill: false, tension: 0.4 }] },
        options: trendOptions
    });

    new Chart(document.getElementById('trendChartVC'), {
        type: 'line',
        data: { labels: trendDataVC.labels, datasets: [{ data: trendDataVC.data, borderColor: '#E74C3C', borderWidth: 2, fill: false, tension: 0.4 }] },
        options: trendOptions
    });

    new Chart(document.getElementById('trendChartCom'), {
        type: 'line',
        data: { labels: trendDataCom.labels, datasets: [{ data: trendDataCom.data, borderColor: '#27AE60', borderWidth: 2, fill: false, tension: 0.4 }] },
        options: trendOptions
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>
