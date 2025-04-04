-- Suppression des tables existantes si elles existent
DROP TABLE IF EXISTS Commande    CASCADE;
DROP TABLE IF EXISTS Inscrit     CASCADE;
DROP TABLE IF EXISTS Autorise    CASCADE;
DROP TABLE IF EXISTS Produit     CASCADE;
DROP TABLE IF EXISTS Evenement   CASCADE;
DROP TABLE IF EXISTS Actualite   CASCADE;
DROP TABLE IF EXISTS "Role"      CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;

-- Création de la table 'Produit'
CREATE TABLE Produit
(
	idProd    SERIAL        PRIMARY KEY,
	nomProd   VARCHAR(255)  NOT NULL,
	qs        INT           NOT NULL CHECK (qs >= 0),
	prixProd  FLOAT         NOT NULL CHECK (prixProd >= 0),
	imgProd   VARCHAR(255)  NOT NULL
);

-- Création de la table "Role"
CREATE TABLE "Role"
(
	nomRole VARCHAR(10) PRIMARY KEY CHECK (nomRole IN ('admin', 'adherant', 'membre')),
	niveau  INT         NOT NULL
);

-- Création de la table 'Evenement'
CREATE TABLE Evenement
(
	idEvent         SERIAL         PRIMARY KEY,
	nomEvent        VARCHAR(255)   NOT NULL,
	descEvent       TEXT           NOT NULL,
	dateEvent       TIMESTAMP      NOT NULL,
	lieuEvent       VARCHAR(255)   NOT NULL,
	prixEvent       FLOAT          NOT NULL,
	roleAutoriseMin VARCHAR(10),
	imgEvent        VARCHAR(255)   NOT NULL,

	FOREIGN KEY (roleAutoriseMin) REFERENCES "Role"(nomRole) ON DELETE CASCADE
);

-- Création de la table 'Actualite'
CREATE TABLE Actualite
(
	idActu    SERIAL       PRIMARY KEY,
	titreActu VARCHAR(255) NOT NULL,
	descActu  TEXT         NOT NULL
);

-- Création de la table 'Utilisateur'
CREATE TABLE Utilisateur
(
	netud            INT          PRIMARY KEY,
	nom              VARCHAR(255) NOT NULL,
	prenom           VARCHAR(255) NOT NULL,
	tel              VARCHAR(10),
	email            VARCHAR(255) NOT NULL,
	mdp              VARCHAR(255) NOT NULL,
	typeNotification VARCHAR(10)  NOT NULL CHECK (typeNotification IN ('Discord', 'Mail', 'Les deux', 'Aucune')),
	role             VARCHAR(10)  NOT NULL,
	demande          BOOLEAN      NOT NULL,

	-- Clé étrangère vers "Role" sur nomRole
	FOREIGN KEY (role) REFERENCES "Role"(nomRole) ON DELETE CASCADE
);

-- Création de la table Commande
CREATE TABLE Commande
(
	netud       INT NOT NULL,
	idProd      INT NOT NULL,
	numCommande SERIAL NOT NULL,
	qa          INT NOT NULL CHECK (qa >= 0),

	FOREIGN KEY (netud ) REFERENCES Utilisateur(netud ) ON DELETE CASCADE,
	FOREIGN KEY (idProd) REFERENCES Produit    (idProd) ON DELETE CASCADE,

	PRIMARY KEY (netud, idProd)
);

-- Création de la table Inscrit
CREATE TABLE Inscrit
(
	netud       INT NOT NULL,
	idEvent     INT NOT NULL,
	note        INT CHECK (note BETWEEN 0 AND 5),
	commentaire TEXT,

	FOREIGN KEY (netud  ) REFERENCES Utilisateur(netud  ) ON DELETE CASCADE,
	FOREIGN KEY (idEvent) REFERENCES Evenement  (idEvent) ON DELETE CASCADE,

	PRIMARY KEY (netud, idEvent)
);