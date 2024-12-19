<?php
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'registro') {
        // Proceso de registro
        $nombre = htmlspecialchars($_POST['nombre']);
        $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
        $telefono = $_POST['telefono'];
        $contrasena = $_POST['contrasena'];

        if (!$correo) {
            header('Location: ../views/registro.php?mensaje=correo_invalido');
            exit;
        }

        if (strlen($contrasena) < 8) {
            header('Location: ../views/registro.php?mensaje=contrasena_corta');
            exit;
        }

        $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);
        $rol = 'usuario'; // Cambia a 'administrador' si es necesario

        $sql = "INSERT INTO usuarios (nombre, correo, telefono, contrasena, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $nombre, $correo, $telefono, $contrasena_hash, $rol);

        if ($stmt->execute()) {
            header('Location: ../views/login.php?mensaje=registro_exitoso');
        } else {
            header('Location: ../views/registro.php?mensaje=error_registro');
        }

        $stmt->close();

    } elseif ($accion === 'login') {
        // Proceso de inicio de sesión
        $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
        $contrasena = $_POST['contrasena'];

        if (!$correo || empty($contrasena)) {
            header('Location: ../views/login.php?mensaje=datos_invalidos');
            exit;
        }

        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($contrasena, $usuario['contrasena'])) {
                // Iniciar sesión
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol'] = $usuario['rol'];

                // Recuperar notificaciones de anuncios
                $notificaciones_sql = "SELECT titulo, estado FROM anuncios WHERE id_usuario = ? AND estado IN ('aprobado', 'rechazado', 'expirado')";
                $stmt_notificaciones = $conn->prepare($notificaciones_sql);
                $stmt_notificaciones->bind_param('i', $usuario['id']);
                $stmt_notificaciones->execute();
                $_SESSION['notificaciones'] = $stmt_notificaciones->get_result()->fetch_all(MYSQLI_ASSOC);

                // Redirigir según el rol
                if ($usuario['rol'] === 'administrador') {
                    header('Location: ../admin/index.php');
                } else {
                    header('Location: ../index.php');
                }
                exit;
            } else {
                header('Location: ../views/login.php?mensaje=contrasena_incorrecta');
                exit;
            }
        } else {
            header('Location: ../views/login.php?mensaje=correo_no_registrado');
            exit;
        }

        $stmt->close();
    }

    $conn->close();
}
?>


