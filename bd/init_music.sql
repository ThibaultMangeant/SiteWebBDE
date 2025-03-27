-- Insertion des catégories de festivals
INSERT INTO Category (name) VALUES
                                ('Électro'),
                                ('Rap'),
                                ('Pop'),
                                ('Commercial'),
                                ('Metal');

-- Insertion des articles (les noms des articles sont maintenant les noms des festivals)
INSERT INTO Article (name, price, description, stock, category_id) VALUES
                                                                       ('Tomorrowland', 250.00, 'Festival de musique électro avec expérience VIP et pass backstage.', 100, 1),
                                                                       ('Lollapalooza Paris', 250.00, 'Festival de musique électro avec expérience VIP et pass backstage.', 100, 1),
                                                                       ('Eurovision Song Contest', 300.00, 'Festival commercial avec expérience VIP et pass backstage.', 100, 4),
                                                                       ('Golden Coast', 270.00, 'Festival de musique rap avec expérience VIP et pass backstage.', 100, 2),
                                                                       ('Wacken Open Air', 280.00, 'Festival de musique metal avec expérience VIP et pass backstage.', 100, 5),
                                                                       ('Hellfest', 290.00, 'Festival de musique metal avec expérience VIP et pass backstage.', 100, 5),
                                                                       ('Solidays', 180.00, 'Festival de musique pop avec une expérience VIP et des pass backstage.', 100, 3);


-- Insertion des extras (les extras sont maintenant des types comme VIP, Catégorie, etc.)
INSERT INTO Extra (name, article_id) VALUES
                                         ('VIP Pass', 1),  -- Tomorrowland
                                         ('Backstage Access', 1),  -- Tomorrowland
                                         ('Category Pass', 1),  -- Tomorrowland
                                         ('VIP Pass', 2),  -- Lollapalooza Paris
                                         ('Backstage Access', 2),  -- Lollapalooza Paris
                                         ('Category Pass', 2),  -- Lollapalooza Paris
                                         ('VIP Pass', 3),  -- Eurovision Song Contest
                                         ('Backstage Access', 3),  -- Eurovision Song Contest
                                         ('Category Pass', 3),  -- Eurovision Song Contest
                                         ('VIP Pass', 4),  -- Golden Coast
                                         ('Backstage Access', 4),  -- Golden Coast
                                         ('Category Pass', 4),  -- Golden Coast
                                         ('VIP Pass', 5),  -- Wacken Open Air
                                         ('Backstage Access', 5),  -- Wacken Open Air
                                         ('Category Pass', 5),  -- Wacken Open Air
                                         ('VIP Pass', 6),  -- Hellfest
                                         ('Backstage Access', 6),  -- Hellfest
                                         ('Category Pass', 6),  -- Hellfest
                                         ('VIP Pass', 7),  -- Solidays
                                         ('Backstage Access', 7),-- Solidays
                                         ('Category Pass', 7);-- Solidays
