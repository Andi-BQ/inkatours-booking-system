<?php require_once 'partials/header.php'; ?>

<!-- Incluir Chart.js y Leaflet -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-template-rows: auto auto auto;
        gap: 2rem;
    }
    .dashboard-card {
        background: var(--white);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }
    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    /* Componente 1: Afluencia Actual */
    .card-afluencia-actual {
        grid-column: 1 / -1;
    }
    /* Componente 2: Predicción */
    .card-prediccion-grafico {
        grid-column: 1 / 8;
        height: 400px;
    }
    .card-prediccion-tabla {
        grid-column: 8 / -1;
        height: 400px;
        overflow-y: auto;
    }
    /* Componente 3: Mapa */
    .card-mapa {
        grid-column: 1 / -1;
        height: 500px;
    }
    #mapa-afluencia {
        height: 100%;
        width: 100%;
        border-radius: var(--border-radius);
    }
    .table-wrapper {
        max-height: 300px;
        overflow-y: auto;
    }
    .afluencia-level {
        padding: 0.2rem 0.6rem;
        border-radius: 1rem;
        color: var(--white);
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
    }
    .level-baja { background-color: #28a745; }
    .level-media { background-color: #ffc107; color: var(--dark); }
    .level-alta { background-color: #fd7e14; }
    .level-muy_alta { background-color: #dc3545; }
</style>

<div class="admin-header">
    <h1>Dashboard de Afluencia Turística</h1>
</div>

<div class="dashboard-grid">
    <!-- 1. Afluencia Actual -->
    <div class="dashboard-card card-afluencia-actual">
        <h3 class="card-title"><i class="fas fa-users"></i> Afluencia Actual por Reservas Futuras</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Destino</th>
                        <th>Participantes Futuros</th>
                        <th>Nivel de Afluencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    function getNivelAfluencia($participantes) {
                        if ($participantes > 50) return ['label' => 'Muy Alta', 'class' => 'level-muy_alta'];
                        if ($participantes > 30) return ['label' => 'Alta', 'class' => 'level-alta'];
                        if ($participantes > 10) return ['label' => 'Media', 'class' => 'level-media'];
                        return ['label' => 'Baja', 'class' => 'level-baja'];
                    }
                    ?>
                    <?php if (empty($data['afluencia_actual'])): ?>
                        <tr><td colspan="3">No hay datos de reservas futuras.</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['afluencia_actual'] as $afluencia): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($afluencia['Destino']); ?></td>
                                <td><?php echo htmlspecialchars($afluencia['ParticipantesFuturos']); ?></td>
                                <td>
                                    <?php $nivel = getNivelAfluencia($afluencia['ParticipantesFuturos']); ?>
                                    <span class="afluencia-level <?php echo $nivel['class']; ?>">
                                        <?php echo $nivel['label']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Predicción de Afluencia -->
    <div class="dashboard-card card-prediccion-grafico">
        <h3 class="card-title"><i class="fas fa-chart-line"></i> Predicción de Afluencia (Próximos 7 Días)</h3>
        <canvas id="prediccionChart"></canvas>
    </div>
    <div class="dashboard-card card-prediccion-tabla">
        <h3 class="card-title"><i class="fas fa-table"></i> Tabla de Predicciones</h3>
         <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Nivel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['predicciones'])): ?>
                        <tr><td colspan="4">No hay predicciones disponibles.</td></tr>
                    <?php else: ?>
                        <?php foreach ($data['predicciones'] as $prediccion): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($prediccion['Destino']); ?></td>
                                <td><?php echo htmlspecialchars($prediccion['fecha']); ?></td>
                                <td><?php echo htmlspecialchars(substr($prediccion['hora'], 0, 5)); ?></td>
                                <td>
                                    <span class="afluencia-level level-<?php echo strtolower($prediccion['nivel']); ?>">
                                        <?php echo ucfirst($prediccion['nivel']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Mapa de Afluencia -->
    <div class="dashboard-card card-mapa">
        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Mapa de Afluencia en Tiempo Real</h3>
        <div id="mapa-afluencia"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Lógica para el Gráfico de Predicción
    const prediccionesData = <?php echo json_encode($data['predicciones']); ?>;
    const ctx = document.getElementById('prediccionChart').getContext('2d');
    
    // Agrupar datos por destino
    const destinos = {};
    prediccionesData.forEach(p => {
        if (!destinos[p.Destino]) {
            destinos[p.Destino] = [];
        }
        destinos[p.Destino].push({ x: `${p.fecha} ${p.hora}`, y: p.afluencia_esperada });
    });

    const datasets = Object.keys(destinos).map((nombre, index) => {
        const colors = ['#2A9D8F', '#E76F51', '#F4A261', '#264653', '#E9C46A'];
        return {
            label: nombre,
            data: destinos[nombre],
            borderColor: colors[index % colors.length],
            tension: 0.1,
            fill: false
        };
    });

    new Chart(ctx, {
        type: 'line',
        data: { datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'time',
                    time: { parser: 'YYYY-MM-DD HH:mm:ss', unit: 'day' },
                    title: { display: true, text: 'Fecha' }
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Afluencia Esperada (%)' }
                }
            }
        }
    });

    // 2. Lógica para el Mapa de Afluencia
    const mapData = <?php echo $data['map_data_json']; ?>;
    const map = L.map('mapa-afluencia').setView([-13.52264, -71.96734], 13); // Centrado en Cusco

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const levelColors = {
        'baja': 'green',
        'media': 'orange',
        'alta': 'red',
        'muy_alta': 'darkred',
        'default': 'gray'
    };

    mapData.forEach(location => {
        const color = levelColors[location.nivel_afluencia] || levelColors['default'];
        const circle = L.circle([location.lat, location.lng], {
            color: color,
            fillColor: color,
            fillOpacity: 0.6,
            radius: 500 // El radio puede ser dinámico también
        }).addTo(map);

        circle.bindPopup(`<b>${location.nombre}</b><br>Nivel de afluencia: ${location.nivel_afluencia || 'No disponible'}`);
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>
