<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
session_start();

try {
    $id = $_REQUEST['id'];
    $img_route = 'C:' . $_REQUEST["img_route"];
    $message = "";


    // Eliminar imagen
    if (file_exists($img_route)) {
        if (unlink($img_route)) {
            $message = "Evento eliminada con éxito. ";
        } else {
            $message = "No se pudo eliminar el archivo de imagen. ";
        }
    } else {
        $message = "El archivo de imagen no existe. ";
    }

    // Consulta SQL para eliminar registro
    $stmt = $conn->prepare("DELETE FROM events WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        $message = "Evento eliminado con éxito. ";
    } else {
        $message = "No se encontró ningún el registro.";
    }
    
    $_SESSION['message'] = $message;
    header('Location: /admin/eventos');
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = "Error al eliminar el registro ";
    header('Location: /admin/eventos');
    exit;
}

