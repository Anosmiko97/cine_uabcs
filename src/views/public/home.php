<?php

require_once "/xampp/htdocs/src/config/database.php";

$conn = Db::getPDO();
$error = null;

// Obetner pelicula mas reciente
$movies = [];
try {
    $stmt = $conn->query("SELECT * FROM movies");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = 'Algo salio mal al cargar las peliculas';
}

// Obtener evento mas reciente
$event = null;
try {
    $stmt = $conn->query("SELECT * FROM events ORDER BY id DESC LIMIT 1");
    $event = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = 'Algo salio mal al cargar el evento';
}
?>

<?php include './src/views/public/layouts/header.php'; ?>

<main>
    <?php if (count($movies) == 0): ?>
        <section class="container-fluid d-flex justify-content-center">
            <h3 style="max-width: 400px;" class="text-center bg-white p-3 rounded shadow">No hay peliculas en cartelera</h3>
        </section>
    <?php else: ?>
        <div class="content">
            <div class="left-frame">
                <div class="frameTitle">
                    <h1><b>Peliculas</b></h1>
                </div>

                <div class="frameGrid overflow-auto">
                    <?php foreach ($movies as $movie): ?>

                        <div class="container bg-white rounded shadow d-flex text-dark">
                                <div class="rounded p-2">
                                    <img src="<?= explode('htdocs', $movie['img_route'])[1] ?>" alt="poster"
                                        onerror="this.src='https://via.placeholder.com/260x410'" class="poster">
                                </div>
                                <div class="container d-flex flex-column justify-content-between">
                                    <h5 class="modal-title pt-3" id="infoLabel-<?= $movie['id'] ?>">
                                        <?= htmlspecialchars($movie['title']) ?>
                                    </h5>
                                    <div class="">
                                        <button class="container-fluid btn blue-btn mb-2"  
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
                                                <h4 class="modal-title text-dark" id="infoLabel-<?= $movie['id'] ?>">
                                                    <?= htmlspecialchars($movie['title']) ?>
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body d-flex justify-content-center gap-4 text-dark">
                                                <div class="container-img text-center">
                                                    <img src="<?= explode('htdocs', $movie['img_route'])[1] ?>" class="modal-img rounded" alt="">
                                                </div>
                                                <div class="text-start">
                                                    <p><strong>Descripción:</strong> <?= htmlspecialchars($movie['description']) ?></p>
                                                    <p><strong>Horarios:</strong></p>
                                                    <ul>
                                                        <?php
                                                            $schedules = []; 
                                                            $id = $movie['id'];
                                                            try {
                                                                $stmt = $conn->prepare("SELECT time FROM movies_schedules WHERE id_movie = :id");
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
            </div>
        <?php endif; ?>
        <div class="right-frame">
            <div class="frameTitle">
                <h1><b>Proximo evento</b></h1>
            </div>

            <div class="eventContainer">
                <img src="<? explode('htdocs', $movie['img_route'])[1] ?>" alt="Evento ejemplo"
                    onerror="this.src='https://via.placeholder.com/600x800'" class="eventPoster">
            </div>
        </div>


    </div>
</main>

<?php include './src/views/public/layouts/footer.php'; ?>