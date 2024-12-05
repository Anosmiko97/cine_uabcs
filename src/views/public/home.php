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
                    <h1><b>Hoy</b></h1>
                </div>

                <div class="frameGrid">
                    <?php foreach ($movies as $movie): ?>

                        <div class="filmFrame" id="frame0">
                            <div class="innerFrame">

                                <div class="todayPoster">
                                    <img src="<?= explode('htdocs', $movie['img_route'])[1] ?>" alt="poster"
                                        onerror="this.src='https://via.placeholder.com/260x410'" class="poster">
                                </div>


                                <div class="description">
                                    <div class="title">
                                        <b><?= htmlspecialchars($movie['title']) ?></b>
                                    </div>

                                    <div class="sinopsis">
                                        <small><?= htmlspecialchars($movie['description']) ?></small>
                                    </div>

                                    <div class="hour">
                                        <small>10:30 pm</small>
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
                <img src="<?= explode('htdocs', $events['img_route'])[1] ?>" alt="Evento ejemplo"
                    onerror="this.src='https://via.placeholder.com/600x800'" class="eventPoster">
            </div>
        </div>


    </div>
</main>

<?php include './src/views/public/layouts/footer.php'; ?>