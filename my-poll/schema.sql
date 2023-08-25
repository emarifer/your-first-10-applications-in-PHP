CREATE TABLE polls (
    id INT NOT NULL AUTO_INCREMENT,
    uuid varchar(20) NOT NULL UNIQUE,
    title varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE options (
    id INT NOT NULL AUTO_INCREMENT,
    poll_id INT NOT NULL,
    title varchar(255) NOT NULL,
    votes INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (poll_id) REFERENCES polls(id)
);