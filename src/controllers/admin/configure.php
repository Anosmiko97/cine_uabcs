<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();

try {
    $id = $_REQUEST['id'];

    // Obtener los datos actuales del administrador para rellenar el formulario
    $stmt = $conn->prepare("SELECT * FROM admins WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        throw new Exception("Perfil no encontrado.");
    }

    // Procesar formulario si se recibe una solicitud POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $num_control = trim($_POST['num_control']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $photo = $_FILES['photo'] ?? null;

        // Validar campos vacíos
        if (empty($name) || empty($num_control) || empty($email)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Comprobar si los datos no han cambiado
        $changesMade = false;
        $updatedData = [];

        if ($name !== $admin['name']) {
            $updatedData['name'] = $name;
            $changesMade = true;
        }
        if ($num_control !== $admin['num_control']) {
            $updatedData['num_control'] = $num_control;
            $changesMade = true;
        }
        if ($email !== $admin['email']) {
            $updatedData['email'] = $email;
            $changesMade = true;
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

            $updatedData['photo'] = $photoPath;
            $changesMade = true;
        }

        // Si se proporciona una nueva contraseña, se encripta
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if ($hashedPassword !== $admin['password']) {
                $updatedData['password'] = $hashedPassword;
                $changesMade = true;
            }
        }

        // Comprobar privilegios y si han cambiado
        $billboard_privileges = isset($_POST['billboard_privileges']) ? 1 : 0;
        $events_privileges = isset($_POST['events_privileges']) ? 1 : 0;
        $system_privileges = isset($_POST['system_privileges']) ? 1 : 0;
        $register_privileges = isset($_POST['register_privileges']) ? 1 : 0;

        if ($billboard_privileges !== $admin['billboard_privileges']) {
            $updatedData['billboard_privileges'] = $billboard_privileges;
            $changesMade = true;
        }
        if ($events_privileges !== $admin['events_privileges']) {
            $updatedData['events_privileges'] = $events_privileges;
            $changesMade = true;
        }
        if ($system_privileges !== $admin['system_privileges']) {
            $updatedData['system_privileges'] = $system_privileges;
            $changesMade = true;
        }
        if ($register_privileges !== $admin['register_privileges']) {
            $updatedData['register_privileges'] = $register_privileges;
            $changesMade = true;
        }

        // Si no se realizaron cambios, enviar mensaje y redirigir
        if (!$changesMade) {
            session_start();
            $_SESSION['error'] = 'No se realizaron cambios en los datos del perfil.';
            header('Location: /admin/panel');
            exit;
        }

        // Actualizar datos en la base de datos si se detectaron cambios
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
            ':name' => $updatedData['name'] ?? $admin['name'],
            ':email' => $updatedData['email'] ?? $admin['email'],
            ':password' => $updatedData['password'] ?? $admin['password'],
            ':num_control' => $updatedData['num_control'] ?? $admin['num_control'],
            ':photo' => $updatedData['photo'] ?? $admin['photo'],
            ':billboard_privileges' => $updatedData['billboard_privileges'] ?? $admin['billboard_privileges'],
            ':events_privileges' => $updatedData['events_privileges'] ?? $admin['events_privileges'],
            ':system_privileges' => $updatedData['system_privileges'] ?? $admin['system_privileges'],
            ':register_privileges' => $updatedData['register_privileges'] ?? $admin['register_privileges'],
            ':id' => $id
        ]);

        session_start();
        $_SESSION['message'] = 'Perfil actualizado con éxito.';
        header('Location: /admin/panel');
        exit;
    }

} catch (PDOException $e) {
    session_start();
    $_SESSION['error'] = "Error al conectarse con la base de datos.";
    header('Location: /admin/panel');
    exit;
} catch (Exception $e) {
    session_start();
    $_SESSION['error'] = $e->getMessage();
    header('Location: /admin/panel');
    exit;
}
?>
