DROP DATABASE IF EXISTS libro_de_apuntes;
CREATE DATABASE IF NOT EXISTS libro_de_apuntes;
USE libro_de_apuntes;

-- Create books table
CREATE TABLE IF NOT EXISTS books (
    id_book INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create sheets table
CREATE TABLE IF NOT EXISTS sheets (
    id_sheet INT AUTO_INCREMENT PRIMARY KEY,
    id_book INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_book) REFERENCES books(id_book) ON DELETE CASCADE
);

INSERT INTO books (title) VALUES ('Nuevo libro');

INSERT INTO sheets (id_book, title, content) VALUES (1, 'Nueva hoja del libro 1', 'Este es el contenido nuevo.');