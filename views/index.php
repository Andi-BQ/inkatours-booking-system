<?php require_once 'partials/header.php'; ?>

    <!-- Modal de Login/Registro -->
    <div class="modal" id="auth-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-tabs">
                <div class="modal-tab active" data-tab="login">Iniciar Sesión</div>
                <div class="modal-tab" data-tab="register">Registrarse</div>
            </div>
            
            <div class="tab-content active" id="login-tab">
                <form id="login-form">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <button type="submit" class="btn-primary">Ingresar</button>
                </form>
                <p style="margin-top: 1rem; text-align: center;">¿No tienes cuenta? <a href="#" id="show-register">Regístrate aquí</a></p>
            </div>
            
            <div class="tab-content" id="register-tab">
                <form id="register-form">
                    <div class="form-group">
                        <label for="name">Nombre completo</label>
                        <input type="text" id="register-name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="register-email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="register-password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirmar contraseña</label>
                        <input type="password" id="confirm-password" required>
                    </div>
                    <button type="submit" class="btn-primary">Registrarse</button>
                </form>
                <p style="margin-top: 1rem; text-align: center;">¿Ya tienes cuenta? <a href="#" id="show-login">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Descubre Cusco de Forma Sostenible</h1>
        <p>Explora la magia de los Andes con respeto por la cultura local y el medio ambiente</p>
        <div class="hero-search">
            <input type="text" id="search-input" placeholder="Buscar destinos, actividades...">
            <button type="button" id="search-btn">
                <i class="fas fa-search" style="font-size: 0.9rem; margin-right: 0.3rem;"></i>
                Buscar
            </button>
        </div>
        <div class="search-suggestions" id="search-suggestions" style="display: none;">
            <!-- Las sugerencias aparecerán aquí -->
        </div>
    </div>
    <div class="hero-stats">
        <div class="stat">
            <span class="stat-number">150+</span>
            <span class="stat-label">Destinos Sostenibles</span>
        </div>
        <div class="stat">
            <span class="stat-number">4.8</span>
            <span class="stat-label">Valoración Promedio</span>
        </div>
        <div class="stat">
            <span class="stat-number">5000+</span>
</section>

<!-- Search Results Section -->
<section id="search-results-section" class="search-results" style="display: none; padding: 4rem 0;">
    <div class="container">
        <h2 id="search-results-title" class="section-title">Resultados de Búsqueda</h2>
        
        <!-- Destinos Results -->
        <div id="destinos-results-container">
            <h3>Destinos</h3>
            <div id="destinos-results" class="destinations-grid">
                <!-- Destino results will be populated here -->
            </div>
            <p id="no-destinos-results" style="display: none;">No se encontraron destinos que coincidan con su búsqueda.</p>
        </div>

        <hr style="margin: 4rem 0; border: 1px solid var(--light-gray);">

        <!-- Actividades Results -->
        <div id="actividades-results-container">
            <h3>Actividades</h3>
            <div id="actividades-results" class="activities-grid">
                <!-- Actividad results will be populated here -->
            </div>
            <p id="no-actividades-results" style="display: none;">No se encontraron actividades que coincidan con su búsqueda.</p>
        </div>
    </div>
</section>

    <!-- Sección de Destinos Destacados -->
    <section class="featured-destinations">
        <div class="container">
            <h2>Destinos Destacados</h2>
            <div class="destinations-grid">
                <?php if (isset($data['destinos']) && !empty($data['destinos'])): ?>
                    <?php foreach ($data['destinos'] as $destino): ?>
                        <div class="destination-card">
                            <div class="card-image">
                                <img src="/Inkatours/static/img/destinos/<?php echo $destino['imagen_principal']; ?>" alt="<?php echo $destino['nombre']; ?>" loading="lazy">
                                <div class="card-overlay">
                                    <a href="/Inkatours/destinos/show/<?php echo $destino['id']; ?>" class="btn-overlay">Ver Más</a>
                                </div>
                                <?php if ($destino['sello_verde']): ?>
                                    <span class="sustainable-badge">Sello Verde</span>
                                <?php endif; ?>
                            </div>
                            <div class="card-content">
                                <h3><?php echo $destino['nombre']; ?></h3>
                                <div class="card-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating"><?php echo $destino['rating_promedio']; ?> (<?php echo $destino['total_resenas']; ?>)</span>
                                </div>
                                <p><?php echo $destino['descripcion_corta']; ?></p>
                                <div class="card-details">
                                    <span><i class="fas fa-hiking"></i> <?php echo $destino['dificultad']; ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo $destino['duracion_horas']; ?> horas</span>
                                    <span><i class="fas fa-users"></i> Grupos pequeños</span>
                                </div>
                                <div class="card-footer">
                                    <span class="price">Desde $<?php echo $destino['precio_base']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay destinos destacados en este momento.</p>
                <?php endif; ?>
            </div>
            <div class="section-footer">
                <a href="destinos" class="btn-outline">Ver todos los destinos</a>
            </div>
        </div>
    </section>

    <!-- Sección de Blog Reciente - Mejorada para Turismo -->
<section class="recent-blog-section" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 80px 0;">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 50px;">
            <span class="section-subtitle" style="color: var(--primary); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">
                <i class="fas fa-newspaper"></i> Inspírate para tu próximo viaje
            </span>
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 800; color: var(--dark); margin-bottom: 15px;">
                Consejos de Viaje & Experiencias
            </h2>
            <p class="section-description" style="color: var(--gray); max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
                Descubre historias, consejos prácticos y secretos locales para planificar tu aventura en Cusco
            </p>
        </div>

        <?php if (isset($data['articulos']) && !empty($data['articulos'])): ?>
            <div class="blog-grid-modern" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-bottom: 50px;">
                <?php foreach (array_slice($data['articulos'], 0, 3) as $articulo): ?>
                    <article class="blog-card-turistico" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.08); transition: all 0.4s ease; position: relative;">
                        
                        <!-- Badge de categoría destacado -->
                        <div class="blog-category-badge" style="position: absolute; top: 15px; left: 15px; z-index: 2;">
                            <span class="category-label" style="background: <?php echo $articulo['categoria_color'] ?? '#2A9D8F'; ?>; color: white; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-tag"></i> <?php echo $articulo['categoria_nombre']; ?>
                            </span>
                        </div>
                        
                        <!-- Imagen con overlay de viaje -->
                        <div class="blog-image-container" style="height: 250px; position: relative; overflow: hidden;">
                            <a href="/Inkatours/blog/show/<?php echo $articulo['id']; ?>" class="image-link">
                                <img src="/Inkatours/static/img/blog/<?php echo $articulo['imagen_principal']; ?>" 
                                     alt="<?php echo htmlspecialchars($articulo['titulo']); ?>"
                                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;"
                                     loading="lazy">
                                <div class="image-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent 50%); display: flex; align-items: flex-end; padding: 20px;">
                                    <div class="overlay-content" style="color: white; width: 100%;">
                                        <div class="meta-info" style="display: flex; justify-content: space-between; align-items: center;">
                                            <span class="read-time" style="font-size: 0.9rem; background: rgba(255,255,255,0.2); padding: 5px 12px; border-radius: 15px;">
                                                <i class="far fa-clock"></i> <?php echo $articulo['tiempo_lectura']; ?> min
                                            </span>
                                            <span class="publish-date" style="font-size: 0.9rem;">
                                                <i class="far fa-calendar-alt"></i> <?php echo date('d M', strtotime($articulo['fecha_publicacion'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <!-- Contenido de la tarjeta -->
                        <div class="blog-card-body" style="padding: 25px;">
                            <h3 class="blog-title" style="font-size: 1.3rem; font-weight: 700; line-height: 1.4; margin-bottom: 15px;">
                                <a href="/Inkatours/blog/show/<?php echo $articulo['id']; ?>" 
                                   style="color: var(--dark); text-decoration: none; transition: color 0.3s ease;">
                                   <?php echo htmlspecialchars($articulo['titulo']); ?>
                                </a>
                            </h3>
                            
                            <p class="blog-excerpt" style="color: var(--gray); line-height: 1.6; margin-bottom: 20px; font-size: 0.95rem;">
                                <?php 
                                    $resumen = strip_tags($articulo['resumen']);
                                    echo strlen($resumen) > 120 ? substr($resumen, 0, 120) . '...' : $resumen;
                                ?>
                            </p>
                            
                            <!-- Estadísticas y CTA -->
                            <div class="blog-card-footer" style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid var(--light-gray);">
                                <div class="blog-stats" style="display: flex; gap: 15px;">
                                    <span class="stat-item" style="font-size: 0.85rem; color: var(--gray); display: flex; align-items: center; gap: 5px;">
                                        <i class="far fa-eye"></i> <?php echo number_format($articulo['visitas']); ?>
                                    </span>
                                    <span class="stat-item" style="font-size: 0.85rem; color: var(--gray); display: flex; align-items: center; gap: 5px;">
                                        <i class="far fa-heart"></i> <?php echo $articulo['likes']; ?>
                                    </span>
                                </div>
                                
                                <a href="/Inkatours/blog/show/<?php echo $articulo['id']; ?>" 
                                   class="read-more-btn" 
                                   style="background: linear-gradient(45deg, var(--primary), var(--secondary)); color: white; padding: 8px 20px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease;">
                                    Leer Más <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            

            
            <!-- CTA principal para ver más contenido -->
            <div class="section-footer" style="text-align: center; margin-top: 50px;">
                <a href="/Inkatours/blog" 
                   class="view-all-btn" 
                   style="display: inline-flex; align-items: center; gap: 10px; background: transparent; color: var(--primary); border: 2px solid var(--primary); padding: 12px 35px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 1rem; transition: all 0.3s ease;">
                    <i class="fas fa-book-open"></i> Explorar más consejos de viaje
                </a>
            </div>
            
        <?php else: ?>
            <!-- Estado vacío con llamado a la acción -->
            <div class="empty-state" style="text-align: center; padding: 60px 20px;">
                <div class="empty-icon" style="font-size: 4rem; color: var(--light-gray); margin-bottom: 20px;">
                    <i class="fas fa-compass"></i>
                </div>
                <h3 style="color: var(--dark); margin-bottom: 10px; font-size: 1.8rem;">
                    Próximamente: Guías de Viaje
                </h3>
                <p style="color: var(--gray); max-width: 500px; margin: 0 auto 30px; font-size: 1.1rem;">
                    Estamos preparando consejos expertos para tu aventura en Cusco. Mientras tanto, ¡explora nuestros destinos!
                </p>
                <a href="/Inkatours/destinos" 
                   class="btn-explore-destinations" 
                   style="display: inline-flex; align-items: center; gap: 10px; background: var(--primary); color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-map-marked-alt"></i> Ver Destinos
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Estilos adicionales para interactividad */
.blog-card-turistico:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.12);
}

.blog-card-turistico:hover .image-link img {
    transform: scale(1.05);
}

.read-more-btn:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.view-all-btn:hover {
    background: var(--primary);
    color: white;
    gap: 15px;
}

.subscribe-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.btn-explore-destinations:hover {
    background: var(--secondary);
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* Responsive */
 @media (max-width: 768px) {
    .blog-grid-modern {
        grid-template-columns: 1fr;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .blog-card-body {
        padding: 20px;
    }
    
    .travel-newsletter {
        padding: 30px 20px;
    }
    
    .section-title {
        font-size: 2rem;
    }
}

 @media (max-width: 480px) {
    .blog-card-footer {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .read-more-btn {
        align-self: flex-end;
    }
}
</style>

<script>
// Animación al hacer scroll
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.blog-card-turistico');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Smooth scroll para botones
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                document.querySelector(href)?.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
    
<script>
    const locations = <?php echo $data['locations']; ?>;
</script>
    
    <!-- Sección de Mapa Interactivo -->
    <section class="interactive-map">
        <div class="container">
            <h2>Explora Nuestros Destinos en el Mapa</h2>
            <div class="map-container">
                <div id="map"></div>
                <div class="map-controls">
                    <h3>Filtrar por:</h3>
                    <div class="filter-options">
                        <label><input type="checkbox" checked> Sostenibles</label>
                        <label><input type="checkbox" checked> Culturales</label>
                        <label><input type="checkbox" checked> Aventura</label>
                        <label><input type="checkbox"checked> Naturaleza</label>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Actividades Sostenibles -->
    <section class="sustainable-activities">
        <div class="container">
            <h2>Actividades con Impacto Positivo</h2>
            <div class="activities-tabs">
                <button class="tab-button active" data-tab="all">Todas</button>
                <button class="tab-button" data-tab="cultural">Cultural</button>
                <button class="tab-button" data-tab="adventure">Aventura</button>
                <button class="tab-button" data-tab="nature">Naturaleza</button>
                <button class="tab-button" data-tab="community">Comunitario</button>
            </div>
            <div class="activities-grid">
                <!-- Actividad 1 -->
                <div class="activity-card" data-category="cultural">
                    <a href="/Inkatours/actividades" class="card-image">
                        <i class="fas fa-hands-helping"></i>
                        <div class="card-overlay">
                            <span class="btn-overlay">Ver Actividades</span>
                        </div>
                    </a>
                    <div class="card-content">
                        <h3>Turismo Comunitario</h3>
                        <p>Convivir con comunidades locales y apoyar su economía directamente.</p>
                        <span class="impact-badge">+Impacto</span>
                    </div>
                </div>
                
                <!-- Actividad 2 -->
                <div class="activity-card" data-category="adventure">
                     <a href="/Inkatours/actividades" class="card-image">
                        <i class="fas fa-leaf"></i>
                        <div class="card-overlay">
                            <span class="btn-overlay">Ver Actividades</span>
                        </div>
                    </a>
                    <div class="card-content">
                        <h3>Senderismo Ecológico</h3>
                        <p>Rutas que minimizan el impacto ambiental y promueven la conservación.</p>
                        <span class="impact-badge">+Impacto</span>
                    </div>
                </div>
                
                <!-- Actividad 3 -->
                <div class="activity-card" data-category="nature">
                     <a href="/Inkatours/actividades" class="card-image">
                        <i class="fas fa-seedling"></i>
                        <div class="card-overlay">
                            <span class="btn-overlay">Ver Actividades</span>
                        </div>
                    </a>
                    <div class="card-content">
                        <h3>Reforestación</h3>
                        <p>Participa en programas de reforestación de especies nativas.</p>
                        <span class="impact-badge">+Impacto</span>
                    </div>
                </div>
                
                <!-- Actividad 4 -->
                <div class="activity-card" data-category="community">
                     <a href="/Inkatours/actividades" class="card-image">
                        <i class="fas fa-store"></i>
                        <div class="card-overlay">
                            <span class="btn-overlay">Ver Actividades</span>
                        </div>
                    </a>
                    <div class="card-content">
                        <h3>Comercio Justo</h3>
                        <p>Compra directa de artesanías a productores locales a precios justos.</p>
                        <span class="impact-badge">+Impacto</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Predicción de Afluencia -->
    <section class="crowd-prediction">
        <div class="container">
            <h2>Predicción de Afluencia Turística</h2>
            <div class="prediction-content">
                <div class="prediction-chart">
                    <canvas id="crowdChart"></canvas>
                </div>
                <div class="prediction-info">
                    <h3>Recomendaciones para Hoy</h3>
                    <div class="recommendation">
                        <div class="rec-level high">
                            <span>Machu Picchu: Alta afluencia</span>
                            <p>Mejor horario: Antes de las 10am o después de las 2pm</p>
                        </div>
                        <div class="rec-level medium">
                            <span>Valle Sagrado: Afluencia media</span>
                            <p>Ideal para visitar durante todo el día</p>
                        </div>
                        <div class="rec-level low">
                            <span>Moray: Baja afluencia</span>
                            <p>Excelente opción para evitar multitudes</p>
                        </div>
                    </div>
                    <button class="btn-primary" onclick="window.location.href='predicciones'">
                    Ver predicción completa
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Testimonios -->
    <section class="testimonials">
        <div class="container">
            <h2>Lo que Dicen Nuestros Viajeros</h2>
            <div class="testimonials-slider">
                <?php if (isset($data['recent_reviews']) && !empty($data['recent_reviews'])): ?>
                    <?php foreach ($data['recent_reviews'] as $review): ?>
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="stars">
                                    <?php for ($i = 0; $i < $review['calificacion']; $i++): ?><i class="fas fa-star" style="color: #f39c12;"></i><?php endfor; ?>
                                    <?php for ($i = $review['calificacion']; $i < 5; $i++): ?><i class="far fa-star" style="color: #f39c12;"></i><?php endfor; ?>
                                </div>
                                <p>"<?php echo htmlspecialchars(substr($review['comentario'], 0, 120)); ?>..."</p>
                                <a href="/Inkatours/<?php echo $review['item_path']; ?>/<?php echo $review['item_slug']; ?>" style="text-decoration:none; color: var(--primary);">
                                    <small>Reseña de "<?php echo htmlspecialchars($review['item_nombre']); ?>"</small>
                                </a>
                                <div class="testimonial-author">
                                    <div>
                                        <strong>- <?php echo htmlspecialchars($review['usuario_nombre']); ?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay testimonios recientes.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php require_once 'partials/footer.php'; ?>