<?php
require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
$error = null;

// Obtener evento mas reciente
$recentEvent = null;
try {
    $stmt = $conn->query("SELECT * FROM events ORDER BY id DESC LIMIT 1");
    $recentEvent = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = 'Algo salio mal al cargar el evento';
}

// Obtener películas
$events = [];
try {
    $stmt = $conn->query("SELECT * FROM events");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Algo salió mal al cargar las películas';
}
?> 

<div class="struct-body">
    <?php include '../src/views/public/layouts/header.php'; ?>

    <main class="p-4">

        <div class="container-fluid text-center d-flex flex-wrap gap-4">

            <?php foreach ($events as $event): ?>
                <div class="container text-center bg-white p-4 rounded shadow d-flex justify-content-center gap-4 panel-option" style="max-with: 400px;">
                    <div class="container-img shadow border">
                        <img src="<?= explode('htdocs', $event['img_route'])[1] ?>" class="movie-img rounded" alt="">
                    </div>
                    <div class="text-center d-flex flex-column justify-content-between pt-4 pb-4">
                        <h3><?= htmlspecialchars($event['title']) ?></h3>
                        <div class="">
                            <button class="container-fluid btn blue-btn mb-2"  
                                    data-bs-toggle="modal" data-bs-target="#info-<?= $event['id'] ?>">
                                Más info
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal para mostrar información -->
                <div class="modal fade" id="info-<?= $event['id'] ?>" tabindex="-1" aria-labelledby="infoLabel-<?= $event['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="infoLabel-<?= $event['id'] ?>">
                                    <?= htmlspecialchars($event['title']) ?>
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center gap-4">
                                <div class="container-img text-center">
                                    <img src="<?= explode('htdocs', $event['img_route'])[1] ?>" class="modal-img rounded" alt="">
                                </div>
                                <div class="text-start">
                                    <p><strong>Descripción:</strong> <?= htmlspecialchars($event['description']) ?></p>
                                    <p><strong>Informacion:</strong> <?= htmlspecialchars($event['info']) ?></p>
                                    <p><strong>Lugar:</strong> <?= htmlspecialchars($event['place']) ?></p>
                                    <p><strong>Horarios:</strong></p>
                                    <ul>
                                        <?php
                                            $schedules = []; 
                                            $id = $event['id'];
                                            try {
                                                $stmt = $conn->prepare("SELECT time FROM events_schedules WHERE id_event = :id");
                                                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                                $stmt->execute();
                                                $schedules = $stmt->fetchAll(PDO::FETCH_COLUMN); 
                                            } catch (PDOException $e) {
                                                $error = 'Algo salió mal al cargar los horarios';
                                            }
                                        ?>

                                        <ul>
                                            <?php if (!empty($schedules)): ?>
                                                <?php foreach ($schedules as $schedule): ?>
                                                    <li><?= htmlspecialchars($schedule) ?></li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li>No hay horarios disponibles</li>
                                            <?php endif; ?>
                                        </ul>
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
</div>
events