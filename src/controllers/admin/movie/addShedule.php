<?php
    require_once "/xampp/htdocs/src/config/database.php";

    $conn = Db::getPDO();
    $error = null;

    try {
        $movieId = $_POST['movie_id'] ?? null;
        $scheduleTime = $_POST['schedule_time'] ?? null;

        // Validar datos
        if (empty($movieId) || empty($scheduleTime)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Insertar horario en la base de datos
        $stmt = $conn->prepare("INSERT INTO movies_schedules (id_movie, time) VALUES (:id_movie, :time)");
        $stmt->execute([
            ':id_movie' => $movieId,
            ':time' => $scheduleTime,
        ]);

        session_start();
        $_SESSION['message'] = "Horario agregado con éxito.";
        header('Location: /admin/cartelera');
        exit;

    } catch (Exception $e) {
        session_start();
        $_SESSION['error'] = $e->getMessage();
        header('Location: /admin/cartelera');
        exit;
    }
?>
