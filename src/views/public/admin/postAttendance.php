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
        // Asegurarse de que los datos estén correctamente formateados
        $num_control = $attendance['num_control'];
        $entry_time = $attendance['entry_time'];
        $departure_time = $attendance['departure_time'] ?? null;  // Si no hay hora de salida, se deja como NULL

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

    // Respuesta exitosa
    http_response_code(200);
    echo json_encode(['message' => 'Asistencias registradas correctamente.']);

} catch (PDOException $e) {
    // Error en la base de datos
    http_response_code(500);
    echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Error en la lógica de negocio
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>





