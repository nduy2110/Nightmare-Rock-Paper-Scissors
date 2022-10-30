CREATE TABLE score (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL,
    password varchar(50) NOT NULL,
    point int NOT NULL DEFAULT 0
);