<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "/xampp/htdocs/src/config/database.php";

    $conn = Db::getPDO();
    $error = null;

    try {
        // Obtener datos del formulario
        $name = trim($_POST['name'] ?? '');
        $num_control = trim($_POST['num_control'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $billboard_privileges = isset($_POST['billboard_privileges']) ? 1 : 0;
        $events_privileges = isset($_POST['events_privileges']) ? 1 : 0;
        $system_privileges = isset($_POST['system_privileges']) ? 1 : 0;
        $register_privileges = isset($_POST['register_privileges']) ? 1 : 0;
        $photo = $_FILES['photo'] ?? null;

        // Validar campos vacíos
        if (empty($name) || empty($num_control) || empty($email) || empty($password)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Validar archivo de imagen
        $photoPath = null;
        if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
            $validImageTypes = ['image/jpeg', 'image/png'];
            if (!in_array($photo['type'], $validImageTypes)) {
                throw new Exception("Formato de imagen no permitido. Solo se permiten JPG y PNG.");
            }

            // Generar ruta única para la foto
            $photosDir = '/xampp/htdocs/src/views/public/admin/assets/media/users/';
            $photoPath = $photosDir . uniqid('photo_') . "_" . basename($photo['name']);
            if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
                throw new Exception("Error al mover la imagen.");
            }
        } else {
            $photoPath = '/xampp/htdocs/src/views/public/admin/assets/media/users/default.webp';
        }

        // Encriptar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar datos en la base de datos
        $sql = "INSERT INTO admins (name, email, password, num_control, photo, 
                                    billboard_privileges, events_privileges, 
                                    system_privileges, register_privileges) 
                VALUES (:name, :email, :password, :num_control, :photo, 
                        :billboard_privileges, :events_privileges, 
                        :system_privileges, :register_privileges)";
        
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
        ]);

        session_start();
        $_SESSION['message'] = "Administrador registrado con éxito.";
        header('Location: /admin/usuarios');
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' || isset($error)): ?>
    <?php require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php"; ?>

    <main class="p-2 text-center pt-5 d-flex justify-content-center">
        <form class="bg-white shadow rounded p-3 form" action="/admin/usuarios/agregar" 
              enctype="multipart/form-data" method="post" style="max-width: 80%;">
            <div class="text-center">
                <h4 class="text-center border-bottom pb-2 mb-2">Registrar Nuevo Administrador</h4>
            </div>
            <div class="modal-body gap-4">
                <div class="d-flex justify-content-center">
                    <div class="Container">
                        <!-- Nombre -->
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="name" placeholder="Ingrese el nombre" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        </div>

                        <!-- Número de Control -->
                        <div class="mb-3">
                            <label class="form-label">Número de Control</label>
                            <input type="text" class="form-control" name="num_control" placeholder="Número de control" value="<?= htmlspecialchars($_POST['num_control'] ?? '') ?>">
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" placeholder="Correo electrónico" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" placeholder="Ingrese la contraseña">
                        </div>
                    </div>

                    <div class="container">
                        <!-- Privilegios -->
                        <div class="mb-3">
                            <label class="form-label">Privilegios en la Cartelera</label>
                            <input type="checkbox" class="form-check-input" name="billboard_privileges" <?= isset($_POST['billboard_privileges']) ? 'checked' : '' ?>>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Privilegios en Eventos</label>
                            <input type="checkbox" class="form-check-input" name="events_privileges" <?= isset($_POST['events_privileges']) ? 'checked' : '' ?>>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Privilegios en el Sistema</label>
                            <input type="checkbox" class="form-check-input" name="system_privileges" <?= isset($_POST['system_privileges']) ? 'checked' : '' ?>>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Privilegios para Registrar</label>
                            <input type="checkbox" class="form-check-input" name="register_privileges" <?= isset($_POST['register_privileges']) ? 'checked' : '' ?>>
                        </div>

                        <!-- Foto -->
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" class="form-control" name="photo">
                            <small>Deje en blanco si no desea subir una foto</small>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div class="text-center mt-2 border-top pt-2">
                <button type="submit" class="btn btn-success">Registrar Administrador</button>
            </div>
        </form>
    </main>
<?php endif; ?>
