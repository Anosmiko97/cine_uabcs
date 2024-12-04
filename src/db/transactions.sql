-- Transacción 1: Registrar una asistencia con control de horarios
START TRANSACTION;

SET @movie_id = 1;
SET @schedule_time = '2024-12-04 14:00:00';

SELECT COUNT(*) INTO @movie_exists
FROM movies_schedules
WHERE id_movie = @movie_id AND time = @schedule_time;

IF @movie_exists > 0 THEN
    INSERT INTO asistances (id_movie, num_control, entry_time)
    VALUES (@movie_id, 'NC12345', NOW());
ELSE
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'Película o horario no válido';
END IF;

COMMIT;

-- Transacción 2: Actualizar privilegios de un administrador
START TRANSACTION;

SET @admin_id = 1;

SELECT billboard_privileges INTO @has_privileges
FROM admins
WHERE id = @admin_id;

IF @has_privileges = 1 THEN
    UPDATE admins
    SET billboard_privileges = 0, events_privileges = 0
    WHERE id = @admin_id;
ELSE
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'El administrador no tiene privilegios que actualizar';
END IF;

COMMIT;

-- Transacción 3: Cancelar un evento y sus horarios
START TRANSACTION;

SET @event_id = 1;

SELECT COUNT(*) INTO @future_schedules
FROM events_schedules
WHERE id_event = @event_id AND time > NOW();

IF @future_schedules = 0 THEN
    DELETE FROM events_schedules WHERE id_event = @event_id;

    DELETE FROM events WHERE id = @event_id;
ELSE
    SIGNAL SQLSTATE '45000' 
    SET MESSAGE_TEXT = 'El evento tiene horarios futuros y no puede eliminarse';
END IF;

COMMIT;

-- Transacción 4: Registrar una nueva película con horarios
START TRANSACTION;

INSERT INTO movies (title, description, img_route, movie_route)
VALUES ('Nueva Película', 'Descripción de prueba', './media/img/nueva_pelicula.jpg', './media/movies/nueva_pelicula.mp4');

SET @new_movie_id = LAST_INSERT_ID();

INSERT INTO movies_schedules (id_movie, time)
VALUES 
(@new_movie_id, '2024-12-05 14:00:00'),
(@new_movie_id, '2024-12-05 18:00:00');

COMMIT;
