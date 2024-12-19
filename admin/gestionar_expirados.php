<?php
require_once '../config/conexion.php';
session_start();

// Verificar rol de administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'administrador') {
    header('Location: ../index.php');
    exit;
}

// Obtener anuncios expirados
$sql = "SELECT id, titulo, descripcion, precio, fecha_expiracion FROM anuncios WHERE estado = 'expirado'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Anuncios Expirados</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1>Gestionar Anuncios Expirados</h1>
        <table border="1" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Fecha Expiración</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['titulo']); ?></td>
                        <td><?= htmlspecialchars($row['descripcion']); ?></td>
                        <td><?= htmlspecialchars($row['precio']); ?></td>
                        <td><?= htmlspecialchars($row['fecha_expiracion']); ?></td>
                        <td>
                            <form method="POST" action="eliminar_anuncio.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
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
