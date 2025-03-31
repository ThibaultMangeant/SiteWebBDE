<?php
require_once './app/core/Repository.php';
require_once './app/entities/Temporaire/Inscription.php';

require_once './app/repositories/Temporaire/EvenementRepository.php';
require_once './app/repositories/Temporaire/UtilisateurRepository.php';

class InscriptionRepository
{
	private $pdo;

	public function __construct() { $this->pdo = Repository::getInstance()->getPDO(); }

	public function findAll(): array 
	{
		$stmt = $this->pdo->query('SELECT * FROM Inscription');
		$inscriptions = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$inscriptions[] = $this->createInscriptionFromRow($row);
		}
		return $inscriptions;
	}

	public function findByUtilisateur($idUtilisateur): ?Inscription
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Inscription WHERE netud = :idUtilisateur');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createInscriptionFromRow($row) : null;
	}

	public function findByEvenement($idevenement): array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Inscription WHERE idEvent = :idevenement');
		$stmt->bindParam(':idevenement', $idevenement);
		$stmt->execute();
		$inscriptions = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$inscriptions[] = $this->createInscriptionFromRow($row);
		}
		return $inscriptions;
	}

	public function findByUtilisateurAndEvenement($idUtilisateur, $idEvenement): ?Inscription
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Inscription WHERE netud = :idUtilisateur AND idEvent = :idEvenement');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->bindParam(':idEvenement', $idEvenement);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createInscriptionFromRow($row) : null;
	}

	public function deleteByUtilisateurAndEvenement($idUtilisateur, $idEvenement): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Inscription WHERE netud = :idUtilisateur AND idEvent = :idEvenement');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->bindParam(':idEvenement', $idEvenement);
		return $stmt->execute();
	}

	public function deleteByUtilisateur($idUtilisateur): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Inscription WHERE netud = :idUtilisateur');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		return $stmt->execute();
	}

	public function deleteByEvenement($idEvenement): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Inscription WHERE idEvent = :idEvenement');
		$stmt->bindParam(':idEvenement', $idEvenement);
		return $stmt->execute();
	}

	private function createInscriptionFromRow(array $row): Inscription
	{
		return new Inscription(
			(new EvenementRepository())->findById($row['idEvent']),
			(new UtilisateurRepository())->findById($row['netud']),
			$row['note'],
			$row['commentaire']
		);
	}

	public function create(Inscription $inscription): void
	{
		$stmt = $this->pdo->prepare('INSERT INTO Inscription (idEvent, netud, note, commentaire) VALUES (:idevent, :netud, :note, :commentaire)');
		$stmt->execute([
			':idevent' => $inscription->getIdEvent()->getIdEvent(),
			':netud' => $inscription->getNetud()->getNetud(),
			':note' => $inscription->getNote(),
			':commentaire' => $inscription->getCommentaire()
		]);
	}
}