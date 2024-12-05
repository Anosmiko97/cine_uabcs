USE cine_uabcs;

-- Insertar datos en la tabla admins
INSERT INTO admins (name, email, password, num_control, photo, billboard_privileges, events_privileges, system_privileges, register_privileges)
VALUES
('Admin Uno', 'admin1@uabcs.mx', 'hashedpassword1', '123456', './media/img/admin1.jpg', TRUE, TRUE, TRUE, TRUE),
('Admin Dos', 'admin2@uabcs.mx', 'hashedpassword2', '789101', './media/img/admin2.jpg', FALSE, TRUE, FALSE, TRUE),
('Admin Tres', 'admin3@uabcs.mx', 'hashedpassword3', '112131', './media/img/default.jpg', TRUE, FALSE, FALSE, FALSE);

-- Insertar datos en la tabla movies
INSERT INTO movies (title, description, img_route, movie_route)
VALUES
('El Viaje', 'Una épica aventura de descubrimiento', './media/img/elviaje.jpg', './media/movies/elviaje.mp4'),
('La Ciudad Perdida', 'Descubre los secretos de una ciudad antigua', './media/img/laciudadperdida.jpg', './media/movies/laciudadperdida.mp4'),
('Héroes del Mañana', 'Un grupo de amigos enfrenta su destino', './media/img/heroesdelmanana.jpg', './media/movies/heroesdelmanana.mp4');

-- Insertar datos en la tabla movies_schedules
INSERT INTO movies_schedules (id_movie, time)
VALUES
(1, '2024-12-05 15:00:00'),
(1, '2024-12-05 18:00:00'),
(2, '2024-12-06 20:00:00'),
(3, '2024-12-07 16:30:00');

-- Insertar datos en la tabla events
INSERT INTO events (title, description, info, img_route, place)
VALUES
('Feria del Cine', 'Evento cultural dedicado al cine independiente', 'Incluye talleres y conferencias', './media/img/feriadelcine.jpg', 'Auditorio Principal'),
('Maratón de Cortometrajes', 'Proyección de los mejores cortos del año', 'Entrada gratuita para estudiantes', './media/img/maratoncortos.jpg', 'Sala 2'),
('Charla con Directores', 'Conversación con directores de cine emergente', 'Se requiere registro previo', './media/img/charladirectores.jpg', 'Sala de Conferencias');

-- Insertar datos en la tabla events_schedules
INSERT INTO events_schedules (id_event, time)
VALUES
(1, '2024-12-08 10:00:00'),
(1, '2024-12-08 14:00:00'),
(2, '2024-12-09 17:00:00'),
(3, '2024-12-10 12:00:00');

-- Insertar datos en la tabla asistances
INSERT INTO asistances (num_control, departure_time, entry_time)
VALUES
('123456', '18:00:00', '15:00:00'),
('789101', '19:00:00', '16:00:00'),
('112131', NULL, '14:30:00');

-- Usuario testeador
INSERT INTO admins (name, email, password, num_control, billboard_privileges, events_privileges, system_privileges, register_privileges)
VALUES 
('Admin', 'admin1@cineuabcs.com', '$2y$10$eNVAh9k02Dk3RXLA.kVS2ucehA.Om/EXYdk8LIF2EZXPqGCR52zYe', 'admin', 1, 1, 1, 1);