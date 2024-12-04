<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
session_start();

try {
    $id = $_REQUEST['id'];
    $movie_route = 'C:' . $_REQUEST['movie_route'];
    $img_route = 'C:' . $_REQUEST["img_route"];
    $message = "";

    // Eliminar video
    if (file_exists($movie_route)) {
        if (unlink($movie_route)) {
            $message = "Pelicula eliminada con éxito. ";
        } else {
            $message = "No se pudo eliminar el archivo de video. ";
        }
    } else {
        $message = "El archivo de video no existe. ";
    }

    // Eliminar imagen
    if (file_exists($img_route)) {
        if (unlink($img_route)) {
            $message = "Pelicula eliminada con éxito. ";
        } else {
            $message = "No se pudo eliminar el archivo de imagen. ";
        }
    } else {
        $message = "El archivo de imagen no existe. ";
    }

    // Consulta SQL para eliminar registro
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        $message = "Pelicula eliminada con éxito. ";
    } else {
        $message = "No se encontró ningún el registro.";
    }

    $_SESSION['message'] = $message;
    header('Location: /admin/cartelera');
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = "Error al eliminar el registro ";
    header('Location: /admin/cartelera');
    exit;
}

