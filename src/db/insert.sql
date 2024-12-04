USE cine_uabcs;

-- Insertar datos en la tabla admins
INSERT INTO admins (name, email, password, num_control, billboard_privileges, events_privileges, system_privileges, register_privileges)
VALUES 
('Admin 1', 'admin1@cineuabcs.com', 'hashedpassword1', 'NC12345', 1, 1, 1, 1),
('Admin 2', 'admin2@cineuabcs.com', 'hashedpassword2', 'NC67890', 1, 0, 1, 0);

-- Insertar datos en la tabla movies
INSERT INTO movies (title, description, img_route, movie_route)
VALUES
('Pelicula 1', 'Una emocionante aventura.', './media/img/pelicula1.jpg', './media/movies/pelicula1.mp4'),
('Pelicula 2', 'Un drama conmovedor.', './media/img/pelicula2.jpg', './media/movies/pelicula2.mp4'),
('Pelicula 3', 'Comedia para toda la familia.', './media/img/pelicula3.jpg', './media/movies/pelicula3.mp4');

-- Insertar datos en la tabla movies_schedules
INSERT INTO movies_schedules (id_movie, time)
VALUES
(1, '2024-12-04 14:00:00'),
(2, '2024-12-04 16:00:00'),
(3, '2024-12-04 18:00:00'),
(1, '2024-12-05 20:00:00');

-- Insertar datos en la tabla events
INSERT INTO events (title, description, info, img_route, place)
VALUES
('Evento 1', 'Un gran concierto.', 'Más información en nuestras redes sociales.', './media/img/evento1.jpg', 'Auditorio Principal'),
('Evento 2', 'Exposición de arte.', 'Entrada libre.', './media/img/evento2.jpg', 'Sala de Arte UABCS');

-- Insertar datos en la tabla events_schedules
INSERT INTO events_schedules (id_event, time)
VALUES
(1, '2024-12-06 18:00:00'),
(2, '2024-12-07 10:00:00'),
(1, '2024-12-08 19:00:00');

-- Insertar datos en la tabla asistances
INSERT INTO asistances (id_movie, num_control, departure_time)
VALUES
(1, 'NC12345', '2024-12-04 15:30:00'),
(2, 'NC67890', '2024-12-04 17:45:00'),
(3, NULL, '2024-12-04 19:10:00');
