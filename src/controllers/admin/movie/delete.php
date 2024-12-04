<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();

try {
    $id = $_REQUEST['id'];
    $movie_route = 'C:' . $_REQUEST['movie_route'];
    $img_route = 'C:' . $_REQUEST["img_route"];
    var_dump( $img_route);

    // Eliminar video
    if (file_exists($movie_route)) {
        if (unlink($movie_route) ) {
            echo "Archivo eliminado vide o con éxito.";
        } else {
            echo "No se pudo eliminar video el archivo.";
        }
    } else {
        echo "El archivo video no existe.";
    }

    
    // Eliminar archivos imagen
    if (file_exists($img_route)) {
        if (unlink($img_route)) {
            echo "Archivo eliminado con éxito.";
        } else {
            echo "No se pudo eliminar el archivo.";
        }
    } else {
        echo "El archivo no existe.";
    }

    // Consulta sql
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo "Registro eliminado con éxito.";
    } else {
        echo "No se encontró ningún registro con el ID especificado.";
    } 
} catch (PDOException $e) {
    echo "Error al eliminar el registro: " . $e->getMessage();
}
