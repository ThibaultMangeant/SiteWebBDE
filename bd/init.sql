-- Insertion des produits
INSERT INTO Produit (nomProd, qs, prixProd, imgProd) VALUES
	('Clé USB', 10, 14.99, 'usb.png'),
	('T-shirt', 35, 39.99, 'tshirt.png'),
	('Tasse', 20, 7.99, 'tasse.png'),
	('Gourde', 10, 9.99, 'gourde.png'),
	('Bloc-note', 25, 8.99, 'bloc-note.png'),
	('Stylo', 150, 0.99, 'stylo.png'),
	('Casquette', 30, 29.99, 'casquette.png');

-- Insertion des évenements
INSERT INTO Evenement (nomEvent, descEvent, dateEvent, lieuEvent, prixEvent, roleAutoriseMin, imgEvent) VALUES
	('Soirée Malevelon Creek', 'Lorem Ipsum', '2001-09-12 18:00:00', 'Quelque part', 2.0  , 'membre'  , 'malevelon-creek.png'),
	('Promesse des étoiles'  , 'Lorem Ipsum', '2002-10-15 20:00:00', 'Un endroit'  , 0.0  , 'adherant', 'promesse-des-etoiles.png'),
	('Tournoi de poker'      , 'Lorem Ipsum', '2001-03-05 15:15:15', 'Où ça ?'     , 50.00, 'adherant', 'tournoi-poker.png');