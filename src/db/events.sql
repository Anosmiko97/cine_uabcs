USE cine_uabcs;

-- Activar el programador de eventos
SET GLOBAL event_scheduler = ON;

-- Eliminar asistencias con más de 1 año de antigüedad
DELIMITER $$
CREATE EVENT IF NOT EXISTS clean_old_asistances_year
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    DELETE FROM asistances WHERE entry_time < NOW() - INTERVAL 1 YEAR;
END$$
DELIMITER ;

-- Eliminar asistencias con más de 30 días de antigüedad
DELIMITER $$
CREATE EVENT IF NOT EXISTS clean_old_asistances_month
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    DELETE FROM asistances WHERE entry_time < NOW() - INTERVAL 30 DAY;
END$$
DELIMITER ;

-- Desactivar administradores inactivos 
ALTER TABLE admins ADD COLUMN last_active TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

DELIMITER $$
CREATE EVENT IF NOT EXISTS deactivate_inactive_admins
ON SCHEDULE EVERY 1 MONTH
DO
BEGIN
    UPDATE admins
    SET system_privileges = 0, register_privileges = 0, events_privileges = 0, billboard_privileges = 0
    WHERE last_active < NOW() - INTERVAL 6 MONTH;
END$$
DELIMITER ;

-- Eliminar eventos antiguos
DELIMITER $$
CREATE EVENT IF NOT EXISTS delete_old_events
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
    DELETE FROM events_schedules
    WHERE time < NOW();
    
    DELETE FROM events
    WHERE id NOT IN (SELECT DISTINCT id_event FROM events_schedules);
END$$
DELIMITER ;
