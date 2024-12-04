<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
session_start();

try {
    // Obtener el ID del administrador a eliminar
    $id = $_REQUEST['id'];
    $message = "";

    // Consulta SQL para eliminar el administrador
    $stmt = $conn->prepare("DELETE FROM admins WHERE id = :id");
    $stmt->execute([':id' => $id]);

    // Verificar si el administrador fue eliminado
    if ($stmt->rowCount() > 0) {
        $message = "Administrador eliminado con éxito.";
    } else {
        $message = "No se encontró ningún registro con ese ID.";
    }

    $_SESSION['message'] = $message;
    header('Location: /admin/usuarios');
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = "Error al eliminar el administrador.";
    header('Location: /admin/usuarios');
    exit;
}
?>
