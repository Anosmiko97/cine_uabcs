-- Tabla: admins
INSERT INTO admins (name, email, password, photo, billboard_privileges, events_privileges, system_privileges, register_privileges)
VALUES
('Admin 1', 'admin1@example.com', 'password1', './media/img/admin1.jpg', TRUE, TRUE, TRUE, TRUE),
('Admin 2', 'admin2@example.com', 'password2', './media/img/admin2.jpg', FALSE, TRUE, FALSE, TRUE),
('Admin 3', 'admin3@example.com', 'password3', './media/img/admin3.jpg', TRUE, FALSE, TRUE, FALSE);

-- Tabla: movies
INSERT INTO movies (title, description, img_route, movie_route)
VALUES
('Movie A', 'A great action movie.', './media/img/movie_a.jpg', './media/movies/movie_a.mp4'),
('Movie B', 'An exciting drama.', './media/img/movie_b.jpg', './media/movies/movie_b.mp4'),
('Movie C', 'A family-friendly comedy.', './media/img/movie_c.jpg', './media/movies/movie_c.mp4');

-- Tabla: movies_schedules
INSERT INTO movies_schedules (id_movie, time)
VALUES
(1, '2024-12-03 14:00:00'),
(1, '2024-12-03 18:00:00'),
(2, '2024-12-04 15:30:00'),
(3, '2024-12-05 20:00:00');

-- Tabla: events
INSERT INTO events (title, description, info, img_route, place)
VALUES
('Event 1', 'A live music concert.', 'Details about Event 1.', './media/img/event1.jpg', 'Auditorium'),
('Event 2', 'An art exhibition.', 'Details about Event 2.', './media/img/event2.jpg', 'Gallery'),
('Event 3', 'A science fair.', 'Details about Event 3.', './media/img/event3.jpg', 'Science Building');

-- Tabla: events_schedules
INSERT INTO events_schedules (id_event, time)
VALUES
(1, '2024-12-10 19:00:00'),
(2, '2024-12-11 10:00:00'),
(3, '2024-12-12 09:00:00');

-- Tabla: asistances
INSERT INTO asistances (id_movie, num_control, departure_time, entry_time)
VALUES
(1, '12345', '2024-12-03 16:00:00', '2024-12-03 14:00:00'),
(2, '67890', '2024-12-04 18:00:00', '2024-12-04 15:30:00'),
(3, '54321', '2024-12-05 22:00:00', '2024-12-05 20:00:00');
