<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($data['title'] ?? 'Iniciar Sesión - InkaTours'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2A6E3F; /* Color principal de la web */
            --light-gray-bg: #f5f5f5;
            --white-bg: #ffffff;
            --dark-text: #202124;
            --secondary-text: #5f6368;
            --border-color: #dadce0;
            --error-color: #d93025;
            --google-blue: #4285F4;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/Inkatours/static/img/destinos/cusco.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            background-color: var(--white-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 48px 40px 36px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 24px;
        }

        .logo-container h2 {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        
        .logo-container p {
            font-size: 16px;
            color: var(--secondary-text);
            margin-top: 8px;
        }
        
        .login-tabs {
            display: flex;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .tab-link {
            flex: 1;
            background: none;
            border: none;
            color: var(--secondary-text);
            padding: 15px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 3px solid transparent;
        }

        .tab-link.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            text-align: left;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 16px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-group input:focus {
            outline: none;
            border: 2px solid var(--primary-color);
            margin: -1px; /* To prevent layout shift */
        }
        
        .form-group .error-message {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 4px;
            display: block; /* Always reserve space */
            min-height: 1.2em; /* Prevent layout shift */
        }
        
        .form-group input.error {
            border-color: var(--error-color);
        }
        .form-group input.error:focus {
            border-width: 2px;
            margin: -1px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark, #1e5230);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: var(--secondary-text);
            font-size: 0.9rem;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background-color: var(--border-color);
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            background: var(--white);
            color: var(--secondary-text);
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .btn-google:hover {
            background-color: #f8f9fa;
        }
        .btn-google i {
            color: var(--google-blue);
            margin-right: 10px;
        }

        .btn-back-to-home {
            display: block;
            margin-top: 2rem;
            text-align: center;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <h2>InkaTours</h2>
            <p>Iniciar Sesión</p>
        </div>

        <div class="login-tabs">
            <button class="tab-link active" onclick="openTab(event, 'login')">Iniciar Sesión</button>
            <button class="tab-link" onclick="openTab(event, 'register')">Registrarse</button>
        </div>

        <!-- Login Tab -->
        <div id="login" class="tab-content active">
            <form action="/Inkatours/iniciosesion" method="post" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Correo electrónico" class="<?php echo (!empty($data['email_err'])) ? 'error' : ''; ?>" value="<?php echo e($data['email'] ?? ''); ?>" required>
                    <span class="error-message"><?php echo e($data['email_err'] ?? ''); ?></span>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Contraseña" class="<?php echo (!empty($data['password_err'])) ? 'error' : ''; ?>" required>
                    <span class="error-message"><?php echo e($data['password_err'] ?? ''); ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="login" value="Ingresar" class="btn-primary">
                </div>
            </form>
        </div>

        <!-- Register Tab -->
        <div id="register" class="tab-content">
            <form action="/Inkatours/iniciosesion" method="post" novalidate>
                 <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                 <div class="form-group">
                    <input type="text" name="nombre" placeholder="Nombre completo" class="<?php echo (!empty($data['nombre_err'])) ? 'error' : ''; ?>" required>
                    <span class="error-message"><?php echo e($data['nombre_err'] ?? ''); ?></span>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Correo electrónico" class="<?php echo (!empty($data['email_err'])) ? 'error' : ''; ?>" required>
                    <span class="error-message"><?php echo e($data['email_err'] ?? ''); ?></span>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Contraseña" class="<?php echo (!empty($data['password_err'])) ? 'error' : ''; ?>" required>
                    <span class="error-message"><?php echo e($data['password_err'] ?? ''); ?></span>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" placeholder="Confirmar contraseña" class="<?php echo (!empty($data['confirm_password_err'])) ? 'error' : ''; ?>" required>
                     <span class="error-message"><?php echo e($data['confirm_password_err'] ?? ''); ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="register" value="Registrarse" class="btn-primary">
                </div>
            </form>
        </div>
        
        <a href="/Inkatours/" class="btn-back-to-home">
            <i class="fas fa-arrow-left"></i> Regresar al Inicio
        </a>
    </div>

    <script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    // Logic to open the correct tab if there are registration errors
    document.addEventListener('DOMContentLoaded', () => {
        const hasRegisterErrors = <?php echo (
            !empty($data['nombre_err']) || 
            !empty($data['email_err']) || 
            !empty($data['password_err']) || 
            !empty($data['confirm_password_err'])
        ) ? 'true' : 'false'; ?>;

        if (hasRegisterErrors) {
            openTab(event, 'register');
            // Manually set active class if event is not available
            document.querySelector('.tab-link[onclick*="register"]').classList.add('active');
            document.querySelector('.tab-link[onclick*="login"]').classList.remove('active');
        } else {
            document.querySelector('.tab-link.active').click();
        }
    });
    </script>

</body>
</html>
