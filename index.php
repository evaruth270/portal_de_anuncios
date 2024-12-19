<?php
// Incluir script para expirar anuncios automáticamente
include_once 'cron/expirar_anuncios.php';

// Cargar la conexión a la base de datos
require_once 'config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Anuncios</title>
    <!-- Estilos -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Header con barra de navegación -->
    <header>
        <?php include 'partials/navbar.php'; ?>
    </header>

    <!-- Contenido Principal -->
    <main class="container">
        <!-- Sección de Contacto y QR -->
        <section class="contact-section">
            <div class="contact-info">
                <p>
                    <i class="fas fa-phone fa-bounce"></i> Cel: <strong>921836263</strong> |
                    <i class="fas fa-money-bill-wave fa-shake"></i> Yape: <strong>902581144</strong>
                </p>
            </div>
            <div class="qr-container">
                <p>Escanea para Yape:</p>
                <img src="assets/img/qr_yape.png" alt="QR de Yape" class="qr-code" onclick="openModal(this)">
            </div>
        </section>

        <!-- Modal para ampliar QR -->
        <div id="modal" class="modal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img class="modal-content" id="modalImage">
        </div>

        <!-- Botón de WhatsApp -->
        <section class="whatsapp-btn">
            <a href="https://wa.me/921836263" target="_blank" class="btn btn-whatsapp" aria-label="Contactar por WhatsApp">
                <i class="fab fa-whatsapp fa-fade"></i> Contactar por WhatsApp
            </a>
        </section>

        <!-- Sección de Bienvenida -->
        <section class="welcome-section">
            <h1 class="main-title">Bienvenido al Portal de Anuncios</h1>
            <p class="main-description">Explora los anuncios o publica el tuyo.</p>

            <!-- Botones de Acciones -->
            <div class="actions">
                <a href="views/anuncios.php" class="btn btn-primary" aria-label="Ver Anuncios">
                    <i class="fas fa-bullhorn"></i> Ver Anuncios
                </a>
                <a href="views/publicar.php" class="btn btn-secondary" aria-label="Publicar Anuncio">
                    <i class="fas fa-plus-square"></i> Publicar Anuncio
                </a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <?php include 'partials/footer.php'; ?>
    </footer>

    <!-- Script para Modal -->
    <script>
        function openModal(img) {
            document.getElementById("modal").style.display = "block";
            document.getElementById("modalImage").src = img.src;
        }
        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }
    </script>
</body>
</html>
