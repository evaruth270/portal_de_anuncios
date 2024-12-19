<?php
require_once '../config/conexion.php';
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?mensaje=debes_iniciar_sesion');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Anuncio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1 class="page-title">Publicar Anuncio</h1>
        <form action="../controllers/AnuncioController.php" method="POST" enctype="multipart/form-data" class="form-publicar">
            <input type="hidden" name="accion" value="publicar">
            
            <!-- Campo Título -->
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-input" required placeholder="Escribe el título del anuncio">
            </div>

            <!-- Campo Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-textarea" rows="5" required placeholder="Escribe una descripción detallada"></textarea>
            </div>

            <!-- Campo Precio -->
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" class="form-input" required placeholder="Ej. 100.50">
            </div>

            <!-- Campo Categoría -->
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" class="form-select" required>
                    <option value="" disabled selected>Selecciona una categoría</option>
                    <?php
                    // Cargar categorías desde la base de datos
                    $sql = "SELECT * FROM categorias";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Campo Imágenes -->
            <div class="form-group">
                <label for="imagenes">Imágenes (opcional, hasta 10):</label>
                <input type="file" id="imagenes" name="imagenes[]" class="form-file" multiple accept="image/*" title="Puedes subir hasta 10 imágenes">
            </div>

            <!-- Botón de Publicar -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Publicar Anuncio</button>
            </div>
        </form>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
