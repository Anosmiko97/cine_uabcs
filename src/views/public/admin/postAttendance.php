<?php
require_once "/xampp/htdocs/src/config/database.php";

try {
    var_dump($_REQUEST);
    $conn = Db::getPDO(); 

    // Obtener los datos del formulario (en este caso, se espera que sean enviados en un array 'attendances')
    $attendances = $_POST['attendances'] ?? [];

    if (empty($attendances)) {
        throw new Exception("Datos insuficientes para registrar asistencias.");
    }

    // Preparar la consulta SQL para insertar en la tabla 'asistances'
    $stmt = $conn->prepare("
        INSERT INTO asistances (num_control, entry_time, departure_time)
        VALUES (:num_control, :entry_time, :departure_time)
    ");

    // Para cada asistencia recibida, insertarla en la base de datos
    foreach ($attendances as $attendance) {
        $num_control = $attendance['num_control'];
        $entry_time = $attendance['entry_time'];
        $departure_time = $attendance['departure_time'] ?? null; 

        if (!$num_control || !$entry_time) {
            throw new Exception("El número de control y la hora de entrada son obligatorios.");
        }

        // Ejecutar la inserción de la asistencia
        $stmt->execute([
            ':num_control' => $num_control,
            ':entry_time' => $entry_time,
            ':departure_time' => $departure_time
        ]);
    }

    session_start();
    $_SESSION['message'] =  'Asistencias registradas correctamente.';
    header('Location: /admin/registrar_asistencias');
} catch (PDOException $e) {
    session_start();
    $_SESSION['error'] =  'Error de base de datos: ' . $e->getMessage();
    header('Location: /admin/registrar_asistencias');
} catch (Exception $e) {
    session_start();
    $_SESSION['error'] =  'Error: ' . $e->getMessage();
    header('Location: /admin/registrar_asistencias');
}
?>





