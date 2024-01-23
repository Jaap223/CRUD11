CREATE TABLE users (
    u_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    naam VARCHAR(255),
    adres VARCHAR(255),
    wachtwoord VARCHAR(255),
    tel_nr VARCHAR(10)
);
CREATE TABLE boeken (
    boek_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(255),
    datum DATE,
    tijd TIME,
    user_id INT(10),
    FOREIGN KEY (user_id) REFERENCES users(u_id)
);
CREATE TABLE boekHuren (
    huur_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    tijd TIME,
    boek_id INT(10),
    FOREIGN KEY (boek_id) REFERENCES boeken(boek_id)
);
CREATE TABLE categories (
    category_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255)
);
