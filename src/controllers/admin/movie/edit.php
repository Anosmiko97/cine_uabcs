<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
$moviesDir = '/xampp/htdocs/src/views/public/assets/media/movies/video/';
$imagesDir = '/xampp/htdocs/src/views/public/assets/media/movies/img/';

try {
    // Datos de la solicitud
    $id = $_REQUEST['id'];
    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];
    $image = $_FILES['img_route'];
    $file = $_FILES['movie_route'];

    // Validar subida de archivos
    if ($image['error'] !== UPLOAD_ERR_OK || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error al subir los archivos.");
    }

    // Validar tipos de archivo 
    $validImageTypes = ['image/jpeg', 'image/png'];
    $validVideoTypes = ['video/mp4'];
    if (!in_array($image['type'], $validImageTypes) || !in_array($file['type'], $validVideoTypes)) {
        throw new Exception("Tipo de archivo no permitido.");
    }

    // Generar rutas únicas para evitar sobrescribir archivos
    $imagePath = $imagesDir . uniqid('img_') . "_" . basename($image['name']);
    $filePath = $moviesDir . uniqid('vid_') . "_" . basename($file['name']);

    // Mover archivos a sus respectivas carpetas
    if (!move_uploaded_file($image['tmp_name'], $imagePath) || !move_uploaded_file($file['tmp_name'], $filePath)) {
        throw new Exception("Error al mover los archivos.");
    }

    // Actualizar datos en la base de datos
    $stmt = $conn->prepare("UPDATE movies SET title = :title, description = :description, img_route = :image, movie_route = :file WHERE id = :id");
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':image' => $imagePath,
        ':file' => $filePath,
        ':id' => $id
    ]);

    echo "Película actualizada con éxito.";

} catch (PDOException $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
} catch (Exception $e) {
    error_log($e->getMessage());
    echo $e->getMessage();
}
