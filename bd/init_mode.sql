-- Insertion des catégories de vêtements
INSERT INTO Category (name) VALUES
                                ('Homme'),
                                ('Femme'),
                                ('Unisexe'),
                                ('Accessoires'),
                                ('Chaussures');

-- Insertion des articles (vrais articles de mode)
INSERT INTO Article (name, price, description, stock, category_id) VALUES
                                                                       ('Air Jordan 1 Retro High OG', 170.00, 'Les baskets iconiques avec un design rétro, très demandées.', 100, 5),  -- Chaussures
                                                                       ('Nike Air Force 1', 120.00, 'Les baskets classiques en cuir blanc, un essentiel.', 200, 5),  -- Chaussures
                                                                       ('Levi''s 501 Original', 90.00, 'Le jean emblématique de Levi''s, connu pour sa coupe classique.', 150, 1),  -- Homme
                                                                       ('Gucci Marmont Matelassé', 1980.00, 'Sac à main en cuir avec une finition matelassée et logo Gucci.', 25, 4),  -- Accessoires
                                                                       ('New Balance 550', 150.00, 'Sneakers rétro au look classique, très populaires.', 80, 5),  -- Chaussures
                                                                       ('The North Face Nuptse Jacket', 280.00, 'La doudoune iconique, parfaite pour l''hiver et les randonnées.', 50, 1),  -- Homme
                                                                       ('Balenciaga Triple S', 850.00, 'Les baskets volumineuses au design avant-gardiste.', 30, 5),  -- Chaussures
                                                                       ('Ralph Lauren Slim Fit Shirt', 110.00, 'Chemise Ralph Lauren Slim Fit en coton, élégante et confortable.', 100, 1),  -- Homme
                                                                       ('Chanel 2.55', 6500.00, 'Sac à main intemporel en cuir avec le célèbre motif matelassé.', 15, 4);  -- Accessoires

-- Insertion des extras (options comme taille, couleur, etc.)
INSERT INTO Extra (name, article_id) VALUES
                                         ('Taille 42', 1),  -- Air Jordan 1 Retro High OG
                                         ('Taille 43', 1),  -- Air Jordan 1 Retro High OG
                                         ('Couleur Noir/Blanc', 1),  -- Air Jordan 1 Retro High OG
                                         ('Couleur Blanc', 2),  -- Nike Air Force 1
                                         ('Taille 44', 2),  -- Nike Air Force 1
                                         ('Taille 34', 3),  -- Levi's 501 Original
                                         ('Taille 36', 3),  -- Levi's 501 Original
                                         ('Couleur Bleu Denim', 3),  -- Levi's 501 Original
                                         ('Couleur Noir', 4),  -- Gucci Marmont Matelassé
                                         ('Couleur Beige', 4),  -- Gucci Marmont Matelassé
                                         ('Taille 42', 5),  -- New Balance 550
                                         ('Taille 43', 5),  -- New Balance 550
                                         ('Couleur Blanc', 5),  -- New Balance 550
                                         ('Couleur Noir', 5),  -- New Balance 550
                                         ('Taille M', 6),  -- The North Face Nuptse Jacket
                                         ('Taille L', 6),  -- The North Face Nuptse Jacket
                                         ('Taille 42', 7),  -- Balenciaga Triple S
                                         ('Couleur Blanc', 7),  -- Balenciaga Triple S
                                         ('Taille M', 8),  -- Ralph Lauren Slim Fit Shirt
                                         ('Taille L', 8),  -- Ralph Lauren Slim Fit Shirt
                                         ('Couleur Bleu', 8),  -- Ralph Lauren Slim Fit Shirt
                                         ('Couleur Blanc', 8),  -- Ralph Lauren Slim Fit Shirt
                                         ('Couleur Noir', 9),  -- Chanel 2.55
                                         ('Couleur Rouge', 9);  -- Chanel 2.55