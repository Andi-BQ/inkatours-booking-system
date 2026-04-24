// ===== SISTEMA DE BLOG =====

// Datos de ejemplo de artículos del blog
const articulosBlog = [
    {
        id: 1,
        titulo: "5 Consejos para un Turismo Responsable en Cusco",
        imagen: "https://www.dosmanosperu.com/blog/wp-content/uploads/2021/02/12-ways-to-travel-responsibly-peru.jpg",
        categoria: "sostenibilidad",
        descripcion: "Aprende cómo visitar los destinos más populares minimizando tu impacto ambiental y apoyando a las comunidades locales.",
        fecha: "2023-11-15",
        tiempoLectura: 5,
        autor: "María González",
        contenido: "Contenido completo del artículo sobre turismo responsable...",
        destacado: true
    },
    {
        id: 2,
        titulo: "El Impacto del Turismo en las Comunidades Andinas",
        imagen: "https://www.boletomachupicchu.com/gutblt/wp-content/uploads/2025/03/turismo-vivencial-cusco-full.jpg",
        categoria: "comunidad",
        descripcion: "Descubre cómo el turismo responsable está transformando positivamente la vida de las comunidades locales en los Andes.",
        fecha: "2023-11-08",
        tiempoLectura: 7,
        autor: "Carlos Rodríguez",
        contenido: "Contenido completo sobre el impacto del turismo...",
        destacado: true
    },
    {
        id: 3,
        titulo: "Proyectos de Reforestación en el Valle Sagrado",
        imagen: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZ43KWNz9lLOm2HzyyQ5KvL-g1oQOrn2mZLQ&s",
        categoria: "conservacion",
        descripcion: "Conoce las iniciativas de reforestación con especies nativas y cómo puedes participar durante tu visita.",
        fecha: "2023-11-01",
        tiempoLectura: 4,
        autor: "Ana López",
        contenido: "Contenido completo sobre proyectos de reforestación...",
        destacado: false
    },
    {
        id: 4,
        titulo: "Artesanías Tradicionales: Preservando la Cultura Andina",
        imagen: "https://www.caminosalkantay.com/blog/wp-content/uploads/2024/11/Cusco-Handicraft-1.jpg",
        categoria: "cultura",
        descripcion: "Explora el mundo de las artesanías tradicionales y cómo el turismo ayuda a preservar estas técnicas ancestrales.",
        fecha: "2023-10-25",
        tiempoLectura: 6,
        autor: "Juan Pérez",
        contenido: "Contenido completo sobre artesanías tradicionales...",
        destacado: false
    },
    {
        id: 5,
        titulo: "Gastronomía Sostenible: Sabores Ancestrales del Cusco",
        imagen: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQza3EnrOc1ri-27oUkVx36lFFBEsZsQ69JPg&s",
        categoria: "gastronomia",
        descripcion: "Descubre la rica gastronomía cusqueña y cómo el uso de ingredientes locales promueve la sostenibilidad.",
        fecha: "2023-10-18",
        tiempoLectura: 5,
        autor: "Laura Martínez",
        contenido: "Contenido completo sobre gastronomía sostenible...",
        destacado: false
    },
    {
        id: 6,
        titulo: "Trekking Responsable en los Andes Peruanos",
        imagen: "https://www.peru.travel/Contenido/General/Imagen/es/235/1.1/trekking.jpg",
        categoria: "aventura",
        descripcion: "Guía completa para realizar trekking de manera responsable, minimizando el impacto en los ecosistemas andinos.",
        fecha: "2023-10-10",
        tiempoLectura: 8,
        autor: "Roberto Silva",
        contenido: "Contenido completo sobre trekking responsable...",
        destacado: true
    }
];

// Variables globales
let articulosFiltrados = [...articulosBlog];
let paginaActual = 1;
const articulosPorPagina = 6;
let categoriaActiva = 'all';

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Cargar artículos iniciales
    cargarArticulos();
    
    // Configurar categorías si existen
    configurarCategorias();
    
    console.log('Sistema de blog inicializado');
});

function configurarCategorias() {
    const categoriasContainer = document.getElementById('blog-categorias');
    if (!categoriasContainer) return;
    
    const categorias = [
        { id: 'all', nombre: 'Todos' },
        { id: 'sostenibilidad', nombre: 'Sostenibilidad' },
        { id: 'comunidad', nombre: 'Comunidad' },
        { id: 'conservacion', nombre: 'Conservación' },
        { id: 'cultura', nombre: 'Cultura' },
        { id: 'gastronomia', nombre: 'Gastronomía' },
        { id: 'aventura', nombre: 'Aventura' }
    ];
    
    let html = '';
    categorias.forEach(categoria => {
        html += `
            <div class="categoria-filtro ${categoria.id === categoriaActiva ? 'activa' : ''}" 
                 data-categoria="${categoria.id}">
                ${categoria.nombre}
            </div>
        `;
    });
    
    categoriasContainer.innerHTML = html;
    
    // Configurar eventos de categorías
    document.querySelectorAll('.categoria-filtro').forEach(filtro => {
        filtro.addEventListener('click', function() {
            const categoria = this.getAttribute('data-categoria');
            filtrarPorCategoria(categoria);
        });
    });
}

function filtrarPorCategoria(categoria) {
    categoriaActiva = categoria;
    
    // Actualizar clases activas
    document.querySelectorAll('.categoria-filtro').forEach(filtro => {
        filtro.classList.remove('activa');
        if (filtro.getAttribute('data-categoria') === categoria) {
            filtro.classList.add('activa');
        }
    });
    
    if (categoria === 'all') {
        articulosFiltrados = [...articulosBlog];
    } else {
        articulosFiltrados = articulosBlog.filter(articulo => 
            articulo.categoria === categoria
        );
    }
    
    // Reiniciar a página 1
    paginaActual = 1;
    
    // Recargar artículos
    cargarArticulos();
}

function cargarArticulos() {
    const container = document.getElementById('blog-container');
    if (!container) return;
    
    // Mostrar estado de carga
    container.innerHTML = `
        <div class="blog-cargando">
            <i class="fas fa-spinner"></i>
            <span>Cargando artículos...</span>
        </div>
    `;
    
    // Simular carga de datos
    setTimeout(() => {
        renderizarArticulos();
    }, 500);
}

function renderizarArticulos() {
    const container = document.getElementById('blog-container');
    if (!container) return;
    
    // Calcular artículos para la página actual
    const inicio = (paginaActual - 1) * articulosPorPagina;
    const fin = inicio + articulosPorPagina;
    const articulosPagina = articulosFiltrados.slice(inicio, fin);
    
    if (articulosPagina.length === 0) {
        container.innerHTML = `
            <div class="blog-vacio">
                <i class="fas fa-newspaper"></i>
                <h3>No se encontraron artículos</h3>
                <p>Intenta seleccionar otra categoría para ver más contenido.</p>
            </div>
        `;
        document.getElementById('paginacion-blog').innerHTML = '';
        return;
    }
    
    // Generar HTML de los artículos
    let html = '';
    articulosPagina.forEach(articulo => {
        html += generarCardArticulo(articulo);
    });
    
    container.innerHTML = html;
    
    // Configurar paginación
    configurarPaginacionBlog();
    
    // Configurar eventos de los artículos
    configurarEventosArticulos();
}

function generarCardArticulo(articulo) {
    const fechaFormateada = formatearFecha(articulo.fecha);
    const categoriaTexto = obtenerTextoPorCategoria(articulo.categoria);
    
    return `
        <article class="blog-card" data-id="${articulo.id}">
            <div class="blog-image">
                <img src="${articulo.imagen}" alt="${articulo.titulo}" loading="lazy">
            </div>
            <div class="blog-content">
                <span class="blog-categoria">${categoriaTexto}</span>
                <h3>${articulo.titulo}</h3>
                <p>${articulo.descripcion}</p>
                <div class="blog-meta">
                    <span><i class="far fa-calendar"></i> ${fechaFormateada}</span>
                    <span><i class="far fa-clock"></i> ${articulo.tiempoLectura} min lectura</span>
                    <span><i class="far fa-user"></i> ${articulo.autor}</span>
                </div>
                <a href="#" class="blog-link leer-mas" data-id="${articulo.id}">Leer más</a>
            </div>
        </article>
    `;
}

function formatearFecha(fechaString) {
    const fecha = new Date(fechaString);
    const opciones = { year: 'numeric', month: 'short', day: 'numeric' };
    return fecha.toLocaleDateString('es-ES', opciones);
}

function obtenerTextoPorCategoria(categoria) {
    const categorias = {
        'sostenibilidad': 'Sostenibilidad',
        'comunidad': 'Comunidad',
        'conservacion': 'Conservación',
        'cultura': 'Cultura',
        'gastronomia': 'Gastronomía',
        'aventura': 'Aventura'
    };
    return categorias[categoria] || categoria;
}

function configurarPaginacionBlog() {
    const paginacionContainer = document.getElementById('paginacion-blog');
    if (!paginacionContainer) return;
    
    const totalPaginas = Math.ceil(articulosFiltrados.length / articulosPorPagina);
    
    if (totalPaginas <= 1) {
        paginacionContainer.innerHTML = '';
        return;
    }
    
    let html = '';
    
    // Botón anterior
    html += `
        <button class="pagina-blog-btn anterior" ${paginaActual === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i> Anterior
        </button>
    `;
    
    // Números de página
    const inicioPagina = Math.max(1, paginaActual - 2);
    const finPagina = Math.min(totalPaginas, inicioPagina + 4);
    
    for (let i = inicioPagina; i <= finPagina; i++) {
        html += `
            <button class="pagina-blog-btn ${i === paginaActual ? 'activa' : ''}" data-pagina="${i}">
                ${i}
            </button>
        `;
    }
    
    // Botón siguiente
    html += `
        <button class="pagina-blog-btn siguiente" ${paginaActual === totalPaginas ? 'disabled' : ''}>
            Siguiente <i class="fas fa-chevron-right"></i>
        </button>
    `;
    
    paginacionContainer.innerHTML = html;
    
    // Configurar eventos de paginación
    configurarEventosPaginacionBlog();
}

function configurarEventosPaginacionBlog() {
    // Botones de número de página
    document.querySelectorAll('.pagina-blog-btn[data-pagina]').forEach(btn => {
        btn.addEventListener('click', function() {
            paginaActual = parseInt(this.getAttribute('data-pagina'));
            renderizarArticulos();
        });
    });
    
    // Botón anterior
    const btnAnterior = document.querySelector('.pagina-blog-btn.anterior');
    if (btnAnterior) {
        btnAnterior.addEventListener('click', function() {
            if (paginaActual > 1) {
                paginaActual--;
                renderizarArticulos();
            }
        });
    }
    
    // Botón siguiente
    const btnSiguiente = document.querySelector('.pagina-blog-btn.siguiente');
    if (btnSiguiente) {
        btnSiguiente.addEventListener('click', function() {
            const totalPaginas = Math.ceil(articulosFiltrados.length / articulosPorPagina);
            if (paginaActual < totalPaginas) {
                paginaActual++;
                renderizarArticulos();
            }
        });
    }
}

function configurarEventosArticulos() {
    // Enlaces "Leer más"
    document.querySelectorAll('.leer-mas').forEach(enlace => {
        enlace.addEventListener('click', function(e) {
            e.preventDefault();
            const articuloId = parseInt(this.getAttribute('data-id'));
            const articulo = articulosBlog.find(a => a.id === articuloId);
            
            if (articulo) {
                mostrarArticuloCompleto(articulo);
            }
        });
    });
}

function mostrarArticuloCompleto(articulo) {
    // En una implementación real, esto redirigiría a una página de artículo individual
    // Por ahora, mostramos una vista previa en un modal o notificación
    
    const mensaje = `
        <div style="text-align: left; max-width: 500px;">
            <h3 style="color: var(--primary); margin-bottom: 1rem;">${articulo.titulo}</h3>
            <p><strong>Autor:</strong> ${articulo.autor}</p>
            <p><strong>Fecha:</strong> ${formatearFecha(articulo.fecha)}</p>
            <p><strong>Tiempo de lectura:</strong> ${articulo.tiempoLectura} minutos</p>
            <p style="margin-top: 1rem;">${articulo.descripcion}</p>
            <p style="margin-top: 1rem; font-style: italic;">
                Este es un resumen del artículo. En una implementación completa, 
                se mostraría el contenido completo del blog post.
            </p>
        </div>
    `;
    
    mostrarNotificacion(mensaje, 'info');
}

function mostrarNotificacion(mensaje, tipo = 'info') {
    // Usar MultiIdioma si está disponible, sino usar función local
    if (typeof MultiIdioma !== 'undefined' && MultiIdioma.mostrarNotificacion) {
        MultiIdioma.mostrarNotificacion(mensaje, tipo);
    } else if (typeof InkaToursApp !== 'undefined' && InkaToursApp.mostrarNotificacion) {
        InkaToursApp.mostrarNotificacion(mensaje, tipo);
    } else {
        // Implementación local básica
        alert(mensaje.replace(/<[^>]*>/g, ''));
    }
}

// Hacer funciones disponibles globalmente
window.filtrarPorCategoria = filtrarPorCategoria;
window.cargarArticulos = cargarArticulos;