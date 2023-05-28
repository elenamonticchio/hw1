Create DATABASE hw1;
USE hw1;

CREATE TABLE users (
    name VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(200),
    username VARCHAR(20) PRIMARY KEY,
    password VARCHAR(200)
) Engine = InnoDB;

CREATE TABLE flights (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    content JSON,
    username VARCHAR(20),
    FOREIGN KEY (username) REFERENCES users(username)
) Engine = InnoDB;

CREATE TABLE activities (
    id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(400),
    photo VARCHAR(300),
    username VARCHAR(20),
    FOREIGN KEY (username) REFERENCES users(username)
);
