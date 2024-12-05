<?php
    require_once "/xampp/htdocs/src/helpers/session.php";

    Session::checkPrivilege('system');

    require_once "/xampp/htdocs/src/config/database.php";
    $conn = Db::getPDO();
    $error =  null;
    
    try {
        $stmt = $conn->query("SELECT * FROM admins");
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $error = 'Algo salio mal al cargar los usuarios';
    }    
?>

<?php require_once "/xampp/htdocs/src/views/public/admin/layouts/header.php" ?>

    <main class="p-4">
        <?php
            if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="container-fluid d-flex justify-content-end mb-4">
            <a class="btn blue-btn fw-bold" href="/admin/usuarios/agregar">Agregar administrador +</a>
        </div>

        <?php if (count($admins) == 0): ?>
            <section class="container-fluid d-flex justify-content-center">
                <h3 style="max-width: 400px;" class="text-center bg-white p-3 rounded shadow">No hay administradores registrados <a href="/admin/usuarios/agregar">agrega uno</a></h3>
            </section>
        <?php else: ?>
            <section class="container d-flex flex-wrap gap-4">
                <?php foreach ($admins as $admin): ?> 
                    <?php if ($_SESSION['admin']['id'] != $admin['id']): ?>
                        <div class="container panel-option text-center bg-white p-4 rounded shadow d-flex justify-content-center gap-4">
                            <div class="container-img shadow border">
                                <img src="<?= explode('htdocs', $admin['photo'])[1]?>" class="rounded" alt="">
                            </div>
                            <div class="text-center d-flex flex-column justify-content-between pt-4 pb-4">
                                <h3><?= htmlspecialchars($admin['name']) ?></h3>
                                <p><?= htmlspecialchars($admin['num_control']) ?></p>
                                <div class="flex-column">
                                    <button class="container-fluid btn blue-btn mb-2"  
                                    data-bs-toggle="modal" data-bs-target="#edit-<?= $admin['id'] ?>">
                                        Editar
                                    </button>
                                    <button class="container-fluid btn btn-danger mb-2"  
                                    data-bs-toggle="modal" data-bs-target="#delete-<?= $admin['id'] ?>">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Modal para botón de editar -->
                    <div class="modal fade" id="edit-<?= $admin['id'] ?>" tabindex="-1" aria-labelledby="editLabel-<?= $movie['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 80%;">
                        <form class="modal-content" action="/admin/usuarios/editar" 
                            enctype="multipart/form-data" method="post">
                            <div class="modal-header">
                                <h4 class="text-center">Ingrese la nueva información en los campos</h4>
                                <div class="">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            </div>
                            <div class="modal-body d-flex justify-content-center gap-4">
                                <div class="container-img">
                                    <img src="<?= explode('htdocs', $admin['photo'])[1] ?>" class="rounded" alt="Foto del Administrador">
                                </div>
                                <div class="d-flex">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($admin['id']) ?>">

                                    <div class="container">
                                        <!-- Nombre -->
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>
                                        </div>

                                        <!-- Número de Control -->
                                        <div class="mb-3">
                                            <label class="form-label">Número de Control</label>
                                            <input type="text" class="form-control" name="num_control" value="<?= htmlspecialchars($admin['num_control']) ?>" required>
                                        </div>

                                        <!-- Correo Electrónico -->
                                        <div class="mb-3">
                                            <label class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                                        </div>

                                        <!-- Contraseña -->
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" name="password" placeholder="Ingrese una nueva contraseña o deje en blanco">
                                        </div>
                                    </div>

                                    <div class="container">
                                        <!-- Privilegios -->
                                        <div class="mb-3">
                                            <label class="form-label">Privilegios en la Cartelera</label>
                                            <input type="checkbox" class="form-check-input" name="billboard_privileges" <?= $admin['billboard_privileges'] ? 'checked' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Privilegios en Eventos</label>
                                            <input type="checkbox" class="form-check-input" name="events_privileges" <?= $admin['events_privileges'] ? 'checked' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Privilegios en el Sistema</label>
                                            <input type="checkbox" class="form-check-input" name="system_privileges" <?= $admin['system_privileges'] ? 'checked' : '' ?>>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Privilegios para Registrar</label>
                                            <input type="checkbox" class="form-check-input" name="register_privileges" <?= $admin['register_privileges'] ? 'checked' : '' ?>>
                                        </div>

                                        <!-- Foto -->
                                        <div class="mb-3">
                                            <label class="form-label">Foto</label>
                                            <input type="file" class="form-control" name="photo">
                                        </div>
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

                    <!-- Modal para botón de eliminar -->
                    <div class="modal fade" id="delete-<?= $admin['id'] ?>" tabindex="-1" aria-labelledby="deleteLabel-<?= $admin['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="/admin/usuarios/eliminar" method="post" class="modal-content">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($admin['id']) ?>">
                                <input type="hidden" class="form-control" name="name" value="<?= htmlspecialchars($admin['name']) ?>">
                                <input type="hidden" class="form-control" name="num_control" value="<?= htmlspecialchars($admin['num_control']) ?>">
                                <input type="hidden" class="form-control" name="photo" value="<?= htmlspecialchars($admin['photo']) ?>">        
                                <div class="modal-header">
                                    <h3>¿Esta seguro que quiere eliminar a <?= htmlspecialchars($admin['name']) ?>?</h3>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-success">Sí</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>    
