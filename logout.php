<?php
session_start(); // Iniciar la sesión
session_unset(); // Limpiar todas las variables de sesión
session_destroy(); // Destruir la sesión actual

// Redirigir al inicio de sesión
header('Location: views/login.php?mensaje=sesion_cerrada');
exit;
?>
