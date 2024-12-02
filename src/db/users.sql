USE cine_uabcs;

-- Administrador con total control
CREATE USER 'admin'@'localhost' IDENTIFIED BY '#/4dm1n_l0c4l/0';
GRANT ALL PRIVILEGES ON cine_uabcs.* TO 'admin'@'localhost';

-- Usuario con privilegios en las películas
CREATE USER 'billboard_manager'@'localhost' IDENTIFIED BY '$/b1llb04rd_m4n4g3r/1';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.movies TO 'billboard_manager'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.movies_schedules TO 'billboard_manager'@'localhost';

-- Usuario con privilegios en los eventos
CREATE USER 'events_manager'@'localhost' IDENTIFIED BY '(/3v3nts__m4n4g3r/2)';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.events TO 'events_manager'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.events_schedules TO 'events_manager'@'localhost';

-- Usuario con privilegios para gestionar contenido de la web
CREATE USER 'web_manager'@'localhost' IDENTIFIED BY '=/w3b__m4n4g3r/3';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.movies TO 'web_manager'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.events TO 'web_manager'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.movies_schedules TO 'web_manager'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cine_uabcs.events_schedules TO 'web_manager'@'localhost';

-- Confirmar cambios
FLUSH PRIVILEGES;
