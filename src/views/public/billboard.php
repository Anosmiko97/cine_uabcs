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
?>

<head>
    <link rel="stylesheet" href="/public/assets/css/billboard.css">
</head>

<?php include '../src/views/public/layouts/header.php'; ?>

<body>

    <div class="container-fluid">

        <div class="row">

            <!-- Sidebar -->
            <div class="col-2 pd-0 sideMenu" id="sidebar">
                <div class="sideMenuContent">
                    <ul class="list-group">
                        <li class="list-group-item">12 de noviembre</li>
                        <li class="list-group-item">13 de noviembre</li>
                        <li class="list-group-item">14 de noviembre</li>
                        <li class="list-group-item">15 de noviembre</li>
                        <li class="list-group-item">16 de noviembre</li>
                        <li class="list-group-item">17 de noviembre</li>
                        <li class="list-group-item">18 de noviembre</li>
                        <li class="list-group-item">19 de noviembre</li>
                        <li class="list-group-item">20 de noviembre</li>
                        <li class="list-group-item active">21 de noviembre</li>
                        <li class="list-group-item">22 de noviembre</li>
                        <li class="list-group-item">23 de noviembre</li>
                        <li class="list-group-item">24 de noviembre</li>
                        <li class="list-group-item">25 de noviembre</li>
                    </ul>
                </div>
            </div>

            <div class="col-9 d-flex" id="billboard">
                <div class="billboardFrame flex-grow-1">
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
        </div>
    </div>

    <script>
    window.addEventListener('resize', function() {
        var sidebar = document.getElementById('sidebar');
        
        // Comprobar si el ancho de la pantalla es menor a 768px
        if (window.innerWidth < 768) {
            sidebar.classList.remove('col-2');  // Elimina la clase 'col-2'
            sidebar.classList.add('col-4');     // Añade la clase 'col-4'
        } else {
            sidebar.classList.remove('col-4');  // Elimina la clase 'col-4'
            sidebar.classList.add('col-4');     // Añade la clase 'col-2'
        }

        var sidebar = document.getElementById('billboard');
        
        // Comprobar si el ancho de la pantalla es menor a 768px
        if (window.innerWidth < 768) {
            sidebar.classList.remove('col-9');  // Elimina la clase 'col-2'
            sidebar.classList.add('col-8');     // Añade la clase 'col-4'
        } else {
            sidebar.classList.remove('col-9');  // Elimina la clase 'col-4'
            sidebar.classList.add('col-8');     // Añade la clase 'col-2'
        }// AHHHHHHHHHHH NO CONSIGO QUE QUEDE COMO QUIERO CONCHESUMADREEEEEEEEEEEEEEE
    });

    window.dispatchEvent(new Event('resize'));
</script>

</body>


<?php include '../src/views/public/layouts/footer.php'; ?>