<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "/xampp/htdocs/src/config/database.php";

    $conn = Db::getPDO();
    $moviesDir = '/xampp/htdocs/src/views/public/assets/media/movies/video/';
    $imagesDir = '/xampp/htdocs/src/views/public/assets/media/movies/img/';
    $error = null;

    try {
        $title = trim($_REQUEST['title'] ?? '');
        $description = trim($_REQUEST['description'] ?? '');
        $image = $_FILES['img_route'] ?? null;
        $file = $_FILES['movie_route'] ?? null;

        // Validar campos vacíos
        if (empty($title) || empty($description)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Validar archivos subidos
        if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen.");
        }
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir el archivo de la película.");
        }

        // Validar tipos de archivo
        $validImageTypes = ['image/jpeg', 'image/png'];
        $validVideoTypes = ['video/mp4'];
        if (!in_array($image['type'], $validImageTypes)) {
            throw new Exception("Formato de imagen no permitido. Solo se permiten JPG y PNG.");
        }
        if (!in_array($file['type'], $validVideoTypes)) {
            throw new Exception("Formato de video no permitido. Solo se permite MP4.");
        }

        // Generar rutas únicas para los archivos
        $imagePath = $imagesDir . uniqid('img_') . "_" . basename($image['name']);
        $filePath = $moviesDir . uniqid('vid_') . "_" . basename($file['name']);

        // Mover archivos a las carpetas correspondientes
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            throw new Exception("Error al mover la imagen.");
        }
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Error al mover el archivo de la película.");
        }

        // Insertar datos en la base de datos
        $stmt = $conn->prepare("INSERT INTO movies (title, description, img_route, movie_route) VALUES (:title, :description, :image, :file)");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':image' => $imagePath,
            ':file' => $filePath,
        ]);

        session_start();
        $_SESSION['message'] = "Película agregada con éxito.";
        header('Location: /admin/cartelera');
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' || isset($error)): ?>
    <?php require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php"; ?>

    <main class="p-2 text-center pt-5 d-flex justify-content-center">
        <form class="bg-white shadow rounded p-3 form" action="/admin/cartelera/agregar" 
              enctype="multipart/form-data" method="post" style="max-width: 400px;">
            <div class="text-center">
                <h4 class="text-center">Agregar película</h4>
            </div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div class="modal-body d-flex justify-content-center gap-4">
                <div>
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control" name="title" placeholder="Ingrese el título" value="<?= htmlspecialchars($_REQUEST['title'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="description" placeholder="Ingrese una descripción" value="<?= htmlspecialchars($_REQUEST['description'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen de película</label>
                        <input type="file" class="form-control" name="img_route">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Archivo de película</label>
                        <input type="file" class="form-control" name="movie_route">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn blue-btn">AGREGAR</button>
            </div>
        </form>
    </main>
<?php endif; ?>
