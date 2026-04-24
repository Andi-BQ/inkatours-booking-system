<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="/Inkatours/static/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            background: #fff;
            padding: 3rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h1 {
            margin-bottom: 1rem;
            color: var(--dark);
        }
        .login-container p {
            margin-bottom: 2rem;
            color: var(--gray);
        }
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
        }
        .btn-primary {
            width: 100%;
            padding: 1rem;
        }
        .error-message {
            color: #e74c3c;
            background-color: #fdd;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Acceso de Administrador</h1>
        <p>Por favor, ingrese sus credenciales.</p>

        <?php if (!empty($data['error'])): ?>
            <div class="error-message"><?php echo $data['error']; ?></div>
        <?php endif; ?>

        <form action="/Inkatours/admin/authenticate" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</body>
</html>
