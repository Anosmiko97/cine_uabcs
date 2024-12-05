<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
$moviesDir = '/xampp/htdocs/src/views/public/assets/media/movies/video/';
$imagesDir = '/xampp/htdocs/src/views/public/assets/media/movies/img/';

try {
    // Datos de la solicitud
    $id = $_REQUEST['id'];
    $title = trim($_REQUEST['title']);
    $description = trim($_REQUEST['description']);
    
    // Obtener datos actuales de la película 
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movie) {
        throw new Exception("Película no encontrada.");
    }

    // Inicializar las variables de archivo
    $image = isset($_FILES['img_route']) ? $_FILES['img_route'] : null;
    $file = isset($_FILES['movie_route']) ? $_FILES['movie_route'] : null;

    // Validar subida de imagen
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $validImageTypes = ['image/jpeg', 'image/png'];
        if (!in_array($image['type'], $validImageTypes)) {
            throw new Exception("Formato de imagen no permitido.");
        }
        // Generar ruta única para la imagen
        $imagePath = $imagesDir . uniqid('img_') . "_" . basename($image['name']);
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            throw new Exception("Error al mover la imagen.");
        }
    } else {
        $imagePath = $movie['img_route'];
    }

    // Validar subida de video
    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $validVideoTypes = ['video/mp4'];
        if (!in_array($file['type'], $validVideoTypes)) {
            throw new Exception("Formato de video no permitido.");
        }
        // Generar ruta única para el archivo de película
        $filePath = $moviesDir . uniqid('vid_') . "_" . basename($file['name']);
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Error al mover el archivo de video.");
        }
    } else {
        $filePath = $movie['movie_route'];
    }

    // Preparar la consulta SQL con solo los campos que han sido modificados
    $updateFields = [];
    $params = [':id' => $id];

    // Verificar si el título fue modificado
    if ($title !== $movie['title']) {
        $updateFields[] = "title = :title";
        $params[':title'] = $title;
    }

    // Verificar si la descripción fue modificada
    if ($description !== $movie['description']) {
        $updateFields[] = "description = :description";
        $params[':description'] = $description;
    }

    // Verificar si la imagen fue modificada
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $updateFields[] = "img_route = :image";
        $params[':image'] = $imagePath;
    }

    // Verificar si el archivo de película fue modificado
    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $updateFields[] = "movie_route = :file";
        $params[':file'] = $filePath;
    }

    if (empty($updateFields)) {
        throw new Exception("No se ha realizado ningún cambio.");
    }

    // Consulta para actualizar data
    $sql = "UPDATE movies SET " . implode(", ", $updateFields) . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Responder con éxito
    session_start();
    $_SESSION['message'] = 'Película actualizada con éxito';
    header('Location: /admin/cartelera');
    exit;

} catch (PDOException $e) {
    session_start();
    $_SESSION['error'] = "Error al conectarse con la base de datos";
    header('Location: /admin/cartelera');
    exit;
} catch (Exception $e) {
    session_start();
    $_SESSION['error'] = $e->getMessage();
    header('Location: /admin/cartelera');
    exit;
}
?>
