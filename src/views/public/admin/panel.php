<?php 
require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php";
require_once "/xampp/htdocs/src/helpers/session.php";
?>
 
    <main class="p-4 mt-4">
        <section class="container d-flex flex-wrap gap-4">

        <?php if (Session::checkPrivilegeWithReturn('billboard')): ?>
            <a href="/admin/cartelera" class="container text-dark panel-option text-center bg-white p-4 rounded shadow">
                <h3>Administrar cartelera</h3>
                <i class="fa-solid fa-film"></i>
            </a>
        <?php endif; ?>
        <?php if (Session::checkPrivilegeWithReturn('events')): ?>
            <a href="/admin/eventos" class="container panel-option text-dark text-center bg-white p-4 rounded shadow">
                <h3>Administrar eventos</h3>
                <i class="fa-regular fa-calendar-days"></i>
            </a>
        <?php endif; ?>
        <?php if (Session::checkPrivilegeWithReturn('system')): ?>
            <a href="/admin/usuarios" class="container panel-option text-dark text-center bg-white p-4 rounded shadow">
                <h3>Administrar Usuarios</h3>
                <i class="fa-solid fa-users"></i>
            </a>
        <?php endif; ?>
        <!--
            <div class="container panel-option text-center bg-white p-4 rounded shadow">
                <h3>Configurar mi perfil</h3>
                <i class="fa-regular fa-user"></i>
            </div>-->
        </section>
    </main>