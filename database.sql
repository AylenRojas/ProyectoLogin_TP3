CREATE DATABASE IF NOT EXISTS proyecto_login_tp3 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE proyecto_login_tp3;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);