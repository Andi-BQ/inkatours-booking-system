document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const searchSuggestions = document.getElementById('search-suggestions');
    const searchResultsSection = document.getElementById('search-results-section');
    const destinosResultsContainer = document.getElementById('destinos-results');
    const actividadesResultsContainer = document.getElementById('actividades-results');
    const noDestinosResults = document.getElementById('no-destinos-results');
    const noActividadesResults = document.getElementById('no-actividades-results');
    const searchResultsTitle = document.getElementById('search-results-title');

    function performSearch(query) {
        if (query.length < 1) {
            searchResultsSection.style.display = 'none';
            return;
        }

        fetch(`/Inkatours/api/search?q=${query}`)
            .then(response => response.json())
            .then(data => {
                searchResultsTitle.textContent = `Resultados de búsqueda para "${query}"`;
                if (searchSuggestions) {
                    searchSuggestions.style.display = 'none';
                }

                // Clear previous results
                if (destinosResultsContainer) destinosResultsContainer.innerHTML = '';
                if (actividadesResultsContainer) actividadesResultsContainer.innerHTML = '';
                if (noDestinosResults) noDestinosResults.style.display = 'none';
                if (noActividadesResults) noActividadesResults.style.display = 'none';
                
                if (data.destinos.length > 0) {
                    if (document.getElementById('destinos-results-container')) {
                        document.getElementById('destinos-results-container').style.display = 'block';
                    }
                    data.destinos.forEach(item => {
                        const card = createDestinationCard(item);
                        if (destinosResultsContainer) destinosResultsContainer.appendChild(card);
                    });
                } else {
                    if (document.getElementById('destinos-results-container')) {
                        document.getElementById('destinos-results-container').style.display = 'block';
                    }
                    if (noDestinosResults) noDestinosResults.style.display = 'block';
                }

                if (data.actividades.length > 0) {
                    if (document.getElementById('actividades-results-container')) {
                        document.getElementById('actividades-results-container').style.display = 'block';
                    }
                    data.actividades.forEach(item => {
                        const card = createActivityCard(item);
                        if (actividadesResultsContainer) actividadesResultsContainer.appendChild(card);
                    });
                } else {
                    if (document.getElementById('actividades-results-container')) {
                        document.getElementById('actividades-results-container').style.display = 'block';
                    }
                    if (noActividadesResults) noActividadesResults.style.display = 'block';
                }

                if (searchResultsSection) {
                    searchResultsSection.style.display = 'block';
                    searchResultsSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            performSearch(searchInput.value);
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent form submission if it's in a form
                performSearch(searchInput.value);
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(event) {
            if (searchSuggestions && searchSuggestions.style.display === 'block' && !searchInput.contains(event.target)) {
                searchSuggestions.style.display = 'none';
            }
        });
    }

    function createDestinationCard(destino) {
        const card = document.createElement('div');
        card.className = 'destination-card search-result-card';
        card.innerHTML = `
            <div class="card-image">
                <a href="/Inkatours/destinos/show/${destino.id}">
                    <img src="/Inkatours/static/img/destinos/${destino.imagen_principal}" alt="${destino.nombre}">
                </a>
            </div>
            <div class="card-content">
                <h3><a href="/Inkatours/destinos/show/${destino.id}">${destino.nombre}</a></h3>
                <p>${destino.descripcion_corta}</p>
                <div class="card-footer">
                    <span class="price">Desde $${destino.precio_base}</span>
                    <a href="/Inkatours/destinos/show/${destino.id}" class="btn-primary">Ver Más</a>
                </div>
            </div>
        `;
        return card;
    }

    function createActivityCard(actividad) {
        const card = document.createElement('div');
        card.className = 'activity-card search-result-card';
        card.innerHTML = `
            <div class="activity-icon">
                <i class="fas fa-hiking"></i>
            </div>
            <h3><a href="/Inkatours/actividades/show/${actividad.id}">${actividad.nombre}</a></h3>
            <p>${actividad.descripcion_corta}</p>
        `;
        return card;
    }
});
