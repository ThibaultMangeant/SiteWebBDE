-- Insertion des produits
INSERT INTO Produit (nomProd, qs, prixProd, imgProd) VALUES
	('T-shirt', 35, 39.99, 'tshirt.jpeg'),
	('Tasse', 20, 7.99, 'tasse.jpeg'),
	('Gourde', 10, 9.99, 'gourde.jpeg'),
	('Bloc-note', 25, 8.99, 'bloc-note.jpeg'),
	('Casquette', 30, 29.99, 'casquette.jpeg'),
	('Chaussons', 30, 29.99, 'chaussons.jpeg'),
	('Chemise', 25, 24.99, 'chemise.jpeg'),
	('Hoodie', 50, 44.99, 'hoodie.jpeg'),
	('Sandales', 20, 44.99, 'sandales.jpeg'),
	('Tapis de souris', 10, 30.00, 'mousepad.jpeg'),
	('Pins', 200, 0.99, 'pins.jpeg'),
	('Sac', 100, 2.99, 'sac.jpeg'),
	('Coque téléphone', 10, 49.99, 'coquetel.jpeg'),
	('Teddy bear', 5, 29.99, 'teddybear.jpeg');


-- Insertion des évenements
INSERT INTO Evenement (nomEvent, descEvent, dateEvent, lieuEvent, prixEvent, roleAutoriseMin, imgEvent) VALUES
	('Soirée Malevelon Creek', 'Lorem Ipsum', '2001-09-12 18:00:00', 'Quelque part', 2.0  , 'membre'  , 'malevelon-creek.webp'),
	('Promesse des étoiles'  , 'Lorem Ipsum', '2002-10-15 20:00:00', 'Un endroit'  , 0.0  , 'adherant', 'promesse-des-etoiles.webp'),
	('Tournoi de poker'      , 'Lorem Ipsum', '2001-03-05 15:15:15', 'Où ça ?'     , 50.00, 'adherant', 'tournoi-poker.jpeg');