CREATE DATABASE mi_proyecto_db;

USE mi_proyecto_db;

CREATE TABLE datos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    edad INT NOT NULL,
    tipo ENUM('A', 'B', 'C') NOT NULL,
    descripcion TEXT NOT NULL
);
