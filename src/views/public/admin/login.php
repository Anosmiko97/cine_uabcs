<?php
require_once "/xampp/htdocs/src/config/database.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['admin'])) {
    header("Location: /admin/panel");
    exit;
}

$error = null;

try {
    $conn = Db::getPDO();
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $num_control = htmlspecialchars(trim($_POST['num_control'] ?? '')); 
    $password = $_POST['password'] ?? '';

    if ($num_control && $password) {
        try {
            $stmt = $conn->prepare("SELECT * FROM admins WHERE num_control = :num_control");
            $stmt->execute([':num_control' => $num_control]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si el usuario existe y si la contraseña es válida
            if ($admin && password_verify($password, $admin['password'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Regenerar el ID de la sesión para mayor seguridad
                session_regenerate_id(true);

                // Guardar los datos del usuario en la sesión
                $_SESSION['admin'] = [
                    'id' => $admin['id'],
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'photo' => $admin['photo'],
                    'num_control' => $num_control,
                    'privileges' => [
                        'billboard' => (bool)$admin['billboard_privileges'],
                        'events' => (bool)$admin['events_privileges'],
                        'system' => (bool)$admin['system_privileges'],
                        'register' => (bool)$admin['register_privileges']
                    ]
                ];

                // Redirigir al panel de administración
                header("Location: /admin/panel");
                exit;
            } else {
                $error = "Credenciales incorrectas.";
            }
        } catch (PDOException $e) {
            $error = "Error de base de datos: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <script src="https://kit.fontawesome.com/e9d598791d.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/src/views/public/admin/assets/css/styless.css">
</head>
<body class="p-5 bg-light">
    <div class="container login-container bg-white p-4 rounded shadow">
        <div class="text-center">
            <i class="fa-regular fa-user pb-2" style="font-size: 40px; color: #6c757d;"></i>
            <h4 class="text-dark">Iniciar sesión como administrador</h4>
        </div>
        <form action="/admin/iniciar_sesion" method="post">
            <div class="mb-3">
                <input 
                    type="text" 
                    class="form-control login-input" 
                    id="num_control" 
                    name="num_control" 
                    placeholder="Número de control" 
                    required>
            </div>
            <div class="mb-3">
                <input 
                    type="password" 
                    class="form-control login-input" 
                    id="password" 
                    name="password" 
                    placeholder="Contraseña" 
                    required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100">INICIAR SESIÓN</button>
            </div>
            <?php if ($error): ?>
                <div class="alert alert-danger mt-3 text-center"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
