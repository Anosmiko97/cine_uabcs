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
    $image = $_FILES['img_route'];
    $file = $_FILES['movie_route'];

    // Validar subida de archivos
    if ($image['error'] !== UPLOAD_ERR_OK || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error al subir archivo.");
    }

    // Validar tipos de archivo 
    $validImageTypes = ['image/jpeg', 'image/png'];
    $validVideoTypes = ['video/mp4'];
    if (!in_array($image['type'], $validImageTypes)) {
        throw new Exception(message: "Formato de imagen no permitido.");
    } elseif (!in_array($file['type'], $validVideoTypes)) {
        throw new Exception(message: "Formato de video no permitido.");
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
    $_SESSION['error'] = 'Algo salio mal, intente de nuevo';
    header('Location: /admin/cartelera');
    exit;
}
?>
