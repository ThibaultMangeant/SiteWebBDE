-- Insertion des catégories de voitures
INSERT INTO Category (name) VALUES
                                ('Électrique'),
                                ('Hybride'),
                                ('Sport'),
                                ('SUV'),
                                ('Compact');

-- Insertion des voitures (articles)
INSERT INTO Article (name, price, description, stock, category_id) VALUES
                                                                       ('Tesla Model S Plaid', 130000.00, 'Voiture électrique ultra-performante avec une autonomie de plus de 600 km.', 50, 1),
                                                                       ('Fiat 1000Tipla', 1500.00, 'Un classique intemporel avec un style unique et un charme indéniable.', 100, 5),  -- Remplacement de la Tesla Model X Plaid
                                                                       ('Renault Clio 5 Esprit Alpine Hybrid', 30000.00, 'Voiture hybride avec un design sportif et de faibles émissions de CO2.', 100, 2),
                                                                       ('Ferrari SF90 Stradale', 400000.00, 'Voiture hybride sportive avec plus de 1000 chevaux et une vitesse de pointe impressionnante.', 10, 3),
                                                                       ('Porsche Taycan Turbo S', 185000.00, 'Voiture électrique sportive avec des performances équivalentes à une supercar.', 20, 1),
                                                                       ('Toyota Prius', 25000.00, 'Voiture hybride fiable et économique avec un historique de performance écoresponsable.', 200, 2),
                                                                       ('BMW X5 M', 120000.00, 'SUV sportif avec une motorisation puissante et un confort haut de gamme.', 40, 4);

-- Insertion des extras (les extras représentent des options comme "Conduite autonome", "Son Premium", etc.)
INSERT INTO Extra (name, article_id) VALUES
                                         ('Conduite autonome', 1),  -- Tesla Model S Plaid
                                         ('Son Premium', 1),  -- Tesla Model S Plaid
                                         ('Pack Performance', 1),  -- Tesla Model S Plaid
                                         ('Toit ouvrant', 2),  -- Fiat 1000Tipla
                                         ('Phares LED', 2),  -- Fiat 1000Tipla
                                         ('Jantes 14 pouces', 2),  -- Fiat 1000Tipla
                                         ('Pack Sport', 3),  -- Renault Clio 5 Esprit Alpine Hybrid
                                         ('Intérieur cuir', 3),  -- Renault Clio 5 Esprit Alpine Hybrid
                                         ('Jantes 19 pouces', 3),  -- Renault Clio 5 Esprit Alpine Hybrid
                                         ('Pack Circuit', 4),  -- Ferrari SF90 Stradale
                                         ('Freins céramique', 4),  -- Ferrari SF90 Stradale
                                         ('Jantes Carbone', 4),  -- Ferrari SF90 Stradale
                                         ('Pack Performance', 5),  -- Porsche Taycan Turbo S
                                         ('Son Bose', 5),  -- Porsche Taycan Turbo S
                                         ('Conduite autonome', 5),  -- Porsche Taycan Turbo S
                                         ('Son Premium', 6),  -- Toyota Prius
                                         ('Sièges chauffants', 6),  -- Toyota Prius
                                         ('Caméra 360°', 6),  -- Toyota Prius
                                         ('Pack Offroad', 7),  -- BMW X5 M
                                         ('Suspension active', 7),  -- BMW X5 M
                                         ('Intérieur cuir', 7);  -- BMW X5 M