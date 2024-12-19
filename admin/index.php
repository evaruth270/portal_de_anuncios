<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'administrador') {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Barra de navegación -->
    <?php include '../partials/navbar.php'; ?>

    <!-- Contenido principal -->
    <div class="container">
        <h1 class="main-title">Bienvenido al Panel de Administración</h1>
        <div class="admin-panel">
            <ul>
                <li>
                    <a href="anuncios.php" class="admin-link">
                        <i class="fas fa-bullhorn"></i> Gestionar Anuncios
                    </a>
                </li>
                <li>
                    <a href="usuarios.php" class="admin-link">
                        <i class="fas fa-users"></i> Gestionar Usuarios
                    </a>
                </li>
                <li>
                    <a href="gestionar_expirados.php" class="admin-link">
                        <i class="fas fa-clock"></i> Gestionar Anuncios Expirados
                    </a>
                </li>
                <li>
                    <a href="../index.php" class="admin-link">
                        <i class="fas fa-home"></i> Volver al Sitio
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Pie de página -->
    <?php include '../partials/footer.php'; ?>
</body>
</html>
