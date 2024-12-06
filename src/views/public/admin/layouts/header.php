<?php 
    require_once "/xampp/htdocs/src/helpers/session.php";

    Session::checkSession();
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e9d598791d.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/src/views/public/admin/assets/css/styless.css">
    <title>Cine UABCS</title>
</head>
<body>
    <header class="bg-light py-2 shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <!-- Logo y título -->
                <a href="/admin/panel" class="navbar-brand d-flex align-items-center">
                    <img src="/src/views/public/admin/assets/media/img/logoUABCS.png" alt="Logo" class="uabcs-logo me-2">
                    <h4 class="m-0 text-dark">Panel de administración</h4>
                </a>

                <!-- Botón para colapsar menú en pantallas pequeñas -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menú de navegación -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if (Session::checkPrivilegeWithReturn('billboard')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="/admin/cartelera">Cartelera</a>
                            </li>
                        <?php endif; ?>
                        <?php if (Session::checkPrivilegeWithReturn('events')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="/admin/eventos">Eventos</a>
                            </li>
                        <?php endif; ?>
                        <?php if (Session::checkPrivilegeWithReturn('system')): ?>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="/admin/usuarios">Usuarios</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="/admin/cerrar_session">Cerrar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="/admin/panel">Panel</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
