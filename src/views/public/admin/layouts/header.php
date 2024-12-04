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
        <div class="container d-flex align-items-center justify-content-between p-1">

            <a href="/admin/panel" class="d-flex align-items-center text-decoration-none">
                <img src="/src/views/public/admin/assets/media/img/logoUABCS.png" alt="Logo" class="uabcs-logo">
                <h4 class="text-dark">Panel de administracion</h4>
            </a>

            <nav>
                <ul class="nav">
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
                        <a class="nav-link text-dark" href="/admin/panel">Panel</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header> 


