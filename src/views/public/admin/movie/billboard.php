<?php
    require_once "/xampp/htdocs/src/helpers/session.php";

    Session::checkPrivilege('billboard');

    require_once "/xampp/htdocs/src/config/database.php";

    $conn = Db::getPDO();
    $error =  null;
    $movies = [];
    
    try {
        $stmt = $conn->query("SELECT * FROM movies");
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $error = 'Algo salio mal al cargar las peliculas';
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
            <a class="btn blue-btn fw-bold" href="/admin/cartelera/agregar">Agregar pelicula +</a>
        </div>

        <?php if (count($movies) == 0): ?>
            <section class="container-fluid d-flex justify-content-center">
                <h3 style="max-width: 400px;" class="text-center bg-white p-3 rounded shadow">No hay peliculas registradas <a href="/admin/cartelera/agregar">agrega una</a></h3>
            </section>
        <?php else: ?>
            <section class="container d-flex flex-wrap gap-4">
                <?php foreach ($movies as $movie): ?> 
                    <div class="container panel-option text-center bg-white p-4 rounded shadow d-flex justify-content-center gap-4">
                        <div class="container-img shadow border">
                            <img src="<?= explode('htdocs', $movie['img_route'])[1]?>" class="rounded" alt="">
                        </div>
                        <div class="text-center d-flex flex-column justify-content-between pt-4 pb-4">
                            <h3><?= htmlspecialchars($movie['title']) ?></h3>
                            <p><?= htmlspecialchars($movie['description']) ?></p>
                            <div class="flex-column">
                                <button class="container-fluid btn blue-btn mb-2"  
                                    data-bs-toggle="modal" data-bs-target="#addSchedule-<?= $movie['id'] ?>">
                                    Agregar horario
                                </button>
                                <button class="container-fluid btn blue-btn mb-2"  
                                data-bs-toggle="modal" data-bs-target="#edit-<?= $movie['id'] ?>">
                                    Editar
                                </button>
                                <button class="container-fluid btn btn-danger mb-2"  
                                data-bs-toggle="modal" data-bs-target="#delete-<?= $movie['id'] ?>">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para botón de editar -->
                    <div class="modal fade" id="edit-<?= $movie['id'] ?>" tabindex="-1" aria-labelledby="editLabel-<?= $movie['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" action="/admin/cartelera/editar" 
                            enctype="multipart/form-data" method="post">
                                <div class="modal-header">
                                    <h4 class="text-center">Ingrese la nueva información en los campos</h4>
                                </div>
                                <div class="modal-body d-flex justify-content-center gap-4">
                                    <div class="container-img">
                                        <img src="<?= explode('htdocs', $movie['img_route'])[1]?>" class="rounded" alt="">
                                    </div>
                                    <div>
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($movie['id']) ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Título</label>
                                            <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($movie['title']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Descripción</label>
                                            <input type="text" class="form-control" name="description" value="<?= htmlspecialchars($movie['description']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Imagen de película</label>
                                            <input type="file" class="form-control" name="img_route" value="<?= htmlspecialchars($movie['img_route']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Archivo de película</label>
                                            <input type="file" class="form-control" name="movie_route" value="<?= htmlspecialchars($movie['movie_route']) ?>">
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
                    <div class="modal fade" id="delete-<?= $movie['id'] ?>" tabindex="-1" aria-labelledby="deleteLabel-<?= $movie['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="/admin/cartelera/eliminar" method="post" class="modal-content">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($movie['id']) ?>">
                                <input type="hidden" class="form-control" name="title" value="<?= htmlspecialchars($movie['title']) ?>">
                                <input type="hidden" class="form-control" name="description" value="<?= htmlspecialchars($movie['description']) ?>">
                                <input type="hidden" class="form-control" name="img_route" value="<?= htmlspecialchars($movie['img_route']) ?>">        
                                <input type="hidden" class="form-control" name="movie_route" value="<?= htmlspecialchars($movie['movie_route']) ?>">
                                <div class="modal-header">
                                    <h3>¿Esta seguro que quiere eliminar <?= htmlspecialchars($movie['title']) ?>?</h3>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-success">Sí</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal para agregar horario -->
                    <div class="modal fade" id="addSchedule-<?= $movie['id'] ?>" tabindex="-1" aria-labelledby="addScheduleLabel-<?= $movie['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <form class="modal-content" action="/admin/cartelera/agregar_horario" method="post">
                                <div class="modal-header">
                                    <h4 class="text-center">Agregar horario a la película</h4>
                                </div>
                                <div class="modal-body d-flex justify-content-center gap-4">
                                    <input type="hidden" name="movie_id" value="<?= $movie['id'] ?>">
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
