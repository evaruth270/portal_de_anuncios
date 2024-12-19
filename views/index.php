<?php include '../partials/header.php'; ?>

<?php 
session_start(); // Asegúrate de que la sesión esté iniciada
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Anuncios</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="anuncios.php"><i class="fas fa-list"></i> Anuncios</a></li>
            <li><a href="publicar.php"><i class="fas fa-edit"></i> Publicar</a></li>
            <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
        </ul>
    </nav>

    <!-- Contenedor principal -->
    <div class="container">
        <!-- Mostrar notificaciones -->
        <?php if (!empty($_SESSION['notificaciones'])): ?>
            <div class="notificaciones">
                <h2 class="section-title">Estado de tus Anuncios</h2>
                <ul class="notification-list">
                    <?php foreach ($_SESSION['notificaciones'] as $notificacion): ?>
                        <li class="notification-item">
                            <strong><?= htmlspecialchars($notificacion['titulo']); ?></strong>: 
                            <?= htmlspecialchars($notificacion['estado']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Sección de bienvenida -->
        <div class="welcome-section">
            <h1 class="main-title">Bienvenido al Portal de Anuncios</h1>
            <p class="main-description">Explora los anuncios o publica el tuyo.</p>

            <!-- Botones -->
            <div class="button-group">
                <a href="anuncios.php" class="btn btn-primary">Ver Anuncios</a>
                <a href="publicar.php" class="btn btn-secondary">Publicar Anuncio</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Portal de Anuncios. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
