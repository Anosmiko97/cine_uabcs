<?php include '../src/views/public/layouts/header.php'; ?>

<head>
    <link rel="stylesheet" href="/public/assets/css/events.css">
</head>

<main>
    <div class="content">
        <div class="left-frame">
            <div class="frameTitle">
                <h1><b>Proximo evento</b></h1>
            </div>



            <div class="eventContainer">

                <div class="description">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim, quo nostrum, assumenda magnam, ex
                    iure ipsa ducimus consequatur nesciunt modi voluptatem alias? Blanditiis officiis sequi vitae?
                    Praesentium enim nostrum itaque!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime, et nemo quia cumque sequi quidem
                    reiciendis exercitationem debitis perferendis beatae, amet dolore quaerat, enim odit eaque quisquam
                    adipisci fuga? Id.
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis ipsa maxime, tempora magni tenetur
                    iure ab corrupti dicta sit quae? Similique deserunt eligendi molestias illo cum nesciunt blanditiis
                    dolor quos?
                </div>

                <!-- Aqui va el evento mas proximo -->
                <img src="<?= explode('htdocs', $events['img_route'])[1] ?>" alt="Evento ejemplo"
                    onerror="this.src='https://via.placeholder.com/600x800'" class="leftEventPoster">
            </div>
        </div>

        <div class="right-frame">
            <div class="frameTitle">
                <h1><b>Siguientes eventos</b></h1>
            </div>

            <!-- Aqui va el resto de eventos siguientes, supongo ocupas un for each o algo asi -->
            <div class="nextEventsContainer">
                <div class="description">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim, quo nostrum, assumenda magnam, ex
                    iure ipsa ducimus consequatur nesciunt modi voluptatem alias? Blanditiis officiis sequi vitae?
                    Praesentium enim nostrum itaque!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime, et nemo quia cumque sequi quidem
                    reiciendis exercitationem debitis perferendis beatae, amet dolore quaerat, enim odit eaque quisquam
                    adipisci fuga? Id.
                </div>
                <img src="https://via.placeholder.com/600x800" class="rightEventPoster">
            </div>

            <div class="nextEventsContainer">
                <div class="description">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim, quo nostrum, assumenda magnam, ex
                    iure ipsa ducimus consequatur nesciunt modi voluptatem alias? Blanditiis officiis sequi vitae?
                    Praesentium enim nostrum itaque!
                </div>
                <img src="https://via.placeholder.com/600x300" class="rightEventPoster">
            </div>

            <div class="nextEventsContainer">
                <div class="description">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim, quo nostrum, assumenda magnam, ex
                    iure ipsa ducimus consequatur nesciunt modi voluptatem alias? Blanditiis officiis sequi vitae?
                    Praesentium enim nostrum itaque!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime, et nemo quia cumque sequi quidem
                    reiciendis exercitationem debitis perferendis beatae, amet dolore quaerat, enim odit eaque quisquam
                    adipisci fuga? Id.
                </div>
                <img src="https://via.placeholder.com/600x500" class="rightEventPoster">
            </div>
        </div>


    </div>
</main>

<?php include '../src/views/public/layouts/footer.php'; ?>