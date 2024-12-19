<?php
require_once '../config/conexion.php';

// Verificar si la sesión está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si el usuario ya está autenticado
if (isset($_SESSION['usuario_id'])) {
    $redireccion = ($_SESSION['usuario_rol'] === 'administrador') ? '../admin/index.php' : '../index.php';
    header("Location: $redireccion");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1 class="page-title">Iniciar Sesión</h1>

        <!-- Mensajes de estado -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($_GET['mensaje']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Inicio de Sesión -->
        <form action="../controllers/AuthController.php" method="POST" class="form-login">
            <input type="hidden" name="accion" value="login">
            
            <!-- Campo de Correo -->
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" class="form-input" required placeholder="ejemplo@correo.com">
            </div>
            
            <!-- Campo de Contraseña -->
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" class="form-input" required placeholder="********">
            </div>

            <!-- Botón de envío -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </div>
        </form>

        <!-- Enlace de Registro -->
        <p class="registro-text">
            ¿No tienes una cuenta? <a href="registro.php" class="link">Regístrate aquí</a>
        </p>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
