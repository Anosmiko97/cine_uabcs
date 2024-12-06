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

<head>
    <link rel="stylesheet" href="/public/assets/css/billboard.css">
    <style>
        .movie-img {
            max-width: 200px; 
            width: 100%; 
            height: auto; 
        }
        .modal-img {
            max-width: 150px; 
            width: 100%;
            height: auto;
        }

        :root {
            --blue: #2D6FA4;
        }

        .billboardFrame {
            background: linear-gradient(to bottom, #2D6FA4, #112A3E);
        }

        .panel-option {
            max-width: 400px;
            transition: .5s ease-in-out scale;
        }

        .panel-option i {
            font-size: 6rem;
        }

        .panel-option:hover {
            scale: 1.03;
        }

        .container-img img {
            width: 10rem;
            height: auto;
            
        }

        .blue-btn {
            background-color: var(--blue);
            color: white;
        }

        .blue-btn:hover {
            background-color: #004781;
            color: rgb(164, 164, 164);
        }
    </style>
</head>

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
                            <div class="text-center">
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
