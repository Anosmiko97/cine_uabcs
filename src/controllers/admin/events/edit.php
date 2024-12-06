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
    $info = trim($_REQUEST['info']);
    $place = trim($_REQUEST['place']);
    
    // Obtener datos actuales de la película 
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movie) {
        throw new Exception("Evento no encontrado.");
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

    // Preparar la consulta SQL con solo los campos que han sido modificados
    $updateFields = [];
    $params = [':id' => $id];

    // Verificar si el título fue modificado
    if ($title !== $events['title']) {
        $updateFields[] = "title = :title";
        $params[':title'] = $title;
    }

    // Verificar si la descripción fue modificada
    if ($description !== $events['description']) {
        $updateFields[] = "description = :description";
        $params[':description'] = $description;
    }

    // Verificar si la imagen fue modificada
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $updateFields[] = "img_route = :image";
        $params[':image'] = $imagePath;
    }

    if (empty($updateFields)) {
        throw new Exception("No se ha realizado ningún cambio.");
    }

    // Consulta para actualizar data
    $sql = "UPDATE events SET " . implode(", ", $updateFields) . " WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    // Responder con éxito
    session_start();
    $_SESSION['message'] = 'Evento actualizado con éxito';
    header('Location: /admin/eventos');
    exit;

} catch (PDOException $e) {
    session_start();
    $_SESSION['error'] = "Error al conectarse con la base de datos";
    header('Location: /admin/eventos');
    exit;
} catch (Exception $e) {
    session_start();
    $_SESSION['error'] = $e->getMessage();
    header('Location: /admin/eventos');
    exit;
}
?>
