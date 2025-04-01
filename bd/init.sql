-- Insertion des rôles
INSERT INTO "Role"(nomRole, niveau) VALUES ('admin', 2), ('adherant', 1), ('membre', 0);


-- Insertion des utilisateurs
INSERT INTO Utilisateur(netud, nom, prenom, tel, email, mdp, typeNotification, role, demande) VALUES
	(1234, 'Test' , 'Johnny' , '0708163264', 'test@gmail.com'           , '1234'       , 'Les deux', 'admin'   , FALSE),
    (1235, 'Doe'  , 'John'   , '0708234567', 'john.doe@example.com'     , 'abcd1234'   , 'Mail'    , 'adherant', TRUE ),
    (1236, 'Smith', 'Anna'   , '0708345678', 'anna.smith@example.com'   , 'password123', 'Discord' , 'membre'  , FALSE),
    (1237, 'Brown', 'Charlie', '0708456789', 'charlie.brown@example.com', '12345678'   , 'Les deux', 'adherant', TRUE ),
    (1238, 'White', 'Olivia' , '0708567890', 'olivia.white@example.com' , 'mypassword' , 'Mail'    , 'membre'  , FALSE);


-- Insertion des produits
INSERT INTO Produit (nomProd, qs, prixProd, imgProd) VALUES
	('T-shirt'            ,  35,  39.99, 'tshirt.jpeg'          ),
	('Tasse'              ,  20,   7.99, 'tasse.jpeg'           ),
	('Gourde'             ,  10,   9.99, 'gourde.jpeg'          ),
	('Bloc-note'          ,  25,   8.99, 'bloc-note.jpeg'       ),
	('Casquette'          ,  30,  29.99, 'casquette.jpeg'       ),
	('Chaussons'          ,  30,  29.99, 'chaussons.jpeg'       ),
	('Chemise'            ,  25,  24.99, 'chemise.jpeg'         ),
	('Hoodie'             ,  50,  44.99, 'hoodie.jpeg'          ),
	('Sandales'           ,  20,  44.99, 'sandales.jpeg'        ),
	('Tapis de souris'    ,  10,  30.00, 'mousepad.jpeg'        ),
	('Pins'               , 200,   0.99, 'pins.jpeg'            ),
	('Sac'                , 100,   2.99, 'sac.jpeg'             ),
	('Coque téléphone'    ,  10,  49.99, 'coquetel.jpeg'        ),
	('Teddy bear'         ,   5,  29.99, 'teddybear.jpeg'       ),
	('Boite pour Air pods',  12,  34.99, 'airPods.jpeg'         ),
	('Boxers'             ,  50,   4.99, 'boxer.jpeg'           ),
	('Shorts'             ,  12,  19.99, 'short.jpeg'           ),
	('Pendentif'          ,  20,  39.99, 'pendentif.jpeg'       ),
	('Pot'                ,  15,  49.99, 'pot.jpeg'             ),
	('Tapis'              ,  10,  59.99, 'tapisYoga.jpeg'       ),
	('Enceinte'           ,   5,  89.99, 'enceinte.jpeg'        ),
	('Crocs'              ,   5,  69.99, 'crocs.jpeg'           ),
	('Couverture de livre',  10,  39.99, 'couvertureBible.jpeg' ),
	('Chargeur sans fil'  ,   2, 499.99, 'chargeurBlutooth.jpeg'),
	('Pantalon'           ,   5,  19.99, 'pantalon.jpeg'        );


-- Insertion des évenements
INSERT INTO Evenement (nomEvent, descEvent, dateEvent, lieuEvent, prixEvent, roleAutoriseMin, imgEvent) VALUES
	('Soirée Malevelon Creek', 'Proin vitae nisl tristique, consequat risus sit amet, viverra purus.
	                            Etiam in elementum neque. Nullam semper finibus quam id feugiat.
	                            Fusce eget neque quis velit cursus maximus.
	                            Cras ullamcorper lectus ut fermentum consectetur.
	                            Cras quam nisi, egestas sed diam at, vehicula bibendum elit.
	                            Aliquam gravida pulvinar lacus a consectetur. In semper scelerisque mauris, in egestas augue imperdiet faucibus.
	                            Nam efficitur erat non efficitur varius. Pellentesque massa leo, rhoncus sit amet massa quis, convallis facilisis nunc.
	                            Etiam laoreet elementum est non tempor. Nunc ac lectus efficitur, euismod nisl ac, dapibus erat.
	                            Quisque eget ex elementum, finibus lacus a, porttitor lectus. Aliquam sollicitudin quis est nec vehicula.
	                            Maecenas ornare, libero at ornare tempor, urna tellus blandit eros, bibendum egestas lacus diam sit amet urna.'
	, '2001-09-12 18:00:00', 'Quelque part', 2.0  , 'membre'  , 'malevelon-creek.webp'     ),

	('Promesse des étoiles'  , 'Nunc tellus diam, malesuada in dapibus faucibus, luctus sit amet leo.
	                            Nunc ac quam a dolor viverra laoreet. In sit amet sollicitudin leo.
	                            Quisque bibendum lectus in egestas pretium. Proin pharetra augue ac euismod feugiat.
	                            Suspendisse ipsum magna, convallis sed feugiat eu, tincidunt id diam.
	                            Aliquam vitae lectus lacus. Curabitur non fermentum dolor, quis tincidunt leo.
	                            Duis tincidunt mauris ut eros elementum, eget tincidunt justo accumsan.
	                            Aliquam egestas massa vel auctor molestie.
	                            Duis lorem ligula, aliquam et commodo rutrum, sollicitudin ut magna.
	                            Donec vel arcu placerat, congue mauris eleifend, condimentum sem.
	                            Nulla facilisi. Quisque consectetur porttitor ex, sed pulvinar urna.
	                            Quisque congue enim lacus, sed feugiat nibh dictum at. Etiam a aliquet nisl. '
	, '2002-10-15 20:00:00', 'Un endroit'  , 0.0  , 'adherant', 'promesse-des-etoiles.webp'),

	('Tournoi de poker'      , 'Morbi non urna tortor. Nunc tempus convallis nulla quis vehicula.
	                            Mauris orci nibh, pulvinar in mollis non, dignissim vel lorem.
								Integer ut risus dictum, accumsan sem non, elementum eros.
								Nunc bibendum ultricies ante in placerat.
								Etiam sed metus lacinia ante porttitor laoreet.
								Maecenas porta tempor enim. Quisque non diam ac magna faucibus tempor ut vel sapien.
								Duis vulputate laoreet neque, vel semper ex convallis eu.
								Suspendisse nec massa id elit venenatis pretium.
								Curabitur vulputate enim eu maximus ultrices.
								Etiam augue mauris, vulputate et nisi id, feugiat gravida elit.
								Praesent sollicitudin elit sed arcu placerat luctus.
								Duis vehicula, orci in volutpat dignissim, ligula metus consectetur quam, eu eleifend magna purus quis nisl.
								Sed dignissim mi quis malesuada commodo. Quisque in nunc imperdiet, consequat nulla et, malesuada lorem. '
	, '2001-03-05 15:15:15', 'Où ça ?'     , 50.00, 'adherant', 'tournoi-poker.jpeg'       );


-- Insertion des actualités
INSERT INTO Actualite (titreActu, descActu) VALUES
	('Hackathon de programmation',
	 'Rejoignez-nous pour notre prochain hackathon !
	  Il se tiendra le week-end prochain et mettra au défi vos compétences en développement logiciel.
	  Inscrivez-vous dès maintenant sur notre site web.'
	),
	('Soirée jeux vidéo',
	 'Participez à notre soirée jeux vidéo ce vendredi soir à partir de 18h !
	  Venez tester vos compétences avec vos amis sur des jeux populaires.
	  Snacks et boissons gratuits.'
	),
	('Conférence sur l''intelligence artificielle',
	 'Assistez à notre conférence sur l''intelligence artificielle et son impact sur les industries modernes.
	  Le conférencier invité est un expert en IA, et il partagera ses connaissances et son expérience.'
	),
	('Recrutement pour le club de développement logiciel',
	 'Nous recherchons des membres passionnés pour rejoindre notre club de développement logiciel.
	  Si vous aimez coder et travailler sur des projets intéressants, venez nous rencontrer lors de notre réunion d''information cette semaine.'
	),
	('Concours de programmation – Prix à gagner',
	 'Participez à notre concours de programmation pour une chance de gagner des prix excitants !
	  Les inscriptions sont ouvertes, et le concours débutera le mois prochain.
	  Ne manquez pas cette occasion de montrer vos compétences.'
	);