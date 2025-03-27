-- Suppression des tables existantes si elles existent
DROP TABLE IF EXISTS Purchase CASCADE;
DROP TABLE IF EXISTS Extra CASCADE;
DROP TABLE IF EXISTS Article CASCADE;
DROP TABLE IF EXISTS Category CASCADE;
DROP TABLE IF EXISTS "User" CASCADE;

-- Création de la table 'Category'
CREATE TABLE Category (
                          id SERIAL PRIMARY KEY,
                          name VARCHAR(255) NOT NULL
);

-- Création de la table 'Article'
CREATE TABLE Article (
                         id SERIAL PRIMARY KEY,
                         name VARCHAR(255) NOT NULL,
                         price DECIMAL(10, 2) NOT NULL,
                         description TEXT,
                         stock INT NOT NULL,
                         category_id INT,
                         FOREIGN KEY (category_id) REFERENCES Category(id) ON DELETE SET NULL
);


-- Création de la table 'Extra'
CREATE TABLE Extra (
                       id SERIAL PRIMARY KEY,
                       name VARCHAR(255) NOT NULL,
                       article_id INT NOT NULL,
                       FOREIGN KEY (article_id) REFERENCES Article(id) ON DELETE CASCADE
);

-- Création de la table 'User'
CREATE TABLE "User" (
                        id SERIAL PRIMARY KEY,
                        firstname VARCHAR(255) NOT NULL,
                        lastname VARCHAR(255) NOT NULL,
                        email VARCHAR(255) UNIQUE NOT NULL,
                        password VARCHAR(255) NOT NULL
);

-- Création de la table 'Purchase'
CREATE TABLE Purchase (
                          id SERIAL PRIMARY KEY,
                          article_id INT NOT NULL,
                          user_id INT NOT NULL,
                          quantity INT NOT NULL,
                          date TIMESTAMP NOT NULL,
                          FOREIGN KEY (article_id) REFERENCES Article(id) ON DELETE CASCADE,
                          FOREIGN KEY (user_id) REFERENCES "User"(id) ON DELETE CASCADE
);


-- Insertion d'un utilisateur standard
INSERT INTO "User" (firstname, lastname, email, password) VALUES
    ('John', 'Doe', 'john.doe@example.com', 'securePassword123');

-- Insertion d'un administrateur
INSERT INTO "User" (firstname, lastname, email, password) VALUES
    ('root', 'toor', 'ro@ot.fr', 'adminPassword456');