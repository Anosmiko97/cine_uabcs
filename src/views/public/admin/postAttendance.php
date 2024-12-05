<?php
// Ruta en tu backend: /api/saveAttendances
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados como JSON
    var_dump($_REQUEST);

    
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
