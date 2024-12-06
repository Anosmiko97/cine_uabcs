<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
$error = null;

// Obtener películas
$movies = [];
try {
    $stmt = $conn->query("SELECT * FROM movies");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Algo salió mal al cargar las películas';
}
?> 

<?php include '../src/views/public/layouts/header.php'; ?>

<main class="p-4">
    <div class="container-fluid text-center d-flex flex-wrap">

        <?php foreach ($movies as $movie): ?>
            <div class="container text-center bg-white p-4 rounded shadow d-flex justify-content-center gap-4 panel-option" style="width: 400px;">
                <div class="container-img shadow border">
                    <img src="<?= explode('htdocs', $movie['img_route'])[1] ?>" class="movie-img rounded" alt="">
                </div>
                <div class="text-center d-flex flex-column justify-content-between pt-4 pb-4">
                    <h3><?= htmlspecialchars($movie['title']) ?></h3>
                    <p><?= htmlspecialchars($movie['description']) ?></p>
                    <div class="">
                        <button class="container-fluid btn btn-danger mb-2"  
                                data-bs-toggle="modal" data-bs-target="#info-<?= $movie['id'] ?>">
                            Más info
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal para mostrar información -->
            <div class="modal fade" id="info-<?= $movie['id'] ?>" tabindex="-1" aria-labelledby="infoLabel-<?= $movie['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="infoLabel-<?= $movie['id'] ?>">
                                <?= htmlspecialchars($movie['title']) ?>
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex justify-content-center gap-4">
                            <div class="container-img text-center">
                                <img src="<?= explode('htdocs', $movie['img_route'])[1] ?>" class="modal-img rounded" alt="">
                            </div>
                            <div>
                                <p><strong>Descripción:</strong> <?= htmlspecialchars($movie['description']) ?></p>
                                <p><strong>Horarios:</strong></p>
                                <ul>
                                    <?php
                                    $schedules = ["10:00 AM", "1:00 PM", "4:00 PM", "7:00 PM"]; 
                                    foreach ($schedules as $schedule): ?>
                                        <li><?= htmlspecialchars($schedule) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include '../src/views/public/layouts/footer.php'; ?>
