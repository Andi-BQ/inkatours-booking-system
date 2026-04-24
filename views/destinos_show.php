<?php require_once 'partials/header.php'; ?>

<?php $destino = $data['destino']; ?>

<div class="destino-show-container">
    <?php if ($destino && $destino->nombre): ?>
        <section class="destino-hero" style="background-image: url('/Inkatours/static/img/destinos/<?php echo htmlspecialchars($destino->imagen_principal); ?>');">
            <div class="hero-content">
                <h1><?php echo htmlspecialchars($destino->nombre); ?></h1>
                <div class="card-rating">
                    <span class="stars">
                        <?php 
                        $rating = $destino->rating_promedio;
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
                    <span class="rating"><?php echo number_format($destino->rating_promedio, 1); ?> (<?php echo htmlspecialchars($destino->total_resenas); ?> reseñas)</span>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="destino-main-content">
                <div class="destino-details">
                    <h2>Descripción</h2>
                    <p><?php echo nl2br(htmlspecialchars($destino->descripcion)); ?></p>
                    
                    <div class="details-grid">
                        <div class="detail-item">
                            <i class="fas fa-hiking"></i>
                            <strong>Dificultad:</strong> <?php echo htmlspecialchars(ucfirst($destino->dificultad)); ?>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <strong>Duración:</strong> <?php echo htmlspecialchars($destino->duracion_horas); ?> horas
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-route"></i>
                            <strong>Distancia:</strong> <?php echo htmlspecialchars($destino->distancia); ?> km
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-mountain"></i>
                            <strong>Altitud:</strong> <?php echo htmlspecialchars($destino->altitud); ?> msnm
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-cloud-sun"></i>
                            <strong>Clima:</strong> <?php echo htmlspecialchars($destino->clima); ?>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-calendar-alt"></i>
                            <strong>Mejor Época:</strong> <?php echo htmlspecialchars($destino->mejor_epoca); ?>
                        </div>
                    </div>
                </div>

                <div class="destino-sidebar">
                    <div class="booking-box">
                        <h3>Reserva tu Aventura</h3>
                        <div class="price-info">
                            <span class="price-label">Desde</span>
                            <span class="price">$<?php echo number_format($destino->precio_base, 0); ?></span>
                            <span class="price-person">por persona</span>
                        </div>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/Inkatours/reservas/crear/destino/<?php echo $destino->id; ?>" class="btn btn-primary btn-block">Reservar Ahora</a>
                        <?php else: ?>
                            <a href="/Inkatours/iniciosesion?redirect_to=/Inkatours/reservas/crear/destino/<?php echo $destino->id; ?>" class="btn btn-primary btn-block">Iniciar Sesión para Reservar</a>
                            <p style="text-align: center; font-size: 0.9rem; margin-top: 1rem;">Debes iniciar sesión para poder realizar una reserva.</p>
                        <?php endif; ?>
                    </div>
                    <div class="sustainability-info">
                        <?php if ($destino->sostenible): ?>
                            <span class="badge-sostenible">♻️ Práctica Sostenible</span>
                            <p>Este destino apoya prácticas de turismo responsable para proteger nuestro entorno.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="container" style="margin-top: 2rem;">
            <div class="reviews-section">
                <h2>Reseñas de Viajeros</h2>
                <?php if (isset($data['reviews']) && !empty($data['reviews'])): ?>
                    <div class="reviews-list">
                        <?php foreach ($data['reviews'] as $review): ?>
                            <div class="review-card">
                                <div class="review-header">
                                    <span class="review-author"><?php echo htmlspecialchars($review['usuario_nombre']); ?></span>
                                    <span class="review-date"><?php echo date('d/m/Y', strtotime($review['created_at'])); ?></span>
                                </div>
                                <div class="review-rating">
                                    <?php for ($i = 0; $i < $review['calificacion']; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                                    <?php for ($i = $review['calificacion']; $i < 5; $i++): ?><i class="far fa-star"></i><?php endfor; ?>
                                </div>
                                <h4 class="review-title"><?php echo htmlspecialchars($review['titulo']); ?></h4>
                                <p class="review-comment"><?php echo nl2br(htmlspecialchars($review['comentario'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Todavía no hay reseñas para este destino. ¡Sé el primero en dejar una!</p>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>
        <section class="no-results-section">
            <div class="container">
                <div class="no-results">
                    <i class="fas fa-map-signs"></i>
                    <h3>Destino no encontrado</h3>
                    <p>El destino que buscas no existe o no está disponible en este momento.</p>
                    <a href="/Inkatours/destinos" class="btn btn-primary">Ver todos los destinos</a>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php require_once 'partials/footer.php'; ?>

<style>
.reviews-section {
    background-color: #f9f9f9;
    padding: 2rem;
    border-radius: var(--border-radius);
}
.reviews-section h2 {
    margin-bottom: 1.5rem;
    text-align: center;
}
.reviews-list {
    display: grid;
    gap: 1.5rem;
}
.review-card {
    background: #fff;
    padding: 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    border-left: 5px solid var(--primary);
}
.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    color: var(--gray);
    font-size: 0.9rem;
}
.review-rating {
    color: #f39c12;
    margin-bottom: 0.5rem;
}
.review-title {
    margin: 0.5rem 0;
    font-size: 1.1rem;
}
.review-comment {
    line-height: 1.6;
}
</style>
