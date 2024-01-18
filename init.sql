use db;

CREATE TABLE db.Resolver (
    id int NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE  db.Invoice (
	id int NOT NULL AUTO_INCREMENT,
    id_resolver int NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    currency ENUM('CZK', 'EUR', 'USD'),
    
    created_at DATETIME NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE db.Order (
	id int NOT NULL AUTO_INCREMENT,
    id_resolver int NOT NULL,
    id_invoice int NULL,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    currency ENUM('CZK', 'EUR', 'USD'),
    
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (id_resolver) REFERENCES Resolver(id),
    FOREIGN KEY (id_invoice) REFERENCES Invoice(id)
);


INSERT INTO `Resolver` (`id`, `name`) VALUES (1, 'Jetsster'), (2, 'Coplanes'), (3, 'Flater');
INSERT INTO `Order` (`id`, `name`, `price`, `currency`,  `id_resolver`,  `created_at`,  `updated_at` ) VALUES  (1, 'Order 1', 50.5, 'USD', 1, NOW(), NOW()),  (2, 'Order2', 150, 'EUR',2, NOW(), NOW()),  (3, 'Order3', 300000, 'CZK', 2, NOW(), NOW());