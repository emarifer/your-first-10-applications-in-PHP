CREATE TABLE search (
    id int NOT NULL AUTO_INCREMENT,
    q varchar(255) NOT NULL,
    session_id varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE products (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    categories varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

/*
Hacemos un INSERT para poblar la tabla «products», y simular que tenemos un sistema de productos, pues no  es el propósito de esta aplicación que el usario dé los datos, si no que los busque en una hipótetica aplicación comercial.
*/

INSERT INTO products(title, categories) VALUES('iPad 512GB Gold', 'tablet, apple, tableta, ipad'), ('Shampoo Head & Shoulders 500ml', 'shampoo, hair, cabello, cuidado personal, higiene'), ('Funko Pop Capitan America', 'funko, pop, marvel, capitan, america');