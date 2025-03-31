-- Insertion des produits
INSERT INTO Produit (nomProd, qs, prixProd) VALUES
	('Clé USB', 10, 5.99),
	('T-shirt', 35, 3.99),
	('Tasse', 20, 4.99),
	('Gourde', 10, 5.99),
	('Bloc-note', 25, 6.99),
	('Stylo', 150, 0.99);

-- Insertion des évenements
INSERT INTO Evenement (nomEvent, descEvent, dateEvent, lieuEvent, prixEvent, roleAutoriseMin) VALUES
	('Soirée Malevelon Creek', 'Lorem Ipsum', '2001-09-12 18:00:00', 'Quelque part', 2.0  , 'membre'),
	('Promesse des étoiles'  , 'Lorem Ipsum', '2002-10-15 20:00:00', 'Un endroit', 0.0  , 'adherant'),
	('Tournoi de poker'      , 'Lorem Ipsum', '2001-03-05 15:15:15', 'Où ça ?', 50.00, 'adherant');