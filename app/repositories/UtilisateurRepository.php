<?php

require_once './app/core/Repository.php';
require_once './app/entities/Utilisateur.php';

require_once './app/entities/Role.php';
require_once './app/repositories/RoleRepository.php';

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

	public function deleteById($idUtilisateur): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Utilisateur WHERE netud = :idUtilisateur');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		return $stmt->execute();
	}
	
	public function update(Utilisateur $utilisateur): bool
	{
		$stmt = $this->pdo->prepare('UPDATE Utilisateur SET nom = :nom, prenom = :prenom, tel = :tel, email = :email, mdp = :mdp, typeNotification = :typeNotification, role = :nomRole, demande = :demande WHERE netud = :netud');

		return $stmt->execute([
			'netud' => $utilisateur->getNetud(),
			'nom' => $utilisateur->getNom(),
			'prenom' => $utilisateur->getPrenom(),
			'tel' => $utilisateur->getTel(),
			'email' => $utilisateur->getEmail(),
			'mdp' => $utilisateur->getMdp(),
			'typeNotification' => $utilisateur->getTypeNotification(),
			'nomRole' => $utilisateur->getRole()->getNomRole(),
			'demande' => $utilisateur->getDemande()
		]);
	}

	public function upgradeRole(Utilisateur $utilisateur): bool
	{
		$stmt = $this->pdo->prepare('UPDATE Utilisateur SET role = (SELECT nomRole FROM Role WHERE niveau > :niveau limit 1) WHERE netud = :netud');
		return $stmt->execute([
			'netud' => $utilisateur->getNetud(),
			'niveau' => $utilisateur->getRole()->getNiveau(),
		]);
	}

	public function createUtilisateurFromRow(array $row)
	{
		return new Utilisateur(
			(int)$row['netud'],
			$row['nom'],
			$row['prenom'],
			$row['tel'],
			$row['email'],
			$row['mdp'],
			$row['typenotification'],
			(new RoleRepository())->findByNom($row['role']),
			(bool)$row['demande'],
		);
	}

	public function create(Utilisateur $utilisateur): bool
	{
		$stmt = $this->pdo->prepare('INSERT INTO Utilisateur (netud, nom, prenom, tel, email, mdp, typeNotification, role, demande) 
											VALUES (:netud, :nom, :prenom, :tel, :email, :mdp, :typeNotification, :nomRole, :demande)');

		return $stmt->execute([
			'netud' => $utilisateur->getNetud(),
			'nom' => $utilisateur->getNom(),
			'prenom' => $utilisateur->getPrenom(),
			'tel' => $utilisateur->getTel(),
			'email' => $utilisateur->getEmail(),
			'mdp' => $utilisateur->getMdp(),
			'typeNotification' => $utilisateur->getTypeNotification(),
			'nomRole' => $utilisateur->getRole()->getNomRole(),
			'demande' => $utilisateur->getDemande()
		]);
	}
}