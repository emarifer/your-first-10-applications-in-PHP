CREATE TABLE categories (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE expenses (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    category_id int NOT NULL,
    expense float(8,2) NOT NUll,
    date date NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

/* 
https://stackoverflow.com/questions/28501745/mysql-datatype-float-8-2-value-getting-rounded-off-to-one-decimal-point-when
 */