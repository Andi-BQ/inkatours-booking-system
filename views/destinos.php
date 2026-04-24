<?php require_once 'partials/header.php'; ?>

    <section class="page-hero">
        <div class="container">
            <h1>Nuestros Destinos Sostenibles</h1>
            <p>Explora los lugares más increíbles de Cusco con nuestro enfoque responsable</p>
        </div>
    </section>

    <section class="destinos-filtros">
        <div class="container">
            <div class="filtros-grid">
                <div class="filtro-group">
                    <label for="filtro-tipo">Tipo de destino:</label>
                    <select id="filtro-tipo">
                        <option value="all">Todos</option>
                        <option value="cultural">Cultural</option>
                        <option value="naturaleza">Naturaleza</option>
                        <option value="aventura">Aventura</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label for="filtro-dificultad">Dificultad:</label>
                    <select id="filtro-dificultad">
                        <option value="all">Todas</option>
                        <option value="facil">Fácil</option>
                        <option value="moderada">Moderada</option>
                        <option value="dificil">Difícil</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label for="filtro-distancia">Distancia:</label>
                    <select id="filtro-distancia">
                        <option value="all">Cualquier distancia</option>
                        <option value="cercano">Menos de 50km</option>
                        <option value="medio">50-100km</option>
                        <option value="lejano">Más de 100km</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label>
                        <input type="checkbox" id="filtro-sostenible" checked>
                        Solo sostenibles
                    </label>
                </div>
            </div>
        </div>
    </section>

    <section class="destinos-lista">
        <div class="container">
            <div class="destinos-grid" id="destinos-container">
                <?php if (isset($data['destinos']) && !empty($data['destinos'])): ?>
                    <?php foreach ($data['destinos'] as $destino): ?>
                        <div class="destination-card" data-tipo="<?php echo strtolower($destino['tipo']); ?>" 
                             data-dificultad="<?php echo strtolower($destino['dificultad']); ?>"
                             data-distancia="<?php echo $destino['distancia']; ?>">
                            <div class="card-image">
                                <img src="/Inkatours/static/img/destinos/<?php echo $destino['imagen_principal']; ?>" 
                                     alt="<?php echo $destino['nombre']; ?>" loading="lazy">
                                <div class="card-overlay">
                                    <a href="/Inkatours/destinos/show/<?php echo $destino['id']; ?>" class="btn-overlay">Ver Detalles</a>
                                </div>
                                <div class="card-badge">
                                    <span class="badge-sostenible">♻️ Sostenible</span>
                                    <span class="badge-tipo"><?php echo $destino['tipo']; ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3><?php echo $destino['nombre']; ?></h3>
                                <div class="card-rating">
                                    <span class="stars">
                                        <?php 
                                        $rating = $destino['rating_promedio'] ?? 0;
                                        $fullStars = floor($rating);
                                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                        
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $fullStars) {
                                                echo '<i class="fas fa-star"></i>';
                                            } elseif ($i == $fullStars + 1 && $hasHalfStar) {
                                                echo '<i class="fas fa-star-half-alt"></i>';
                                            } else {
                                                echo '<i class="far fa-star"></i>';
                                            }
                                        }
                                        ?>
                                    </span>
                                    <span class="rating"><?php echo number_format($destino['rating_promedio'] ?? 0, 1); ?> (<?php echo $destino['total_resenas'] ?? 0; ?> reseñas)</span>
                                </div>
                                <p class="card-description"><?php echo $destino['descripcion_corta'] ?? 'Descripción no disponible.'; ?></p>
                                <div class="card-details">
                                    <span class="detail-item">
                                        <i class="fas fa-hiking"></i>
                                        <span class="detail-text"><?php echo ucfirst($destino['dificultad']); ?></span>
                                    </span>
                                    <span class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <span class="detail-text"><?php echo $destino['duracion_horas']; ?> horas</span>
                                    </span>
                                    <span class="detail-item">
                                        <i class="fas fa-route"></i>
                                        <span class="detail-text"><?php echo $destino['distancia']; ?> km</span>
                                    </span>
                                </div>
                                <div class="card-footer">
                                    <div class="price-info">
                                        <span class="price-label">Desde</span>
                                        <span class="price">$<?php echo number_format($destino['precio_base'], 0); ?></span>
                                        <span class="price-person">por persona</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>No hay destinos disponibles</h3>
                        <p>Pronto agregaremos nuevas experiencias sostenibles</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Loading spinner -->
            <div class="loading-spinner" id="loading-spinner" style="display: none;">
                <div class="spinner"></div>
                <p>Cargando destinos...</p>
            </div>
        </div>
    </section>

<?php require_once 'partials/footer.php'; ?>