-- Insertion des produits
INSERT INTO Produit (nomProd, qs, prixProd) VALUES
	('Clé USB', 10, 5.99),
	('T-shirt', 35, 3.99),
	('Tasse', 20, 4.99),
	('Gourde', 10, 5.99),
	('Bloc-note', 25, 6.99),
	('Stylo', 150, 0.99);

-- Insertion des évenements
INSERT INTO Evenement (nomEvent, descEvent, dateEvent, prixEvent) VALUES
	('Soirée Malevelon Creek', 'Lorem Ipsum', '2001-09-12 18:00:00', 2.0  ),
	('Promesse des étoiles'  , 'Lorem Ipsum', '2002-10-15 20:00:00', 0.0  ),
	('Tournoi de poker'      , 'Lorem Ipsum', '2001-03-05 15:15:15', 50.00);

-- Insertion des roles autorisés aux évenements
INSERT INTO Autorise (idEvent, nomRole) VALUES
	(1, 'admin'   ), -- Autorise Admin
	(1, 'adherent'), -- Autorise Adhérent
	(1, 'membre'  ), -- Autorise Membre
	(2, 'admin'   ),
	(2, 'adherent'),
	(3, 'admin'   ),
	(3, 'adherent');