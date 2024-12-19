<?php
require_once '../config/conexion.php';
session_start();

// Verificar rol de administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'administrador') {
    header('Location: ../index.php');
    exit;
}

// Verificar si se recibe el ID
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Eliminar el anuncio de la base de datos
    $sql = "DELETE FROM anuncios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Anuncio eliminado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el anuncio.";
    }

    $stmt->close();
} else {
    $_SESSION['mensaje'] = "ID de anuncio no válido.";
}

$conn->close();
header('Location: gestionar_expirados.php');
exit;
?>
