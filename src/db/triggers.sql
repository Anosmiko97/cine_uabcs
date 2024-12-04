USE cine_uabcs;

# Registrar cambios en los privilegios de admins
CREATE TABLE admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELIMITER $$
CREATE TRIGGER after_admin_update
AFTER UPDATE ON admins
FOR EACH ROW
BEGIN
    IF OLD.billboard_privileges <> NEW.billboard_privileges OR
       OLD.events_privileges <> NEW.events_privileges OR
       OLD.system_privileges <> NEW.system_privileges OR
       OLD.register_privileges <> NEW.register_privileges THEN
        INSERT INTO admin_logs (admin_id, action)
        VALUES (NEW.id, 'Privilegios modificados');
    END IF;
END$$
DELIMITER ;

# Validar horarios de peliculas
DELIMITER $$
CREATE TRIGGER before_movie_schedule_insert
BEFORE INSERT ON movies_schedules
FOR EACH ROW
BEGIN
    IF NEW.time < NOW() THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No puedes programar una película en el pasado.';
    END IF;
END$$
DELIMITER ;

# Actualizar aistencia al borrar una pelicula
DELIMITER $$
CREATE TRIGGER after_movie_delete
AFTER DELETE ON movies
FOR EACH ROW
BEGIN
    DELETE FROM asistances WHERE id_movie = OLD.id;
END$$
DELIMITER ;

# Calcular asistencia al salir
DELIMITER $$
CREATE TRIGGER before_asistance_update
BEFORE UPDATE ON asistances
FOR EACH ROW
BEGIN
    IF NEW.departure_time IS NOT NULL AND OLD.departure_time IS NULL THEN
        SET NEW.departure_time = NOW();
    END IF;
END$$
DELIMITER ;



