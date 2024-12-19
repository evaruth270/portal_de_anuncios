<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL del proyecto
$base_url = "/portal_anuncios";
?>

<nav class="navbar">
    <ul class="navbar-menu">
        <!-- Inicio -->
        <li class="navbar-item">
            <a href="<?= htmlspecialchars($base_url) ?>/index.php" class="navbar-link">
                <i class="fas fa-home"></i> Inicio
            </a>
        </li>

        <!-- Anuncios -->
        <li class="navbar-item">
            <a href="<?= htmlspecialchars($base_url) ?>/views/anuncios.php" class="navbar-link">
                <i class="fas fa-bullhorn"></i> Anuncios
            </a>
        </li>

        <!-- Publicar -->
        <li class="navbar-item">
            <a href="<?= htmlspecialchars($base_url) ?>/views/publicar.php" class="navbar-link">
                <i class="fas fa-plus-square"></i> Publicar
            </a>
        </li>

        <!-- Login o Cerrar Sesión -->
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <li class="navbar-item">
                <a href="<?= htmlspecialchars($base_url) ?>/logout.php" class="navbar-link">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión (<?= htmlspecialchars($_SESSION['usuario_nombre']); ?>)
                </a>
            </li>
        <?php else: ?>
            <li class="navbar-item">
                <a href="<?= htmlspecialchars($base_url) ?>/views/login.php" class="navbar-link">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
