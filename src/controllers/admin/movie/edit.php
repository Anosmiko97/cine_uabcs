<?php
    require_once "./src/config/database.php";
    $conn = Db::getPDO();
    $moviesDir = realpath(__DIR__ . '/../src/views/public/assets/media/movies/video/') . '/';
    $imagesDir = realpath(__DIR__ . '/../src/views/public/assets/media/movies/img/') . '/';
    

        try {
            // Data de la peticion
            $id = $_REQUEST['id'];
            $title = $_REQUEST['title'];
            $description = $_REQUEST['description'];
            $image = $_FILES['img_route'];
            $file = $_FILES['movie_route'];
        
            // Guardar archivos en directorios
            move_uploaded_file($image['tmp_name'], $imagesDir . $image['name']);
            move_uploaded_file($file['tmp_name'], $moviesDir . $file['name']);

            // Insertar datos en la DB
            $stmt = $conn->prepare("UPDATE movies SET (title, description, image, file) 
                                    VALUES (:title, :description, :image, :file) WHERE");
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':image' => $image,
                ':file' => $file
            ]);
        
        } catch (PDOException $e) {
            $error = "Algo salio mal al cargar las peliculas";
        }
    