<?php 
require_once "./src/config/database.php";

$error = null;
$conn = Db::getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Debe ser 'POST' en mayúsculas
    $num_control = $_POST['num_control'] ?? null; // Capturamos los valores de los campos
    $password = $_POST['password'] ?? null;

    if ($num_control && $password) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE num_control = $num_control AND password = $password");
        $stmt->execute([
            ':num_control' => $num_control,
            ':password' => $password // Asegúrate de usar contraseñas cifradas
        ]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            session_start();
            $_SESSION['admin'] = $admin['name'];
            $_SESSION['privileges'] = $admin['privileges'];
            header("Location: /admin/panel");
            exit;
        } else {
            $error = "Número de control o contraseña incorrectos.";
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
<body class="p-5">
    <div class="container login-container bg-white p-4 rounded shadow">
        <div class="text-center">
            <i class="fa-regular fa-user pb-2"></i>
            <p class="text-dark">Iniciar sesión como administrador</p>
        </div>
        <form action="/admin/iniciar_sesion" method="post">
            <div class="mb-3">
                <input 
                    type="text" 
                    class="form-control login-input" 
                    id="num_control" 
                    name="num_control" 
                    placeholder="Número de control">
            </div>
            <div class="mb-3">
                <input 
                    type="password" 
                    class="form-control login-input" 
                    id="password" 
                    name="password" 
                    placeholder="Contraseña">
            </div>
            <div class="text-center">
                <button type="submit" class="btn blue-btn p-3">INICIAR SESIÓN</button>
            </div>
            <?php if ($error): ?>
                <div class="text-danger mt-3 text-center"><?= $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
