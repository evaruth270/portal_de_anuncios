<?php
require_once '../config/conexion.php';
session_start();

// Verificar el pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pago'])) {
    $id_pago = $_POST['id_pago'];
    $sql = "UPDATE pagos SET estado = 'verificado' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_pago);
    $stmt->execute();
}

// Obtener pagos pendientes
$sql = "SELECT p.id, p.monto, p.fecha_pago, u.nombre 
        FROM pagos p
        JOIN usuarios u ON p.id_usuario = u.id
        WHERE p.estado = 'pendiente'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
</head>
<body>
    <h1>Pagos Pendientes</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Acción</th>
        </tr>
        <?php while ($pago = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $pago['id']; ?></td>
                <td><?= $pago['nombre']; ?></td>
                <td>S/. <?= $pago['monto']; ?></td>
                <td><?= $pago['fecha_pago']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id_pago" value="<?= $pago['id']; ?>">
                        <button type="submit">Verificar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
