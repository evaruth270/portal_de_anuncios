<?php
require_once '../config/conexion.php';
session_start(); // Asegúrate de que la sesión esté iniciada

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'publicar') {
        // Recibir datos del formulario
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['categoria'];
        $id_usuario = $_SESSION['usuario_id'];

        // Insertar el anuncio en la base de datos
        $sql = "INSERT INTO anuncios (titulo, descripcion, precio, id_categoria, id_usuario, estado) VALUES (?, ?, ?, ?, ?, 'pendiente')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdii', $titulo, $descripcion, $precio, $id_categoria, $id_usuario);

        if ($stmt->execute()) {
            $id_anuncio = $stmt->insert_id;

            // Procesar imágenes
            if (!empty($_FILES['imagenes']['name'][0])) {
                foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                    $nombre_imagen = $_FILES['imagenes']['name'][$key];
                    $nombre_unico = uniqid() . "_" . $nombre_imagen; // Nombre único para la imagen
                    $ruta_destino = "assets/uploads/anuncios/" . $nombre_unico; // Ruta relativa
                    $ruta_fisica = "../" . $ruta_destino; // Ruta física para mover el archivo
                    if (move_uploaded_file($tmp_name, $ruta_fisica)) {
                        $sql_imagen = "INSERT INTO imagenes_anuncios (id_anuncio, url_imagen) VALUES (?, ?)";
                        $stmt_imagen = $conn->prepare($sql_imagen);
                        $stmt_imagen->bind_param('is', $id_anuncio, $ruta_destino); // Guardar ruta relativa
                        $stmt_imagen->execute();
                    }
                }
            }

            // Redirigir con mensaje de éxito
            header('Location: ../views/anuncios.php?mensaje=publicado_exito');
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    $conn->close();
}
