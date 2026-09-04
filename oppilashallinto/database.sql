CREATE DATABASE IF NOT EXISTS oppilashallinto;
USE oppilashallinto;

CREATE TABLE IF NOT EXISTS oppilaat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etunimi VARCHAR(20),
    sukunimi VARCHAR(50),
    katuosoite VARCHAR(100),
    postinumero VARCHAR(5),
    kaupunki VARCHAR(20),
    sahkoposti VARCHAR(100),
    puhelin VARCHAR(20)
);