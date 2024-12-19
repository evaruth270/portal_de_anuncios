<?php
require_once '../config/conexion.php';
session_start(); // Asegúrate de que la sesión esté iniciada

// Obtener filtros
$categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : null;

// Consultar anuncios aprobados
$sql = "SELECT a.*, c.nombre AS categoria, u.nombre AS usuario FROM anuncios a
        JOIN categorias c ON a.id_categoria = c.id
        JOIN usuarios u ON a.id_usuario = u.id
        WHERE a.estado = 'aprobado'";
if ($categoria_id) {
    $sql .= " AND a.id_categoria = ?";
}

$stmt = $conn->prepare($sql);
if ($categoria_id) {
    $stmt->bind_param('i', $categoria_id);
}
$stmt->execute();
$result = $stmt->get_result();

// Preparar consulta para imágenes
$imagenes_sql = "SELECT url_imagen FROM imagenes_anuncios WHERE id_anuncio = ?";
$imagenes_stmt = $conn->prepare($imagenes_sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Anuncios</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <div class="container">
        <h1 class="page-title">Lista de Anuncios</h1>

        <!-- Filtros -->
        <form method="GET" action="anuncios.php" class="filter-form">
            <label for="categoria">Filtrar por Categoría:</label>
            <select name="categoria" id="categoria" class="filter-select">
                <option value="">Todas</option>
                <?php
                $categorias = $conn->query("SELECT * FROM categorias");
                while ($row = $categorias->fetch_assoc()) {
                    $selected = ($row['id'] == $categoria_id) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['nombre']}</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>

        <!-- Listado de Anuncios -->
        <div class="anuncios-list">
            <?php while ($anuncio = $result->fetch_assoc()): ?>
                <div class="anuncio-card">
                    <h2 class="anuncio-title"><?= htmlspecialchars($anuncio['titulo']); ?></h2>
                    <p class="anuncio-detail"><strong>Categoría:</strong> <?= htmlspecialchars($anuncio['categoria']); ?></p>
                    <p class="anuncio-detail"><strong>Precio:</strong> S/. <?= htmlspecialchars($anuncio['precio']); ?></p>
                    <p class="anuncio-detail"><strong>Publicado por:</strong> <?= htmlspecialchars($anuncio['usuario']); ?></p>
                    <p class="anuncio-description"><?= nl2br(htmlspecialchars($anuncio['descripcion'])); ?></p>
                    
                    <!-- Mostrar imágenes -->
                    <div class="anuncio-images">
                        <?php
                        $imagenes_stmt->bind_param('i', $anuncio['id']);
                        $imagenes_stmt->execute();
                        $imagenes_result = $imagenes_stmt->get_result();
                        while ($imagen = $imagenes_result->fetch_assoc()):
                        ?>
                            <img src="/portal_anuncios/<?= htmlspecialchars($imagen['url_imagen']); ?>" alt="Imagen del anuncio" class="anuncio-image">
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>
