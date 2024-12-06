<?php
    require_once "/xampp/htdocs/src/helpers/session.php";

    Session::checkPrivilege('events');

    require_once "/xampp/htdocs/src/config/database.php";

    $conn = Db::getPDO();
    $error =  null;
    $events = [];
    
    try {
        $stmt = $conn->query("SELECT * FROM events");
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $error = 'Algo salio mal al cargar los eventos';
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
            <a class="btn blue-btn fw-bold" href="/admin/eventos/agregar">Agregar evento +</a>
        </div>

        <?php if (count($events) == 0): ?>
            <section class="container-fluid d-flex justify-content-center">
                <h3 style="max-width: 400px;" class="text-center bg-white p-3 rounded shadow">No hay eventos registrados <a href="/admin/eventos/agregar">agrega uno</a></h3>
            </section>
        <?php else: ?>
            <section class="container d-flex flex-wrap gap-4">
                <?php foreach ($events as $event): ?> 
                    <div class="container panel-option text-center bg-white p-4 rounded shadow d-flex justify-content-center gap-4">
                        <div class="container-img shadow border">
                            <img src="<?= explode('htdocs', $event['img_route'])[1]?>" class="rounded" alt="">
                        </div>
                        <div class="text-center d-flex flex-column justify-content-between pt-4 pb-4">
                            <h3><?= htmlspecialchars($event['title']) ?></h3>
                            <div class="flex-column">
                                <button class="container-fluid btn blue-btn mb-2"  
                                    data-bs-toggle="modal" data-bs-target="#addSchedule-<?= $event['id'] ?>">
                                    Agregar horario
                                </button>
                                <button class="container-fluid btn blue-btn mb-2"  
                                data-bs-toggle="modal" data-bs-target="#edit-<?= $event['id'] ?>">
                                    Editar
                                </button>
                                <button class="container-fluid btn btn-danger mb-2"  
                                data-bs-toggle="modal" data-bs-target="#delete-<?= $event['id'] ?>">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para botón de editar -->
                    <div class="modal fade" id="edit-<?= $event['id'] ?>" tabindex="-1" aria-labelledby="editLabel-<?= $event['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form class="modal-content" action="/admin/eventos/editar" enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                    <h4 class="text-center">Ingrese la nueva información en los campos</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                </div>
                                <div class="modal-body d-flex justify-content-center gap-4">
                                    <div class="container-img">
                                        <img src="<?= explode('htdocs', $event['img_route'])[1]?>" class="rounded" alt="">
                                    </div>
                                    <div class="p-4">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Título</label>
                                            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($event['title']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Descripción</label>
                                            <textarea class="form-control" name="description" rows="4"><?= htmlspecialchars($event['description']) ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Información</label>
                                            <textarea class="form-control" name="info" rows="4"><?= htmlspecialchars($event['info']) ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Lugar</label>
                                            <input type="text" class="form-control" name="place" value="<?= htmlspecialchars($event['place']) ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Imagen del evento</label>
                                            <input type="file" class="form-control" name="img_route" value="<?= htmlspecialchars($event['img_route']) ?>">
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
                    <div class="modal fade" id="delete-<?= $event['id'] ?>" tabindex="-1" aria-labelledby="deleteLabel-<?= $event['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="/admin/eventos/eliminar" method="post" class="modal-content">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($event['id']) ?>">
                                <input type="hidden" class="form-control" name="title" value="<?= htmlspecialchars($event['title']) ?>">
                                <input type="hidden" class="form-control" name="description" value="<?= htmlspecialchars($event['description']) ?>">
                                <input type="hidden" class="form-control" name="info" value="<?= htmlspecialchars($event['info']) ?>">
                                <input type="hidden" class="form-control" name="img_route" value="<?= htmlspecialchars($event['img_route']) ?>">    
                                <input type="hidden" class="form-control" name="place" value="<?= htmlspecialchars($event['img_route']) ?>">            
                                <div class="modal-header">
                                    <h3>¿Esta seguro que quiere eliminar <?= htmlspecialchars($event['title']) ?>?</h3>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-success">Sí</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal para agregar horario -->
                    <div class="modal fade" id="addSchedule-<?= $event['id'] ?>" tabindex="-1" aria-labelledby="addScheduleLabel-<?= $event['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" action="/admin/eventos/agregar_horario" method="post">
                                <div class="modal-header">
                                    <h4 class="text-center">Agregar horario a la película</h4>
                                </div>
                                <div class="modal-body d-flex justify-content-center gap-4">
                                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Horario</label>
                                        <input type="datetime-local" class="form-control" name="schedule_time" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Agregar horario</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>    
