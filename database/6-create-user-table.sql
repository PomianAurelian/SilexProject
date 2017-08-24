CREATE TABLE user (
    id int(10) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    privilege int(10) NOT NULL,
    PRIMARY KEY (id)
);
