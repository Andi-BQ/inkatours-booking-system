<?php
require_once 'partials/header.php';

// Helper function to process and stylize blog content
function renderDynamicContent($content) {
    $paragraphs = preg_split('/\\r\\n|\\r|\\n/', trim($content));
    $output = '';
    $first_p = true;

    foreach ($paragraphs as $p) {
        $p = trim($p);
        if (empty($p)) continue;

        // Use simple markdown-like syntax for dynamic elements
        // H3 Subheading: Matches lines starting with "###"
        if (preg_match('/^### (.*)/', $p, $matches)) {
            $output .= "<h3>" . htmlspecialchars($matches[1]) . "</h3>";
        } 
        // Blockquote: Matches lines starting with ">"
        elseif (preg_match('/^> (.*)/', $p, $matches)) {
            $output .= "<blockquote>" . htmlspecialchars($matches[1]) . "</blockquote>";
        }
        // Pull Quote: Matches lines like [pull]Quote text[/pull]
        elseif (preg_match('/\[pull\](.*)\[\/pull\]/', $p, $matches)) {
            $output .= "<div class='pull-quote'>\"" . htmlspecialchars($matches[1]) . "\"</div>";
        }
        // Key Takeaways: Matches [takeaways]...[/takeaways] with items on new lines
        elseif (preg_match('/\[takeaways\](.*)\[\/takeaways\]/s', $p, $matches)) {
            $takeaway_items = explode("\n", trim($matches[1]));
            $output .= "<div class='key-takeaways'><h4>Puntos Clave</h4><ul>";
            foreach($takeaway_items as $item) {
                if(trim($item)) $output .= "<li><i class='fas fa-check-circle'></i> " . htmlspecialchars(trim($item)) . "</li>";
            }
            $output .= "</ul></div>";
        }
        // Regular paragraph with drop cap on the first one
        else {
            if ($first_p) {
                $output .= "<p>" . htmlspecialchars($p) . "</p>";
                $first_p = false;
            } else {
                $output .= "<p>" . htmlspecialchars($p) . "</p>";
            }
        }
    }
    return $output;
}
?>

<div class="blog-show-container container py-5">
    <div class="row">
        <div class="col-lg-8">
            <article class="blog-post">
                <header class="blog-post-header">
                    <img src="/Inkatours/static/img/blog/<?php echo $data['articulo']->imagen_principal; ?>" class="post-image" alt="<?php echo $data['articulo']->titulo; ?>">
                    <h1 class="post-title"><?php echo $data['articulo']->titulo; ?></h1>
                    <div class="post-meta">
                        <span><i class="fas fa-user"></i> <?php echo $data['articulo']->autor_nombre; ?></span>
                        <span><i class="fas fa-calendar-alt"></i> <?php echo date('d M, Y', strtotime($data['articulo']->fecha_publicacion)); ?></span>
                        <span><i class="fas fa-tag"></i> <?php echo $data['articulo']->categoria_nombre; ?></span>
                    </div>
                </header>
                
                <div class="blog-post-content">
                    <?php echo renderDynamicContent($data['articulo']->contenido); ?>
                    
                    <?php if (strpos($data['articulo']->contenido, '### CONSEJOS PARA TU VISITA') !== false): ?>
                    <ul class='interactive-checklist'>
                        <li><div class='checkbox'><i class='fas fa-check'></i></div><span class='task-text'>Reservar entradas con anticipación.</span></li>
                        <li><div class='checkbox'><i class='fas fa-check'></i></div><span class='task-text'>Llegar temprano para evitar multitudes.</span></li>
                        <li><div class='checkbox'><i class='fas fa-check'></i></div><span class='task-text'>Usar protector solar y sombrero.</span></li>
                        <li><div class='checkbox'><i class='fas fa-check'></i></div><span class='task-text'>Mantenerse hidratado.</span></li>
                    </ul>
                    <?php endif; ?>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const checklistItems = document.querySelectorAll('.interactive-checklist li');
                    checklistItems.forEach(item => {
                        item.addEventListener('click', function() {
                            this.classList.toggle('completed');
                        });
                    });
                });
                </script>

                <!-- Social Share -->
                <div class="social-share">
                    <h5>Comparte este artículo</h5>
                    <div class="share-buttons">
                        <a href="#" class="share-btn facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="share-btn twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="share-btn linkedin"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="share-btn whatsapp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Author Box -->
                <div class="author-box">
                    <img src="/Inkatours/static/img/usuarios/admin.jpg" alt="Author" class="author-avatar" loading="lazy">
                    <div class="author-info">
                        <h4>Sobre <?php echo $data['articulo']->autor_nombre; ?></h4>
                        <p>Apasionado por el turismo sostenible y la cultura andina. Con más de 10 años de experiencia, <?php echo $data['articulo']->autor_nombre; ?> busca compartir historias que inspiren a viajar de manera consciente y respetuosa.</p>
                    </div>
                </div>
            </article>
        </div>
        <aside class="col-lg-4 blog-sidebar">
            <div class="sidebar-widget">
                <h4 class="widget-title">Artículos Recientes</h4>
                <ul class="recent-posts-list">
                    <?php if (isset($data['recent_articles']) && is_array($data['recent_articles'])): ?>
                        <?php foreach ($data['recent_articles'] as $recent_articulo): ?>
                            <li class="recent-post-item">
                                <img src="/Inkatours/static/img/blog/<?php echo htmlspecialchars($recent_articulo->imagen_principal); ?>" alt="<?php echo htmlspecialchars($recent_articulo->titulo); ?>" class="recent-post-image" loading="lazy">
                                <div class="recent-post-content">
                                    <h5><a href="/Inkatours/blog/show/<?php echo $recent_articulo->id; ?>"><?php echo htmlspecialchars($recent_articulo->titulo); ?></a></h5>
                                    <span class="recent-post-meta"><?php echo date('d M, Y', strtotime($recent_articulo->fecha_publicacion)); ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay artículos recientes disponibles.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>
