<?php 
require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php";
require_once "/xampp/htdocs/src/helpers/session.php";

$id = $_SESSION['admin']['id'];
$name = $_SESSION['admin']['name'];
$num_control = $_SESSION['admin']['num_control'];
$email =  $_SESSION['admin']['email'];
$photo = $_SESSION['admin']['photo'];
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
            <?php if (Session::checkPrivilegeWithReturn('system')): ?>
                <a class="container panel-option text-dark text-center bg-white p-4 rounded shadow"
                data-bs-toggle="modal" data-bs-target="#<?= $id ?>">
                    <h3>Configurar mi perfil</h3>
                    <i class="fa-regular fa-user"></i>  
                </a>
            <?php endif; ?>
                <a class="container panel-option text-dark text-center bg-white p-4 rounded shadow"
                href="/admin/registrar_asistencias">
                    <h3>Registrar asistencias</h3>
                    <i class="fa-solid fa-list"></i>
                </a>
        </section>
    </main>

    <!-- Modal para botón de editar -->
    <div class="modal fade" id="<?= $id?>" tabindex="-1" aria-labelledby="<?= $id ?>" aria-hidden="true">
                        <div class="modal-dialog">
                        <form class="modal-content" action="/admin/configurar_perfil" 
                            enctype="multipart/form-data" method="post">
                            <div class="modal-header">
                                <h4 class="text-center">Ingrese la nueva información en los campos</h4>
                            </div>
                            <div class="modal-body d-flex justify-content-center gap-4">
                                <div class="container-img">
                                    <img src="<?= $photo ?>" class="rounded" alt="Foto del Administrador">
                                </div>
                                <div>
                                    <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($id) ?>" required>

                                    <!-- Nombre -->
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($name) ?>" required>
                                    </div>

                                    <!-- Número de Control -->
                                    <div class="mb-3">
                                        <label class="form-label">Número de Control</label>
                                        <input type="text" class="form-control" name="num_control" value="<?= htmlspecialchars($num_control) ?>" required>
                                    </div>

                                    <!-- Correo Electrónico -->
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" required>
                                    </div>

                                    <!-- Contraseña -->
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" name="password" placeholder="Ingrese una nueva contraseña o deje en blanco">
                                    </div>

                                    <!-- Foto -->
                                    <div class="mb-3">
                                        <label class="form-label">Foto</label>
                                        <input type="file" class="form-control" name="photo">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Guardar cambios</button>
                            </div>
                        </form>

                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>    
