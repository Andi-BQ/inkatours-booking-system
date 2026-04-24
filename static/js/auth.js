// ===== SISTEMA DE AUTENTICACIÓN =====

// Estado de autenticación
let isLoggedIn = false;
let currentUser = null;

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay una sesión activa en localStorage
    checkLoginStatus();
    
    // Configurar eventos del modal de login
    setupLoginModal();
    
    // Configurar menú de usuario
    setupUserMenu();
    
    // Configurar navegación entre páginas
    setupNavigation();
});

// Verificar estado de inicio de sesión
function checkLoginStatus() {
    const savedUser = localStorage.getItem('currentUser');
    if (savedUser) {
        currentUser = JSON.parse(savedUser);
        isLoggedIn = true;
        updateUIForLoggedInUser();
    }
}

// Configurar modal de inicio de sesión
function setupLoginModal() {
    const loginBtn = document.getElementById('login-btn');
    const modalOverlay = document.getElementById('login-modal-overlay');
    const modalClose = document.getElementById('modal-close');
    const loginForm = document.getElementById('login-form');
    const registerLink = document.getElementById('register-link');

    // Abrir modal al hacer clic en "Iniciar Sesión"
    if (loginBtn) {
        loginBtn.addEventListener('click', function() {
            modalOverlay.style.display = 'flex';
        });
    }

    // Cerrar modal
    if (modalClose) {
        modalClose.addEventListener('click', function() {
            modalOverlay.style.display = 'none';
        });
    }

    // Cerrar modal al hacer clic fuera de él
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                modalOverlay.style.display = 'none';
            }
        });
    }

    // Manejar envío del formulario de login
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            
            // Simular autenticación (en un caso real, esto se haría con el servidor)
            if (authenticateUser(email, password)) {
                // Inicio de sesión exitoso
                isLoggedIn = true;
                currentUser = {
                    name: email.split('@')[0],
                    email: email,
                    avatar: email.charAt(0).toUpperCase()
                };
                
                // Guardar en localStorage
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
                
                // Actualizar UI
                updateUIForLoggedInUser();
                
                // Cerrar modal
                if (modalOverlay) modalOverlay.style.display = 'none';
                
                // Mostrar mensaje de bienvenida
                showWelcomeMessage();
                
                // Limpiar formulario
                loginForm.reset();
            } else {
                // Error de autenticación
                alert('Correo electrónico o contraseña incorrectos. Por favor, inténtalo de nuevo.');
            }
        });
    }

    // Enlace de registro (simulado)
    if (registerLink) {
        registerLink.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Funcionalidad de registro en desarrollo. Por ahora, usa cualquier correo y contraseña para iniciar sesión.');
        });
    }
}

// Configurar menú de usuario
function setupUserMenu() {
    const userInfo = document.getElementById('user-info');
    const userDropdown = document.getElementById('user-dropdown');
    const logoutBtn = document.getElementById('logout-btn');

    // Mostrar/ocultar menú desplegable
    if (userInfo) {
        userInfo.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Cerrar sesión
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                logoutUser();
            });
        }

        // Cerrar menú al hacer clic fuera de él
        document.addEventListener('click', function() {
            if (userDropdown) userDropdown.style.display = 'none';
        });
    }
}

// Configurar navegación entre páginas
function setupNavigation() {
    // Marcar la página actual como activa en el menú
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.html')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// Autenticar usuario (simulación)
function authenticateUser(email, password) {
    // En una aplicación real, esto se conectaría a un servidor
    // Por ahora, aceptamos cualquier combinación no vacía
    return email.trim() !== '' && password.trim() !== '';
}

// Actualizar UI para usuario logueado
function updateUIForLoggedInUser() {
    if (isLoggedIn && currentUser) {
        // Ocultar botón de login
        const loginBtn = document.getElementById('login-btn');
        if (loginBtn) loginBtn.style.display = 'none';
        
        // Mostrar menú de usuario
        const userMenu = document.getElementById('user-menu');
        if (userMenu) userMenu.style.display = 'flex';
        
        // Actualizar información del usuario
        const userAvatar = document.getElementById('user-avatar');
        const userName = document.getElementById('user-name');
        const welcomeName = document.getElementById('welcome-name');
        
        if (userAvatar) userAvatar.textContent = currentUser.avatar;
        if (userName) userName.textContent = currentUser.name;
        if (welcomeName) welcomeName.textContent = currentUser.name;
    }
}

// Mostrar mensaje de bienvenida
function showWelcomeMessage() {
    const welcomeDiv = document.getElementById('user-welcome');
    if (welcomeDiv) {
        welcomeDiv.style.display = 'block';
        
        // Ocultar mensaje después de 5 segundos
        setTimeout(() => {
            welcomeDiv.style.display = 'none';
        }, 5000);
    }
}

// Cerrar sesión
function logoutUser() {
    isLoggedIn = false;
    currentUser = null;
    localStorage.removeItem('currentUser');
    
    // Ocultar menú de usuario
    const userMenu = document.getElementById('user-menu');
    if (userMenu) userMenu.style.display = 'none';
    
    // Mostrar botón de login
    const loginBtn = document.getElementById('login-btn');
    if (loginBtn) loginBtn.style.display = 'block';
    
    // Ocultar mensaje de bienvenida
    const welcomeDiv = document.getElementById('user-welcome');
    if (welcomeDiv) welcomeDiv.style.display = 'none';
    
    // Cerrar menú desplegable
    const userDropdown = document.getElementById('user-dropdown');
    if (userDropdown) userDropdown.style.display = 'none';
    
    alert('Has cerrado sesión correctamente.');
}

// Función global para verificar si el usuario está logueado
window.isUserLoggedIn = function() {
    return isLoggedIn;
};

// Función global para obtener información del usuario
window.getCurrentUser = function() {
    return currentUser;
};