CREATE DATABASE cine_uabcs;

USE cine_uabcs;

/* La foto del administrador es opcional,
en la tabla se almacena la ruta de esta
*/
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255),
    billboard_privileges BOOLEAN NOT NULL,
    events_privileges BOOLEAN NOT NULL,
    system_privileges BOOLEAN NOT NULL,
    register_privileges BOOLEAN NOT NULL
);

# falta horarios
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_schedule INT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    movie_route VARCHAR(255) NOT NULL,

    FOREIGN KEY (id_schedule) REFERENCES schedules(id_schedule)
);

#falta horarios
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    info VARCHAR(255) NOT NULL,
    img_route VARCHAR(255) NOT NULL
);

CREATE TABLE schedules (
    id INT PRIMARY KEY NOT NULL,
    time DATETIME NOT NULL
)