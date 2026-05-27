CREATE DATABASE IF NOT EXISTS lostfound_db;
USE lostfound_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_type ENUM('lost', 'found') NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(150) NOT NULL,
    item_date DATE NOT NULL,
    contact VARCHAR(100) NOT NULL,
    image VARCHAR(255),
    status ENUM('claimed', 'unclaimed') DEFAULT 'unclaimed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (fullname, email, password, role)
VALUES ('System Administrator', 'admin@cvsu.edu.ph', '$2y$10$z4qTJ9bZz46B7NrWrSXvLO6mZ6cZrDIFLHwQ5Rq3xY67yBu7YrEcO', 'admin');

INSERT INTO users (fullname, email, password, role)
VALUES ('Demo User', 'student@cvsu.edu.ph', '$2y$10$z4qTJ9bZz46B7NrWrSXvLO6mZ6cZrDIFLHwQ5Rq3xY67yBu7YrEcO', 'user');

INSERT INTO items (user_id, item_type, item_name, description, location, item_date, contact, image, status)
VALUES
(2, 'lost', 'Key', 'Silver key with small keychain.', 'CvSU Library', '2026-05-20', 'student@cvsu.edu.ph', NULL, 'unclaimed'),
(2, 'lost', 'Phone', 'Black smartphone with case.', 'Engineering Building', '2026-05-18', 'student@cvsu.edu.ph', NULL, 'unclaimed'),
(2, 'found', 'Backpack', 'Black backpack found near cafeteria.', 'Cafeteria', '2026-05-22', 'student@cvsu.edu.ph', NULL, 'unclaimed'),
(2, 'found', 'Umbrella', 'Blue umbrella found in ICT Building.', 'ICT Building', '2026-05-19', 'student@cvsu.edu.ph', NULL, 'unclaimed');
