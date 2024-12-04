<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once "/xampp/htdocs/src/config/database.php";

        $conn = Db::getPDO();
        $moviesDir = '/xampp/htdocs/src/views/public/assets/media/movies/video/';
        $imagesDir = '/xampp/htdocs/src/views/public/assets/media/movies/img/';

        try {
            $title = trim($_REQUEST['title']);
            $description = trim($_REQUEST['description']);
            $image = $_FILES['img_route'];
            $file = $_FILES['movie_route'];

            if ($image['error'] !== UPLOAD_ERR_OK || $file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Error al subir los archivos.");
            }

            $validImageTypes = ['image/jpeg', 'image/png'];
            $validVideoTypes = ['video/mp4'];
            if (!in_array($image['type'], $validImageTypes) || !in_array($file['type'], $validVideoTypes)) {
                throw new Exception("Tipo de archivo no permitido.");
            }

            $maxImageSize = 2 * 1024 * 1024; // 2 MB
            $maxVideoSize = 100 * 1024 * 1024; // 100 MB
            if ($image['size'] > $maxImageSize || $file['size'] > $maxVideoSize) {
                throw new Exception("El tamaño del archivo excede el límite permitido.");
            }

            $imagePath = $imagesDir . uniqid('img_') . "_" . basename($image['name']);
            $filePath = $moviesDir . uniqid('vid_') . "_" . basename($file['name']);

            if (!move_uploaded_file($image['tmp_name'], $imagePath) || !move_uploaded_file($file['tmp_name'], $filePath)) {
                throw new Exception("Error al mover los archivos.");
            }

            $stmt = $conn->prepare("INSERT INTO movies (title, description, img_route, movie_route) VALUES (:title, :description, :image, :file)");
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':image' => $imagePath,
                ':file' => $filePath,
            ]);

            echo "Película agregada con éxito.";

        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo "Ocurrió un error al guardar la película.";
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo "Ocurrió un error al procesar los archivos.";
        }
    }
?>

<?php if($_SERVER['REQUEST_METHOD'] == 'GET'):?>

    <?php require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php" ?>

    <main class="p-2 text-center pt-5 d-flex justify-content-center ">
    <form class="bg-white shadow rounded p-3 form" action="/admin/cartelera/agregar" 
                                enctype="multipart/form-data" method="post" style="max-width: 400px;">
                                <div class="text-center">
                                        <h4 class="text-center">Agregar pelicula</h4>
                                    </div>
                                    <div class="modal-body d-flex justify-content-center gap-4">
                                        <div>
                                            <div class="mb-3">
                                                <label class="form-label">Título</label>
                                                <input type="text" class="form-control" name="title" placeholder="Ingrese el titulo">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Descripcion</label>
                                                <input type="text" class="form-control" name="description" placeholder="Ingrese una descripcion">
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