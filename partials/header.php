<?php 
// Si aún no se ha iniciado la sesión, iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL del proyecto
$base_url = "/portal_anuncios";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Anuncios</title>
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">  <!-- Enlace al archivo CSS -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script> <!-- Para iconos (opcional) -->
</head>
<body>
