<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "/xampp/htdocs/src/config/database.php";

    $conn = Db::getPDO();
    $imagesDir = '/xampp/htdocs/src/views/public/assets/media/movies/img/';
    $error = null;

    try {
        $title = trim($_REQUEST['title'] ?? '');
        $description = trim($_REQUEST['description'] ?? '');
        $info = trim($_REQUEST["info"]);
        $image = $_FILES['img_route'] ?? null;
        $place = trim($_REQUEST["place"]);

        // Validar campos vacíos
        if (empty($title) || empty($description)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Validar archivos subidos
        if (!$image || $image['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen.");
        }

        // Validar tipos de archivo
        $validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($image['type'], $validImageTypes)) {
            throw new Exception("Formato de imagen no permitido. Solo se permiten JPG y PNG.");
        }

        // Generar rutas únicas para los archivos
        $imagePath = $imagesDir . uniqid('img_') . "_" . basename($image['name']);

        // Mover archivos a las carpetas correspondientes
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            throw new Exception("Error al mover la imagen.");
        }

        // Insertar datos de la película
        $stmt = $conn->prepare("INSERT INTO events (title, description, info, img_route, place) VALUES (:title, :description, :info, :image, :place)");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ":info" => $info,
            ':image' => $imagePath,
            ":place" => $place 
        ]);
        $eventId = $conn->lastInsertId();

        // Ingresar horario del evento
        $scheduleTime = $_REQUEST['schedule_time'] ?? ''; 
        if (!empty($scheduleTime)) {
            $stmt = $conn->prepare("INSERT INTO events_schedules (id_event, time) VALUES (:id_movie, :time)");
            $stmt->execute([
                ':id_movie' => $eventId, 
                ':time' => $scheduleTime,
            ]);
        }

        // Si todo es correcto, redirigir
        session_start();
        $_SESSION['message'] = "Evento agregado con éxito.";
        header('Location: /admin/eventos');
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'GET' || isset($error)): ?>
    <?php require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php"; ?>

    <main class="p-2 text-center pt-4 d-flex justify-content-center">
        <form class="bg-white shadow rounded p-3 form" action="/admin/eventos/agregar" 
              enctype="multipart/form-data" method="post" style="max-width: 600px;">
            <div class="text-center">
                <h4 class="text-center">Agregar evento</h4>
            </div>
            <div class="modal-body d-flex justify-content-center gap-4">
                <div>
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control" name="title" placeholder="Ingrese el título">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Ingrese una descripción"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Información</label>
                        <textarea class="form-control" name="info" rows="3" placeholder="Ingrese información adicional"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lugar</label>
                        <input type="text" class="form-control" name="place" placeholder="Ingrese el lugar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Horario</label>
                        <input type="datetime-local" class="form-control" name="schedule_time" placeholder="">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Imagen del evento</label>
                        <input type="file" class="form-control" name="img_route">
                    </div>
                </div>
            </div>

            <!-- Mostrar mensajes de error -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="text-center">
                <button type="submit" class="btn blue-btn">AGREGAR</button>
            </div>
        </form>
    </main>
<?php endif; ?>
