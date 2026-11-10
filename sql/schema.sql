CREATE DATABASE IF NOT EXISTS encuestas_cali CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE encuestas_cali;

CREATE TABLE IF NOT EXISTS puntos (
    comuna TINYINT UNSIGNED PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

INSERT IGNORE INTO puntos (comuna, nombre) VALUES
(1,'Punto Comuna 1'),(6,'Punto Comuna 6'),(7,'Punto Comuna 7'),(13,'Punto Comuna 13'),
(14,'Punto Comuna 14'),(20,'Punto Comuna 20'),(21,'Punto Comuna 21'),(17,'Oficina principal');

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    rol ENUM('administrador','ventanilla','encuestador','calidad','enrutador') NOT NULL,
    punto TINYINT UNSIGNED NULL,
    FOREIGN KEY (punto) REFERENCES puntos(comuna)
);

CREATE TABLE IF NOT EXISTS solicitudes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(160) NOT NULL,
    apellidos VARCHAR(160) NOT NULL,
    celular CHAR(10) NOT NULL,
    direccion VARCHAR(160) NOT NULL,
    zona ENUM('urbana','rural') NOT NULL,
    comuna TINYINT UNSIGNED NULL,
    barrio VARCHAR(120) NULL,
    corregimiento VARCHAR(120) NULL,
    latitud DECIMAL(9,6) NOT NULL,
    longitud DECIMAL(9,6) NOT NULL,
    fecha DATETIME NOT NULL,
    creado_por INT UNSIGNED NOT NULL,
    punto TINYINT UNSIGNED NOT NULL,
    INDEX (fecha, id),
    FOREIGN KEY (creado_por) REFERENCES usuarios(id),
    FOREIGN KEY (punto) REFERENCES puntos(comuna)
);
