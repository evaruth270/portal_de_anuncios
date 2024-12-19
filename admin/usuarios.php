<?php
require_once '../config/conexion.php';
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'administrador') {
    header('Location: ../views/login.php');
    exit;
}

// Eliminar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
    $sql = "DELETE FROM usuarios WHERE id = ? AND rol != 'administrador'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
}

// Obtener lista de usuarios
$sql = "SELECT id, nombre, correo, telefono, rol FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1>Gestión de Usuarios</h1>

        <table border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id']); ?></td>
                        <td><?= htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?= htmlspecialchars($usuario['correo']); ?></td>
                        <td><?= htmlspecialchars($usuario['telefono']); ?></td>
                        <td><?= htmlspecialchars($usuario['rol']); ?></td>
                        <td>
                            <?php if ($usuario['rol'] !== 'administrador'): ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="id_usuario" value="<?= $usuario['id']; ?>">
                                    <button type="submit" name="eliminar_usuario">Eliminar</button>
                                </form>
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
{}
