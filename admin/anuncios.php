<?php
require_once '../config/conexion.php';
session_start();

// Verificar si el usuario tiene rol de administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'administrador') {
    header('Location: ../index.php');
    exit;
}

// Consultar anuncios pendientes
$sql = "SELECT a.*, c.nombre AS categoria, u.nombre AS usuario
        FROM anuncios a
        JOIN categorias c ON a.id_categoria = c.id
        JOIN usuarios u ON a.id_usuario = u.id
        WHERE a.estado = 'pendiente'";
$result = $conn->query($sql);

// Procesar la aprobación o rechazo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $id_anuncio = $_POST['id_anuncio'];

    if ($accion === 'aprobar') {
        $monto_pagado = $_POST['monto_pagado'];
        $dias_publicacion = $monto_pagado; // 1 sol = 1 día

        $fecha_actual = date('Y-m-d');
        $fecha_expiracion = date('Y-m-d', strtotime("+$dias_publicacion days"));

        $sql_aprobar = "UPDATE anuncios SET estado = 'aprobado', fecha_creacion = ?, fecha_actualizacion = ?, fecha_expiracion = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_aprobar);
        $stmt->bind_param('sssi', $fecha_actual, $fecha_actual, $fecha_expiracion, $id_anuncio);
        $stmt->execute();
    } elseif ($accion === 'rechazar') {
        $sql_rechazar = "UPDATE anuncios SET estado = 'rechazado', fecha_actualizacion = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql_rechazar);
        $stmt->bind_param('i', $id_anuncio);
        $stmt->execute();
    }

    header('Location: anuncios.php?mensaje=accion_realizada');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Anuncios</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1>Gestión de Anuncios Pendientes</h1>

        <?php if (isset($_GET['mensaje'])): ?>
            <p><?= htmlspecialchars($_GET['mensaje']); ?></p>
        <?php endif; ?>

        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($anuncio = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($anuncio['titulo']); ?></td>
                        <td><?= htmlspecialchars($anuncio['descripcion']); ?></td>
                        <td>S/. <?= htmlspecialchars($anuncio['precio']); ?></td>
                        <td><?= htmlspecialchars($anuncio['categoria']); ?></td>
                        <td><?= htmlspecialchars($anuncio['usuario']); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="id_anuncio" value="<?= $anuncio['id']; ?>">
                                <input type="hidden" name="accion" value="aprobar">
                                <label for="monto_pagado">Monto Pagado (S/.):</label>
                                <input type="number" name="monto_pagado" min="1" required>
                                <button type="submit">Aprobar</button>
                            </form>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="id_anuncio" value="<?= $anuncio['id']; ?>">
                                <input type="hidden" name="accion" value="rechazar">
                                <button type="submit">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
