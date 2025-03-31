<?php

require_once './app/core/Repository.php';
require_once './app/entities/Temporaire/Utilisateur.php';

require_once './app/entities/Temporaire/Role.php';
require_once './app/repositories/Temporaire/RoleRepository.php';

class UtilisateurRepository
{
	private $pdo;

	public function __construct() { $this->pdo = Repository::getInstance()->getPDO(); }

	public function findAll(): array 
	{
		$stmt = $this->pdo->query('SELECT * FROM Utilisateur');
		$utilisateurs = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$utilisateurs[] = $this->createUtilisateurFromRow($row);
		}
		return $utilisateurs;
	}

	public function findById($idUtilisateur): ?Utilisateur
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Utilisateur WHERE netud = :idUtilisateur');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createUtilisateurFromRow($row) : null;
	}

	public function createUtilisateurFromRow(array $row)
	{
		return new Utilisateur(
			$row['netud'],
			$row['nom'],
			$row['prenom'],
			$row['tel'],
			$row['email'],
			$row['mdp'],
			$row['typeNotification'],
			RoleRepository::getInstance()->findById($row['role']),
			$row['demande'],
		);
	}

	public function create(Utilisateur $utilisateur): bool
	{
		$stmt = $this->pdo->prepare('INSERT INTO Utilisateur (netud, nom, prenom, tel, email, mdp, typeNotification, role, demande) VALUES (:netud, :nom, :prenom, :tel, :email, :mdp, :typeNotification, :nomRole, :demande)');
		$stmt->bindParam(':netud', $utilisateur->getNetud());
		$stmt->bindParam(':nom', $utilisateur->getNom());
		$stmt->bindParam(':prenom', $utilisateur->getPrenom());
		$stmt->bindParam(':tel', $utilisateur->getTel());
		$stmt->bindParam(':email', $utilisateur->getEmail());
		$stmt->bindParam(':mdp', $utilisateur->getMdp());
		$stmt->bindParam(':typeNotification', $utilisateur->getTypeNotification());
		$stmt->bindParam(':nomRole', $utilisateur->getRole()->getNomRole());
		$stmt->bindParam(':demande', $utilisateur->getDemande());

		return $stmt->execute();
	}
}