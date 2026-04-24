<?php require_once 'partials/header.php'; ?>

    <section class="page-hero">
        <div class="container">
            <h1>Nuestras Actividades Sostenibles</h1>
            <p>Explora las mejores actividades de Cusco con nuestro enfoque responsable</p>
        </div>
    </section>

    <section class="destinos-filtros">
        <div class="container">
            <div class="filtros-grid">
                <div class="filtro-group">
                    <label for="filtro-categoria">Categoría:</label>
                    <select id="filtro-categoria">
                        <option value="all">Todas</option>
                        <option value="cultural">Cultural</option>
                        <option value="aventura">Aventura</option>
                        <option value="comunidad">Comunidad</option>
                        <option value="naturaleza">Naturaleza</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label for="filtro-dificultad">Dificultad:</label>
                    <select id="filtro-dificultad">
                        <option value="all">Todas</option>
                        <option value="Baja">Baja</option>
                        <option value="Moderada">Moderada</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label for="filtro-duracion">Duración:</label>
                    <select id="filtro-duracion">
                        <option value="all">Cualquier duración</option>
                        <option value="corta">Menos de 4 horas</option>
                        <option value="media">4-8 horas</option>
                        <option value="larga">Más de 8 horas</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label>
                        <input type="checkbox" id="filtro-destacado">
                        Solo destacadas
                    </label>
                </div>
            </div>
        </div>
    </section>

    <section class="destinos-lista">
        <div class="container">
            <div class="destinos-grid" id="actividades-container">
                <?php if (isset($data['actividades']) && !empty($data['actividades'])): ?>
                    <?php foreach ($data['actividades'] as $actividad): ?>
                        <div class="destination-card" data-categoria="<?php echo strtolower($actividad['categoria']); ?>" 
                             data-dificultad="<?php echo strtolower($actividad['dificultad']); ?>"
                             data-duracion="<?php echo $actividad['duracion']; ?>"
                             data-destacado="<?php echo $actividad['destacado']; ?>">
                            <div class="card-image">
                                <img src="/Inkatours/static/img/actividades/<?php echo $actividad['imagen_principal']; ?>" 
                                     alt="<?php echo $actividad['nombre']; ?>" loading="lazy">
                                <div class="card-overlay">
                                    <a href="/Inkatours/actividades/show/<?php echo $actividad['id']; ?>" class="btn-overlay">Ver Detalles</a>
                                </div>
                                <div class="card-badge">
                                    <span class="badge-sostenible">♻️ Sostenible</span>
                                    <span class="badge-tipo"><?php echo $actividad['categoria']; ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <h3><?php echo $actividad['nombre']; ?></h3>
                                <div class="card-rating">
                                    <span class="stars">
                                        <?php 
                                        $rating = $actividad['rating_promedio'];
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
                                    <span class="rating"><?php echo number_format($actividad['rating_promedio'], 1); ?> (<?php echo $actividad['total_resenas']; ?> reseñas)</span>
                                </div>
                                <p class="card-description"><?php echo $actividad['descripcion_corta']; ?></p>
                                <div class="card-details">
                                    <span class="detail-item">
                                        <i class="fas fa-hiking"></i>
                                        <span class="detail-text"><?php echo ucfirst($actividad['dificultad']); ?></span>
                                    </span>
                                    <span class="detail-item">
                                        <i class="fas fa-clock"></i>
                                        <span class="detail-text"><?php echo $actividad['duracion']; ?></span>
                                    </span>
                                    <span class="detail-item">
                                        <i class="fas fa-users"></i>
                                        <span class="detail-text"><?php echo $actividad['participantes_min']; ?>-<?php echo $actividad['participantes_max']; ?></span>
                                    </span>
                                </div>
                                <div class="card-footer">
                                    <div class="price-info">
                                        <span class="price-label">Desde</span>
                                        <span class="price">$<?php echo number_format($actividad['precio'], 0); ?></span>
                                        <span class="price-person">por persona</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>No hay actividades disponibles</h3>
                        <p>Pronto agregaremos nuevas experiencias sostenibles</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Loading spinner -->
            <div class="loading-spinner" id="loading-spinner" style="display: none;">
                <div class="spinner"></div>
                <p>Cargando actividades...</p>
            </div>
        </div>
    </section>

<?php require_once 'partials/footer.php'; ?>
<script src="/Inkatours/static/js/actividades.js"></script>