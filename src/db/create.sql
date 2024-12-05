DROP DATABASE IF EXISTS cine_uabcs;

CREATE DATABASE cine_uabcs;

USE cine_uabcs;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    num_control VARCHAR(255) NOT NULL,
    photo VARCHAR(255) DEFAULT './media/img/default.jpg',
    billboard_privileges BOOLEAN NOT NULL,
    events_privileges BOOLEAN NOT NULL,
    system_privileges BOOLEAN NOT NULL,
    register_privileges BOOLEAN NOT NULL
);

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    img_route VARCHAR(255) NOT NULL,
    movie_route VARCHAR(255) NOT NULL
);

CREATE TABLE movies_schedules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_movie INT NOT NULL,
    time DATETIME NOT NULL,

    CONSTRAINT fk_movie_schedule FOREIGN KEY (id_movie) REFERENCES movies(id) ON DELETE CASCADE
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    info VARCHAR(255) NOT NULL,
    img_route VARCHAR(255) NOT NULL,
    place VARCHAR(255) NOT NULL
);

CREATE TABLE events_schedules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_event INT NOT NULL,
    time DATETIME NOT NULL,

    CONSTRAINT fk_event_schedule FOREIGN KEY (id_event) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE asistances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    num_control VARCHAR(255),
    departure_time VARCHAR(19),
    entry_time VARCHAR(19) NULL;
);

