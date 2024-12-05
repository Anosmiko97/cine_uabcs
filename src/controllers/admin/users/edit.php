<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();

try {
    $id = $_POST['id'];  

    // Obtener los datos actuales del administrador para rellenar el formulario
    $stmt = $conn->prepare("SELECT * FROM admins WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        throw new Exception("Administrador no encontrado.");
    }

    // Procesar formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $num_control = trim($_POST['num_control']);
        $email = trim($_POST['email']);
        $password = $_POST['password']; 
        $billboard_privileges = isset($_POST['billboard_privileges']) ? 1 : 0;
        $events_privileges = isset($_POST['events_privileges']) ? 1 : 0;
        $system_privileges = isset($_POST['system_privileges']) ? 1 : 0;
        $register_privileges = isset($_POST['register_privileges']) ? 1 : 0;
        $photo = $_FILES['photo'] ?? null;

        // Validar campos vacíos
        if (empty($name) || empty($num_control) || empty($email)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Validar archivo de foto (si se sube uno nuevo)
        $photoPath = $admin['photo']; 
        if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
            $validImageTypes = ['image/jpeg', 'image/png'];
            if (!in_array($photo['type'], $validImageTypes)) {
                throw new Exception("Formato de imagen no permitido. Solo se permiten JPG y PNG.");
            }

            // Generar ruta única para la nueva foto
            $photosDir = '/xampp/htdocs/src/views/public/admin/assets/media/photo/';
            $photoPath = $photosDir . uniqid('photo_') . "_" . basename($photo['name']);
            if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
                throw new Exception("Error al mover la imagen.");
            }
        }

        // Si se proporciona una nueva contraseña, se encripta
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashedPassword = $admin['password'];
        }

        // Verificar si los datos han cambiado
        $isDataChanged = false;
        if ($name !== $admin['name']) {
            $isDataChanged = true;
        }
        if ($num_control !== $admin['num_control']) {
            $isDataChanged = true;
        }
        if ($email !== $admin['email']) {
            $isDataChanged = true;
        }
        if ($password && password_verify($password, $admin['password'])) {
            $isDataChanged = true;
        }
        if ($photo && $photo['name'] !== $admin['photo']) {
            $isDataChanged = true;
        }
        if ($billboard_privileges !== $admin['billboard_privileges']) {
            $isDataChanged = true;
        }
        if ($events_privileges !== $admin['events_privileges']) {
            $isDataChanged = true;
        }
        if ($system_privileges !== $admin['system_privileges']) {
            $isDataChanged = true;
        }
        if ($register_privileges !== $admin['register_privileges']) {
            $isDataChanged = true;
        }

        if ($isDataChanged) {
            // Actualizar datos en la base de datos
            $sql = "UPDATE admins SET 
                        name = :name, 
                        email = :email, 
                        password = :password, 
                        num_control = :num_control, 
                        photo = :photo, 
                        billboard_privileges = :billboard_privileges, 
                        events_privileges = :events_privileges, 
                        system_privileges = :system_privileges, 
                        register_privileges = :register_privileges 
                    WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':num_control' => $num_control,
                ':photo' => $photoPath,
                ':billboard_privileges' => $billboard_privileges,
                ':events_privileges' => $events_privileges,
                ':system_privileges' => $system_privileges,
                ':register_privileges' => $register_privileges,
                ':id' => $id
            ]);

            session_start();
            $_SESSION['message'] = 'Administrador actualizado con éxito.';
            header('Location: /admin/usuarios');
            exit;
        } else {
            session_start();
            $_SESSION['message'] = 'No se realizaron cambios en los datos del administrador.';
            header('Location: /admin/usuarios');
            exit;
        }

    }

} catch (PDOException $e) {
    session_start();
    $_SESSION['error'] = "Error al conectarse con la base de datos.";
    header('Location: /admin/usuarios');
    exit;
} catch (Exception $e) {
    session_start();
    $_SESSION['error'] = $e->getMessage();
    header('Location: /admin/usuarios');
    exit;
}
?>
