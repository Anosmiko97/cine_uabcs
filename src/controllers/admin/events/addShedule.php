event<?php
    require_once "/xampp/htdocs/src/config/database.php";

    $conn = Db::getPDO();
    $error = null;

    try {
        $eventId = $_POST['event_id'] ?? null;
        $scheduleTime = $_POST['schedule_time'] ?? null;

        // Validar datos
        if (empty($eventId) || empty($scheduleTime)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        // Insertar horario en la base de datos
        $stmt = $conn->prepare("INSERT INTO events_schedules (id_event, time) VALUES (:id_event, :time)");
        $stmt->execute([
            ':id_event' => $eventId,
            ':time' => $scheduleTime,
        ]);

        session_start();
        $_SESSION['message'] = "Horario agregado con éxito.";
        header('Location: /admin/eventos');
        exit;

    } catch (Exception $e) {
        session_start();
        $_SESSION['error'] = $e->getMessage();
        header('Location: /admin/eventos');
        exit;
    }
?>
