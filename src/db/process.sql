USE cine_uabcs

# Procedimiento para gregar admin con privilegios definidos
DELIMITER $$
CREATE PROCEDURE add_admin(
    IN p_name VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_num_control VARCHAR(255),
    IN p_photo VARCHAR(255),
    IN p_billboard_privileges BOOLEAN,
    IN p_events_privileges BOOLEAN,
    IN p_system_privileges BOOLEAN,
    IN p_register_privileges BOOLEAN
)
BEGIN
    INSERT INTO admins (
        name, email, password, num_control, photo, 
        billboard_privileges, events_privileges, 
        system_privileges, register_privileges
    ) VALUES (
        p_name, p_email, p_password, p_num_control, IFNULL(p_photo, './media/img/default.jpg'),
        p_billboard_privileges, p_events_privileges, 
        p_system_privileges, p_register_privileges
    );
END$$
DELIMITER ;

# Procedimiento para obtener horarios de pelicula por fecha
DELIMITER $$
CREATE PROCEDURE get_movies_by_date(IN p_date DATE)
BEGIN
    SELECT m.title, ms.time 
    FROM movies_schedules ms
    INNER JOIN movies m ON ms.id_movie = m.id
    WHERE DATE(ms.time) = p_date
    ORDER BY ms.time;
END$$
DELIMITER ;

# Procedimiento para registrar asistencia
DELIMITER $$
CREATE PROCEDURE register_asistance(
    IN p_id_movie INT,
    IN p_num_control VARCHAR(255)
)
BEGIN
    INSERT INTO asistances (id_movie, num_control)
    VALUES (p_id_movie, p_num_control);
END$$
DELIMITER ;

# Procedimiento para listar eventos y sus horarios
DELIMITER $$
CREATE PROCEDURE list_events_with_schedules()
BEGIN
    SELECT e.title, e.description, e.place, es.time 
    FROM events e
    INNER JOIN events_schedules es ON e.id = es.id_event
    ORDER BY es.time;
END$$
DELIMITER ;
