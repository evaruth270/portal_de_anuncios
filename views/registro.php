<?php
// Cargar la conexión a la base de datos
require_once '../config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1 class="page-title">Registro de Usuario</h1>

        <!-- Mensajes de estado -->
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($_GET['mensaje']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Registro -->
        <form action="../controllers/AuthController.php" method="POST" class="form-register">
            <input type="hidden" name="accion" value="registro">
            
            <!-- Campo de Nombre -->
            <div class="form-group">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-input" required placeholder="Tu nombre completo">
            </div>

            <!-- Campo de Correo -->
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" class="form-input" required placeholder="ejemplo@correo.com">
            </div>

            <!-- Campo de Teléfono -->
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-input" required placeholder="Tu número de teléfono">
            </div>

            <!-- Campo de Contraseña -->
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" class="form-input" required placeholder="********">
            </div>

            <!-- Botón de envío -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrar</button>
            </div>
        </form>

        <p class="login-text">
            ¿Ya tienes una cuenta? <a href="login.php" class="link">Inicia sesión aquí</a>
        </p>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>



