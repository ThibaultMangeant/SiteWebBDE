<?php
require_once './app/core/Repository.php';
require_once './app/entities/Inscription.php';

require_once './app/repositories/EvenementRepository.php';
require_once './app/repositories/UtilisateurRepository.php';

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
		$stmt = $this->pdo->prepare('SELECT * FROM Inscrit WHERE netud = :idUtilisateur');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createInscriptionFromRow($row) : null;
	}

	public function findByEvenement($idevenement): array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Inscrit WHERE idEvent = :idevenement');
		$stmt->bindParam(':idevenement', $idevenement);
		$stmt->execute();
		$inscriptions = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$inscriptions[] = $this->createInscriptionFromRow($row);
		}
		return $inscriptions;
	}

	public function findByEvenementWithStars($idevenement): array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Inscrit WHERE idEvent = :idevenement AND note BETWEEN 1 AND 5');
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
		$stmt = $this->pdo->prepare('SELECT * FROM Inscrit WHERE netud = :idUtilisateur AND idEvent = :idEvenement');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->bindParam(':idEvenement', $idEvenement);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createInscriptionFromRow($row) : null;
	}

	public function moyenneAvis($idEvenement): int
	{
		$stmt = $this->pdo->prepare('SELECT ROUND(AVG(note), 0) FROM Inscrit WHERE idEvent = :idEvenement AND note BETWEEN 1 AND 5');
		$stmt->bindParam(':idEvenement', $idEvenement);
		$stmt->execute();
		return (int) $stmt->fetchColumn();
	}

	public function deleteByUtilisateurAndEvenement($idUtilisateur, $idEvenement): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Inscrit WHERE netud = :idUtilisateur AND idEvent = :idEvenement');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->bindParam(':idEvenement', $idEvenement);
		return $stmt->execute();
	}

	public function deleteAvisByUtilisateurAndEvenement($idUtilisateur, $idEvenement) : bool
	{
		$stmt = $this->pdo->prepare('UPDATE Inscrit SET note=0, commentaire=NULL WHERE netud = :idUtilisateur AND idEvent = :idEvenement');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->bindParam(':idEvenement', $idEvenement);
		return $stmt->execute();
	}

	public function deleteByUtilisateur($idUtilisateur): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Inscrit WHERE netud = :idUtilisateur');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		return $stmt->execute();
	}

	public function deleteByEvenement($idEvenement): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Inscrit WHERE idEvent = :idEvenement');
		$stmt->bindParam(':idEvenement', $idEvenement);
		return $stmt->execute();
	}

	private function createInscriptionFromRow(array $row): Inscription
	{
		$commentaire = $row['commentaire'];
		if ($commentaire === null)
			$commentaire = "";

		return new Inscription(
			(new EvenementRepository())->findById($row['idevent']),
			(new UtilisateurRepository())->findById($row['netud']),
			$row['note'],
			$commentaire
		);
	}

	public function create(Inscription $inscription): bool
	{

		$commentaire = $inscription->getCommentaire();
		if ($commentaire === "")
			$commentaire = null;

		$stmt = $this->pdo->prepare('INSERT INTO Inscrit (idEvent, netud, note, commentaire) VALUES (:idevent, :netud, :note, :commentaire)');
		return $stmt->execute([
			':idevent' => $inscription->getEvenement()->getIdEvent(),
			':netud' => $inscription->getUtilisateur()->getNetud(),
			':note' => $inscription->getNote(),
			':commentaire' => $commentaire
		]);
	}

	public function update(Inscription $inscription): bool
	{
		$note = $inscription->getNote();
		$commentaire = $inscription->getCommentaire();
		$idEvent = $inscription->getEvenement()->getIdEvent();
		$idUtilisateur = $inscription->getUtilisateur()->getNetud();

		$stmt = $this->pdo->prepare('UPDATE Inscrit SET note = :note, commentaire = :commentaire WHERE idEvent = :idEvent AND netud=:netud');
		$stmt->bindParam(':note', $note, PDO::PARAM_INT);
		$stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
		$stmt->bindParam(':idEvent', $idEvent, PDO::PARAM_INT);
		$stmt->bindParam(':netud', $idUtilisateur, PDO::PARAM_INT);

		return $stmt->execute();
	}
}