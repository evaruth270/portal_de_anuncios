<?php
require_once dirname(__DIR__) . '/config/conexion.php';

// Ruta del archivo de log
$logDir = dirname(__DIR__) . '/logs';
$logFile = $logDir . '/expirar_anuncios.log';

// Crear la carpeta logs si no existe
if (!file_exists($logDir)) {
    mkdir($logDir, 0777, true); // Crea la carpeta con permisos 0777
}

// Actualizar anuncios expirados
$sql = "UPDATE anuncios 
        SET estado = 'expirado', fecha_actualizacion = NOW() 
        WHERE estado = 'aprobado' AND fecha_expiracion < CURDATE()";

if ($conn->query($sql)) {
    // Guardar log de éxito
    file_put_contents($logFile, date("Y-m-d H:i:s") . " - Anuncios expirados actualizados correctamente.\n", FILE_APPEND);
} else {
    // Guardar error en el log
    file_put_contents($logFile, date("Y-m-d H:i:s") . " - Error: " . $conn->error . "\n", FILE_APPEND);
}

$conn->close();
?>
