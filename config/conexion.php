<?php
// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Datos de conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$password = '';
$base_datos = 'portal_anuncios';

// Crear conexión
$conn = new mysqli($host, $usuario, $password, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Configurar el juego de caracteres
$conn->set_charset("utf8");
?>
