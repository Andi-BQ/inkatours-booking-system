// Sistema de Multiidioma para InkaTours
const MultiIdioma = {
    // Diccionario de traducciones COMPLETO
    traducciones: {
        es: {
            // Navegación
            "inicio": "Inicio",
            "destinos": "Destinos",
            "actividades": "Actividades",
            "mapa": "Mapa",
            "reservas": "Reservas",
            "blog": "Blog",
            "contacto": "Contacto",
            "iniciar_sesion": "Iniciar Sesión",
            "ingresar": "Ingresar",
            "registrate_aqui": "Regístrate aquí",
            
            // Hero Section
            "titulo_hero": "Descubre Cusco de Forma Sostenible",
            "subtitulo_hero": "Explora la magia de los Andes con respeto por la cultura local y el medio ambiente",
            "placeholder_buscar": "Buscar destinos, actividades...",
            "texto_buscar": "Buscar",
            "destinos_sostenibles": "Destinos Sostenibles",
            "valoracion_promedio": "Valoración Promedio",
            "viajeros_satisfechos": "Viajeros Satisfechos",
            
            // Secciones
            "destinos_destacados": "Destinos Destacados",
            "ver_todos_destinos": "Ver todos los destinos",
            "explora_mapa": "Explora Nuestros Destinos en el Mapa",
            "actividades_impacto": "Actividades con Impacto Positivo",
            "prediccion_afluencia": "Predicción de Afluencia Turística",
            "testimonios_viajeros": "Lo que Dicen Nuestros Viajeros",
            
            // Filtros
            "todas": "Todas",
            "cultural": "Cultural",
            "aventura": "Aventura",
            "naturaleza": "Naturaleza",
            "comunitario": "Comunitario",
            "filtrar_por": "Filtrar por:",
            "mi_ubicacion": "Mi ubicación",
            "sostenible": "Sostenibles",
            
            // Cards de destinos
            "moderada": "Moderada",
            "facil": "Fácil",
            "dificil": "Difícil",
            "dia": "día",
            "grupos_pequenos": "Grupos pequeños",
            "desde": "Desde",
            "ver_detalles": "Ver detalles",
            "sello_verde": "Sello Verde",
            "descripcion_machupicchu": "La ciudadela inca más famosa del mundo, explorada con prácticas sostenibles.",
            "descripcion_valle": "Un recorrido por los pueblos andinos y mercados artesanales del valle.",
            "descripcion_montana": "Una caminata espectacular hacia una de las maravillas naturales del Perú.",
            
            // Actividades
            "actividad1_titulo": "Turismo Comunitario",
            "actividad1_desc": "Convivir con comunidades locales y apoyar su economía directamente.",
            "actividad2_titulo": "Senderismo Ecológico",
            "actividad2_desc": "Rutas que minimizan el impacto ambiental y promueven la conservación.",
            "actividad3_titulo": "Reforestación",
            "actividad3_desc": "Participa en programas de reforestación de especies nativas.",
            "actividad4_titulo": "Comercio Justo",
            "actividad4_desc": "Compra directa de artesanías a productores locales a precios justos.",
            "impacto_positivo": "+Impacto",
            
            // Predicción
            "recomendaciones_hoy": "Recomendaciones para Hoy",
            "machupicchu_alta": "Machu Picchu: Alta afluencia",
            "recomendacion_machupicchu": "Mejor horario: Antes de las 10am o después de las 2pm",
            "valle_media": "Valle Sagrado: Afluencia media",
            "recomendacion_valle": "Ideal para visitar durante todo el día",
            "moray_baja": "Moray: Baja afluencia",
            "recomendacion_moray": "Excelente opción para evitar multitudes",
            "ver_prediccion_completa": "Ver predicción completa",
            
            // Testimonios
            "testimonio1": "InkaTours me permitió conocer Cusco de una manera auténtica y responsable. La atención a la sostenibilidad es impresionante.",
            "testimonio2": "La aplicación de predicción de afluencia fue increíblemente útil para planificar nuestras visitas y evitar las multitudes.",
            "testimonio3": "El enfoque en el turismo comunitario hizo que nuestro viaje fuera más significativo. ¡Volveremos!",
            "pais_espana": "España",
            "pais_eeuu": "Estados Unidos",
            "pais_brasil": "Brasil",
            
            // Footer
            "descripcion_footer": "Turismo sostenible en Cusco, respetando la cultura local y el medio ambiente.",
            "enlaces_rapidos": "Enlaces Rápidos",
            "politicas": "Políticas",
            "sostenibilidad": "Sostenibilidad",
            "terminos": "Términos y Condiciones",
            "privacidad": "Privacidad",
            "cancelaciones": "Cancelaciones",
            "direccion": "Cusco, Perú",
            "derechos_reservados": "Todos los derechos reservados"
        },
        
        en: {
            // Navigation
            "inicio": "Home",
            "destinos": "Destinations",
            "actividades": "Activities",
            "mapa": "Map",
            "reservas": "Bookings",
            "blog": "Blog",
            "contacto": "Contact",
            "iniciar_sesion": "Log In",
            "ingresar": "Log In",
            "registrate_aqui": "Sign up here",
            
            // Hero Section
            "titulo_hero": "Discover Cusco Sustainably",
            "subtitulo_hero": "Explore the magic of the Andes with respect for local culture and environment",
            "placeholder_buscar": "Search destinations, activities...",
            "texto_buscar": "Search",
            "destinos_sostenibles": "Sustainable Destinations",
            "valoracion_promedio": "Average Rating",
            "viajeros_satisfechos": "Satisfied Travelers",
            
            // Sections
            "destinos_destacados": "Featured Destinations",
            "ver_todos_destinos": "View all destinations",
            "explora_mapa": "Explore Our Destinations on the Map",
            "actividades_impacto": "Activities with Positive Impact",
            "prediccion_afluencia": "Tourist Traffic Prediction",
            "testimonios_viajeros": "What Our Travelers Say",
            
            // Filters
            "todas": "All",
            "cultural": "Cultural",
            "aventura": "Adventure",
            "naturaleza": "Nature",
            "comunitario": "Community",
            "filtrar_por": "Filter by:",
            "mi_ubicacion": "My location",
            "sostenible": "Sustainable",
            
            // Destination cards
            "moderada": "Moderate",
            "facil": "Easy",
            "dificil": "Difficult",
            "dia": "day",
            "grupos_pequenos": "Small groups",
            "desde": "From",
            "ver_detalles": "View details",
            "sello_verde": "Green Seal",
            "descripcion_machupicchu": "The world's most famous Inca citadel, explored with sustainable practices.",
            "descripcion_valle": "A tour of Andean villages and artisan markets in the valley.",
            "descripcion_montana": "A spectacular hike to one of Peru's natural wonders.",
            
            // Activities
            "actividad1_titulo": "Community Tourism",
            "actividad1_desc": "Live with local communities and directly support their economy.",
            "actividad2_titulo": "Ecological Hiking",
            "actividad2_desc": "Routes that minimize environmental impact and promote conservation.",
            "actividad3_titulo": "Reforestation",
            "actividad3_desc": "Participate in native species reforestation programs.",
            "actividad4_titulo": "Fair Trade",
            "actividad4_desc": "Direct purchase of handicrafts from local producers at fair prices.",
            "impacto_positivo": "+Impact",
            
            // Prediction
            "recomendaciones_hoy": "Today's Recommendations",
            "machupicchu_alta": "Machu Picchu: High traffic",
            "recomendacion_machupicchu": "Best time: Before 10am or after 2pm",
            "valle_media": "Sacred Valley: Medium traffic",
            "recomendacion_valle": "Ideal to visit throughout the day",
            "moray_baja": "Moray: Low traffic",
            "recomendacion_moray": "Excellent option to avoid crowds",
            "ver_prediccion_completa": "View full prediction",
            
            // Testimonials
            "testimonio1": "InkaTours allowed me to discover Cusco in an authentic and responsible way. The attention to sustainability is impressive.",
            "testimonio2": "The crowd prediction app was incredibly useful for planning our visits and avoiding crowds.",
            "testimonio3": "The focus on community tourism made our trip more meaningful. We'll be back!",
            "pais_espana": "Spain",
            "pais_eeuu": "United States",
            "pais_brasil": "Brazil",
            
            // Footer
            "descripcion_footer": "Sustainable tourism in Cusco, respecting local culture and the environment.",
            "enlaces_rapidos": "Quick Links",
            "politicas": "Policies",
            "sostenibilidad": "Sustainability",
            "terminos": "Terms and Conditions",
            "privacidad": "Privacy",
            "cancelaciones": "Cancellations",
            "direccion": "Cusco, Peru",
            "derechos_reservados": "All rights reserved"
        },
        
        qu: {
            // Navigation (Quechua)
            "inicio": "Qallariy",
            "destinos": "Destinokuna",
            "actividades": "Ruranakuna",
            "mapa": "Mapa",
            "reservas": "Reservakuna",
            "blog": "Blog",
            "contacto": "Contacto",
            "iniciar_sesion": "Yaykuy",
            "ingresar": "Yaykuy",
            "registrate_aqui": "Qillqay kaypi",
            
            // Hero Section
            "titulo_hero": "Cuscota Allin Kawsaywan Riqsichiy",
            "subtitulo_hero": "Andespa kuyasqanmanta riqsiy runa llaqtap kawsayninta, pachamamata respetaspa",
            "placeholder_buscar": "Maskay destinokuna, ruranakuna...",
            "texto_buscar": "Maskay",
            "destinos_sostenibles": "Allin Kawsay Destinokuna",
            "valoracion_promedio": "Promedio Puntuación",
            "viajeros_satisfechos": "Kuska Viajerokuna",
            
            // Sections
            "destinos_destacados": "Aswan Destinokuna",
            "ver_todos_destinos": "Tukuy destinokunata rikuy",
            "explora_mapa": "Mapapi Destinokunata Explorey",
            "actividades_impacto": "Allin Impactoyoq Ruranakuna",
            "prediccion_afluencia": "Turista Afluencia Predictción",
            "testimonios_viajeros": "Viajerokunap Rimaynin",
            
            // Filters
            "todas": "Tukuy",
            "cultural": "Cultural",
            "aventura": "Aventura",
            "naturaleza": "Naturaleza",
            "comunitario": "Comunitario",
            "filtrar_por": "Filtray:",
            "mi_ubicacion": "Noqap lugary",
            "sostenible": "Sostenible",
            
            // Destination cards
            "moderada": "Moderado",
            "facil": "Facil",
            "dificil": "Dificil",
            "dia": "p'unchaw",
            "grupos_pequenos": "Pisi grupokuna",
            "desde": "Manta",
            "ver_detalles": "Detallekunata rikuy",
            "sello_verde": "Qomer Sello",
            "descripcion_machupicchu": "Pachapi aswan riqsisqa Inka llaqta, allin kawsaywan explorasqa.",
            "descripcion_valle": "Vallepi runa llaqtakuna, qhatukuna visitay.",
            "descripcion_montana": "Perupa aswan sumaq pachamama maravillakunaman puriy.",
            
            // Activities
            "actividad1_titulo": "Comunidad Turismo",
            "actividad1_desc": "Runa llaqtakunawan kawsay, economíaninkuta yanapay.",
            "actividad2_titulo": "Allin Kawsay Puriy",
            "actividad2_desc": "Pachamamata waqllichispa puriyninkuna.",
            "actividad3_titulo": "Mallki Wiñaychiy",
            "actividad3_desc": "Qhepa mallkikunata wiñaychiy programakunapi.",
            "actividad4_titulo": "Allin Rantiy",
            "actividad4_desc": "Runa llaqtap ruranmanta allin chaninwan rantiy.",
            "impacto_positivo": "+Impacto",
            
            // Prediction
            "recomendaciones_hoy": "Kunan Punchaw Recomendaciones",
            "machupicchu_alta": "Machu Picchu: Achka turista",
            "recomendacion_machupicchu": "Allin hora: 10am pataman, 2pm qhipaman",
            "valle_media": "Valle Sagrado: Chaupi turista",
            "recomendacion_valle": "Tukuy punchaw visitana allin",
            "moray_baja": "Moray: Pisi turista",
            "recomendacion_moray": "Achka runakunamanta qispina allin",
            "ver_prediccion_completa": "Tukuy predictción rikuy",
            
            // Testimonials
            "testimonio1": "InkaTourswan Cuscota allin kawsaywan riqsirqani. Sustentabilidadpaq atenciónnin ancha sumaq.",
            "testimonio2": "Afluencia predictción appqa ancha allinmi karqan visitakunata planificarpaq, turista achka kaykunamanta.",
            "testimonio3": "Comunidad turismoqa viajeyta aswan significado-yoq ruwarqan. ¡Kutimusaq!",
            "pais_espana": "España",
            "pais_eeuu": "Estados Unidos",
            "pais_brasil": "Brasil",
            
            // Footer
            "descripcion_footer": "Cuscopi allin kawsay turismo, runa llaqtap cultura, pachamamata respetaspa.",
            "enlaces_rapidos": "Utqay Enlaces",
            "politicas": "Políticas",
            "sostenibilidad": "Sustentabilidad",
            "terminos": "Términos Condiciones",
            "privacidad": "Privacidad",
            "cancelaciones": "Cancelaciones",
            "direccion": "Cusco, Perú",
            "derechos_reservados": "Tukuy hayñikuna reservasqa"
        },
        
        pt: {
            // Navigation (Portuguese)
            "inicio": "Início",
            "destinos": "Destinos",
            "actividades": "Atividades",
            "mapa": "Mapa",
            "reservas": "Reservas",
            "blog": "Blog",
            "contacto": "Contato",
            "iniciar_sesion": "Entrar",
            "ingresar": "Entrar",
            "registrate_aqui": "Cadastre-se aqui",
            
            // Hero Section
            "titulo_hero": "Descubra Cusco de Forma Sustentável",
            "subtitulo_hero": "Explore a magia dos Andes com respeito pela cultura local e meio ambiente",
            "placeholder_buscar": "Buscar destinos, atividades...",
            "texto_buscar": "Buscar",
            "destinos_sostenibles": "Destinos Sustentáveis",
            "valoracion_promedio": "Avaliação Média",
            "viajeros_satisfechos": "Viajantes Satisfeitos",
            
            // Sections
            "destinos_destacados": "Destinos em Destaque",
            "ver_todos_destinos": "Ver todos os destinos",
            "explora_mapa": "Explore Nossos Destinos no Mapa",
            "actividades_impacto": "Atividades com Impacto Positivo",
            "prediccion_afluencia": "Previsão de Afluência Turística",
            "testimonios_viajeros": "O que Nossos Viajantes Dizem",
            
            // Filters
            "todas": "Todas",
            "cultural": "Cultural",
            "aventura": "Aventura",
            "naturaleza": "Natureza",
            "comunitario": "Comunitário",
            "filtrar_por": "Filtrar por:",
            "mi_ubicacion": "Minha localização",
            "sostenible": "Sustentável",
            
            // Destination cards
            "moderada": "Moderada",
            "facil": "Fácil",
            "dificil": "Difícil",
            "dia": "dia",
            "grupos_pequenos": "Pequenos grupos",
            "desde": "Desde",
            "ver_detalles": "Ver detalhes",
            "sello_verde": "Selo Verde",
            "descripcion_machupicchu": "A cidadela inca mais famosa do mundo, explorada com práticas sustentáveis.",
            "descripcion_valle": "Um passeio pelos povoados andinos e mercados artesanais do vale.",
            "descripcion_montana": "Uma caminhada espetacular para uma das maravilhas naturais do Peru.",
            
            // Activities
            "actividad1_titulo": "Turismo Comunitário",
            "actividad1_desc": "Viver com comunidades locais e apoiar diretamente sua economia.",
            "actividad2_titulo": "Caminhada Ecológica",
            "actividad2_desc": "Rotas que minimizam o impacto ambiental e promovem a conservação.",
            "actividad3_titulo": "Reflorestamento",
            "actividad3_desc": "Participe de programas de reflorestamento de espécies nativas.",
            "actividad4_titulo": "Comércio Justo",
            "actividad4_desc": "Compra direta de artesanatos de produtores locais a preços justos.",
            "impacto_positivo": "+Impacto",
            
            // Prediction
            "recomendaciones_hoy": "Recomendações para Hoje",
            "machupicchu_alta": "Machu Picchu: Alta afluência",
            "recomendacion_machupicchu": "Melhor horário: Antes das 10h ou depois das 14h",
            "valle_media": "Vale Sagrado: Afluência média",
            "recomendacion_valle": "Ideal para visitar durante todo o dia",
            "moray_baja": "Moray: Baixa afluência",
            "recomendacion_moray": "Excelente opção para evitar multidões",
            "ver_prediccion_completa": "Ver previsão completa",
            
            // Testimonials
            "testimonio1": "A InkaTours me permitiu conhecer Cusco de maneira autêntica e responsável. A atenção à sustentabilidade é impressionante.",
            "testimonio2": "O aplicativo de previsão de multidões foi incrivelmente útil para planejar nossas visitas e evitar aglomerações.",
            "testimonio3": "O foco no turismo comunitário tornou nossa viagem mais significativa. Voltaremos!",
            "pais_espana": "Espanha",
            "pais_eeuu": "Estados Unidos",
            "pais_brasil": "Brasil",
            
            // Footer
            "descripcion_footer": "Turismo sustentável em Cusco, respeitando a cultura local e o meio ambiente.",
            "enlaces_rapidos": "Links Rápidos",
            "politicas": "Políticas",
            "sostenibilidad": "Sustentabilidade",
            "terminos": "Termos e Condições",
            "privacidad": "Privacidade",
            "cancelaciones": "Cancelamentos",
            "direccion": "Cusco, Peru",
            "derechos_reservados": "Todos os direitos reservados"
        }
    },

    // Idioma actual
    idiomaActual: 'es',

    // Inicializar el sistema de idiomas
    init: function() {
        this.cargarIdiomaGuardado();
        this.actualizarInterfaz();
        this.inicializarEventos();
    },

    // Cargar idioma guardado en localStorage
    cargarIdiomaGuardado: function() {
        const idiomaGuardado = localStorage.getItem('inkatours-idioma');
        if (idiomaGuardado && this.traducciones[idiomaGuardado]) {
            this.idiomaActual = idiomaGuardado;
        }
        // Actualizar selector
        const selector = document.getElementById('language-select');
        if (selector) {
            selector.value = this.idiomaActual;
        }
    },

    // Cambiar idioma
    cambiarIdioma: function(nuevoIdioma) {
        if (this.traducciones[nuevoIdioma]) {
            this.idiomaActual = nuevoIdioma;
            localStorage.setItem('inkatours-idioma', nuevoIdioma);
            this.actualizarInterfaz();
            this.mostrarNotificacionIdioma(nuevoIdioma);
        }
    },

    // Obtener texto traducido
    t: function(key) {
        return this.traducciones[this.idiomaActual][key] || key;
    },

    // Actualizar toda la interfaz
    actualizarInterfaz: function() {
        this.actualizarTextos();
        this.actualizarAtributos();
    },

    // Actualizar textos en la página
    actualizarTextos: function() {
        // Textos normales
        const elementos = document.querySelectorAll('[data-i18n]');
        elementos.forEach(elemento => {
            const key = elemento.getAttribute('data-i18n');
            const traduccion = this.t(key);
            elemento.textContent = traduccion;
        });

        // Placeholders
        const placeholders = document.querySelectorAll('[data-i18n-placeholder]');
        placeholders.forEach(elemento => {
            const key = elemento.getAttribute('data-i18n-placeholder');
            elemento.placeholder = this.t(key);
        });

        // Valores de botones
        const botones = document.querySelectorAll('[data-i18n-value]');
        botones.forEach(elemento => {
            const key = elemento.getAttribute('data-i18n-value');
            elemento.value = this.t(key);
        });
    },

    // Actualizar atributos HTML (lang, etc.)
    actualizarAtributos: function() {
        document.documentElement.setAttribute('lang', this.idiomaActual);
    },

    // Inicializar eventos del selector de idioma
    inicializarEventos: function() {
        const selector = document.getElementById('language-select');
        if (selector) {
            selector.addEventListener('change', (e) => {
                this.cambiarIdioma(e.target.value);
            });
        }
    },

    // Mostrar notificación de cambio de idioma
    mostrarNotificacionIdioma: function(idioma) {
        const nombresIdiomas = {
            'es': 'Español',
            'en': 'English',
            'qu': 'Quechua',
            'pt': 'Português'
        };
        
        this.mostrarNotificacion(`Idioma cambiado a ${nombresIdiomas[idioma]}`, 'success');
    },

    // Función de notificación
    mostrarNotificacion: function(mensaje, tipo = 'info') {
        // Eliminar notificaciones anteriores
        document.querySelectorAll('.notification').forEach(notif => notif.remove());
        
        const notification = document.createElement('div');
        notification.className = `notification ${tipo}`;
        notification.innerHTML = `
            <span>${mensaje}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        `;
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            color: white;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease;
        `;
        
        const colors = {
            success: '#27AE60',
            error: '#E74C3C',
            info: '#3498DB',
            warning: '#F39C12'
        };
        
        notification.style.backgroundColor = colors[tipo] || colors.info;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 3000);
    }
};

// Agregar estas traducciones al objeto de traducciones
const translations = {
    es: {
        // ... tus traducciones existentes ...
        predicciones: "Predicciones",
        dashboard_afluencia: "Dashboard de Afluencia Turística",
        prediccion_afluencia: "Predicción de Afluencia",
        alertas_saturacion: "Alertas de Saturación",
        horarios_recomendados: "Horarios Recomendados",
        estado_sitios: "Estado de Sitios",
        mapa_afluencia: "Mapa de Afluencia",
        alternativas_sostenibles: "Alternativas Sostenibles",
        ver_detalles: "Ver detalles",
        hoy: "Hoy",
        manana: "Mañana",
        fin_semana: "Este fin de semana",
        prox_semana: "Próxima semana"
    },
    en: {
        // ... tus traducciones existentes ...
        predicciones: "Predictions",
        dashboard_afluencia: "Tourist Flow Dashboard",
        prediccion_afluencia: "Flow Prediction",
        alertas_saturacion: "Saturation Alerts",
        horarios_recomendados: "Recommended Times",
        estado_sitios: "Sites Status",
        mapa_afluencia: "Flow Map",
        alternativas_sostenibles: "Sustainable Alternatives",
        ver_detalles: "View details",
        hoy: "Today",
        manana: "Tomorrow",
        fin_semana: "This weekend",
        prox_semana: "Next week"
    },
    qu: {
        // ... tus traducciones existentes ...
        predicciones: "Watuchana",
        dashboard_afluencia: "Turista flow dashboard",
        prediccion_afluencia: "Flow watuchay",
        alertas_saturacion: "Saturación willaykuna",
        horarios_recomendados: "Allin pacha",
        estado_sitios: "Llaqtakuna estado",
        mapa_afluencia: "Flow mapa",
        alternativas_sostenibles: "Allin alternativa",
        ver_detalles: "Hunt'a rikuy",
        hoy: "Kunan p'unchay",
        manana: "Hamuq p'unchay",
        fin_semana: "Kay semana qhipa",
        prox_semana: "Hamuq semana"
    },
    pt: {
        // ... tus traducciones existentes ...
        predicciones: "Previsões",
        dashboard_afluencia: "Painel de Fluxo Turístico",
        prediccion_afluencia: "Previsão de Fluxo",
        alertas_saturacion: "Alertas de Saturação",
        horarios_recomendados: "Horários Recomendados",
        estado_sitios: "Status dos Locais",
        mapa_afluencia: "Mapa de Fluxo",
        alternativas_sostenibles: "Alternativas Sustentáveis",
        ver_detalles: "Ver detalhes",
        hoy: "Hoje",
        manana: "Amanhã",
        fin_semana: "Este fim de semana",
        prox_semana: "Próxima semana"
    }
};