<?php require_once 'partials/header.php'; ?>

<!-- Hero Section con video/gradiente -->
<section class="blog-hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), url('/Inkatours/static/img/blog/blog-hero-bg.jpg');">
    <div class="container">
        <div class="hero-content">
            <span class="hero-badge">
                <i class="fas fa-leaf"></i> Turismo Sostenible
            </span>
            <h1 class="hero-title">
                Descubre el <span>Corazón de los Andes</span>
            </h1>
            <p class="hero-subtitle">
                Historias auténticas, consejos expertos y guías para explorar Cusco 
                con respeto por su cultura y medio ambiente
            </p>
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Artículos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">25k+</div>
                    <div class="stat-label">Lectores</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Expertos</div>
                </div>
            </div>
            <a href="#blog-content" class="scroll-down-btn">
                Explorar Artículos <i class="fas fa-arrow-down"></i>
            </a>
        </div>
    </div>
</section>

<!-- Filtros de Categorías -->
<section class="blog-filters">
    <div class="container">
        <div class="filters-wrapper">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i> Filtrar por categoría:
            </h3>
            <div class="filter-categories">
                <button class="filter-btn active" data-category="all">
                    Todos
                </button>
                <?php 
                $categorias = [
                    ['id' => 1, 'nombre' => 'Sostenibilidad', 'color' => '#2A9D8F'],
                    ['id' => 2, 'nombre' => 'Comunidad', 'color' => '#E76F51'],
                    ['id' => 3, 'nombre' => 'Conservación', 'color' => '#27AE60'],
                    ['id' => 4, 'nombre' => 'Cultura', 'color' => '#F4A261'],
                    ['id' => 5, 'nombre' => 'Gastronomía', 'color' => '#9B59B6'],
                    ['id' => 6, 'nombre' => 'Aventura', 'color' => '#3498DB']
                ];
                foreach ($categorias as $categoria): ?>
                <button class="filter-btn" 
                        data-category="<?php echo $categoria['id']; ?>"
                        style="--category-color: <?php echo $categoria['color']; ?>">
                    <?php echo $categoria['nombre']; ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Contenido Principal del Blog -->
<section class="blog-content-section" id="blog-content">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                Artículos Destacados
                <span class="title-decoration"></span>
            </h2>
            <p class="section-subtitle">
                Descubre las mejores historias, consejos y experiencias sobre turismo responsable en Cusco
            </p>
        </div>

        <?php if (isset($data['articulos']) && !empty($data['articulos'])): ?>
            <div class="blog-grid-modern">
                <?php foreach ($data['articulos'] as $articulo): ?>
                    <article class="blog-article-card">
                        
                        <?php if ($articulo['destacado']): ?>
                        <div class="featured-badge">
                            <span>
                                <i class="fas fa-star"></i> Destacado
                            </span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="article-image-wrapper">
                            <a href="/Inkatours/blog/show/<?php echo $articulo['id']; ?>" class="image-link">
                                <img src="/Inkatours/static/img/blog/<?php echo htmlspecialchars($articulo['imagen_principal']); ?>" 
                                     alt="<?php echo htmlspecialchars($articulo['titulo']); ?>"
                                     loading="lazy">
                                <div class="image-gradient"></div>
                                <div class="image-overlay-content">
                                    <div class="reading-time">
                                        <i class="far fa-clock"></i> <?php echo $articulo['tiempo_lectura']; ?> min lectura
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="article-content">
                            <div class="article-meta">
                                <div class="category-tag" style="background-color: <?php echo $articulo['categoria_color'] ?? '#2A9D8F'; ?>;">
                                    <i class="fas fa-tag"></i> <?php echo htmlspecialchars($articulo['categoria_nombre']); ?>
                                </div>
                                <div class="date-info">
                                    <i class="far fa-calendar-alt"></i> <?php echo date('d M, Y', strtotime($articulo['fecha_publicacion'])); ?>
                                </div>
                            </div>
                            
                            <h3 class="article-title">
                                <a href="/Inkatours/blog/show/<?php echo $articulo['id']; ?>">
                                   <?php echo htmlspecialchars($articulo['titulo']); ?>
                                </a>
                            </h3>
                            
                            <p class="article-excerpt">
                                <?php 
                                    $resumen = strip_tags($articulo['resumen']);
                                    echo strlen($resumen) > 120 ? substr($resumen, 0, 120) . '...' : $resumen;
                                ?>
                            </p>
                            
                            <div class="article-footer">
                                <div class="article-stats">
                                    <span class="stat-view">
                                        <i class="far fa-eye"></i> <?php echo number_format($articulo['visitas']); ?>
                                    </span>
                                    <span class="stat-likes">
                                        <i class="far fa-heart"></i> <?php echo $articulo['likes']; ?>
                                    </span>
                                </div>
                                <a href="/Inkatours/blog/show/<?php echo $articulo['id']; ?>" 
                                   class="read-more-link">
                                    Leer artículo
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <?php if (isset($data['total_paginas']) && $data['total_paginas'] > 1): ?>
            <div class="blog-pagination">
                <nav aria-label="Paginación">
                    <ul class="pagination-list">
                        <?php for ($i = 1; $i <= $data['total_paginas']; $i++): ?>
                            <li class="page-item <?php echo ($i == $data['pagina_actual']) ? 'active' : ''; ?>">
                                <a class="page-link" 
                                   href="/Inkatours/blog?pagina=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>
                    No hay artículos disponibles
                </h3>
                <p>
                    Pronto publicaremos nuevo contenido sobre turismo sostenible en Cusco.
                </p>
                <a href="/Inkatours/destinos" 
                   class="btn-explore">
                    <i class="fas fa-compass"></i> Explorar Destinos
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const blogCards = document.querySelectorAll('.blog-article-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.dataset.category;
            
            blogCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    blogCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    const scrollBtn = document.querySelector('.scroll-down-btn');
    if(scrollBtn) {
        scrollBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#blog-content').scrollIntoView({
                behavior: 'smooth'
            });
        });
    }
});
</script>