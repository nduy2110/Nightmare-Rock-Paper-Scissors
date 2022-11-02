CREATE TABLE score (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL,
    password varchar(50) NOT NULL,
    point int NOT NULL DEFAULT 0
);

CREATE TABLE music (
    username_id int NOT NULL,
    title text NOT NULL,
    link text NOT NULL,
    FOREIGN KEY (username_id) REFERENCES score(id)
);



INSERT INTO score (username, password, point) VALUE ('admin', 'superstrongpasssword', 99999);