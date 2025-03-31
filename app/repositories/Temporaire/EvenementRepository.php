<?php
require_once './app/core/Repository.php';
require_once './app/entities/Temporaire/Evenement.php';

class EvenementRepository
{
	private $pdo;

	public function __construct() { $this->pdo = Repository::getInstance()->getPDO(); }
	
	public function findAll(): array 
	{
		$stmt = $this->pdo->query('SELECT * FROM Evenement');
		$evenements = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$evenements[] = $this->createEvenementFromRow($row);
		}
		return $evenements;
	}

	public function findById($idEvenement): ?Evenement
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Evenement WHERE idEvent = :idEvenement');
		$stmt->bindParam(':idEvenement', $idEvenement);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createEvenementFromRow($row) : null;
	}

	public function deleteById($idEvenement): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Evenement WHERE idEvent = :idEvenement');
		$stmt->bindParam(':idEvenement', $idEvenement);
		return $stmt->execute();
	}

	public function createEvenementFromRow(array $row): Evenement
	{
		return new Evenement(
			(int)$row['idevent'],
			$row['nomevent'],
			$row['descevent'],
			new DateTime($row['dateevent']),
			$row['lieuevent'],
			(float)$row['prixevent'],
			(new RoleRepository())->findByNom($row['roleautoriseMin'])
		);
	}

	public function create(Evenement $evenement): bool
	{
		$stmt = $this->pdo->prepare('INSERT INTO Evenement (nomEvent, descEvent, dateEvent, lieuEvent, prixEvent, roleAutoriseMin) VALUES (:nomEvent , :descEvent , TIMESTAMP :dateEvent, :lieuEvent, :prixEvent, :roleAutoriseMin)');

		return $stmt->execute([
			':nomEvent' => $evenement->getNomEvent(),
			':descEvent' => $evenement->getDescEvent(),
			':dateEvent' => $evenement->getDateEvent()->format('Y-m-d H:i:s'),
			':lieuEvent' => $evenement->getLieuEvent(),
			':prixEvent' => $evenement->getPrixEvent(),
			':roleAutoriseMin' => $evenement->getRoleAutorise()
		]);
	}

	public function update(Evenement $evenement): bool
	{
		$stmt = $this->pdo->prepare('UPDATE Evenement SET nomEvent = :nomEvent, descEvent = :descEvent, dateEvent = TIMESTAMP :dateEvent, lieuEvent = :lieuEvent, prixEvent = :prixEvent, roleAutoriseMin = :roleAutoriseMin WHERE idEvent = :idEvenement');

		return $stmt->execute([
			':idEvenement' => $evenement->getIdEvent(),
			':nomEvent' => $evenement->getNomEvent(),
			':descEvent' => $evenement->getDescEvent(),
			':dateEvent' => $evenement->getDateEvent()->format('Y-m-d H:i:s'),
			':lieuEvent' => $evenement->getLieuEvent(),
			':prixEvent' => $evenement->getPrixEvent(),
			':roleAutoriseMin' => $evenement->getRoleAutorise()
		]);
	}
	
	public function findByNom($nomEvent): ?Evenement
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Evenement WHERE nomEvent = :nomEvent');
		$stmt->bindParam(':nomEvent', $nomEvent);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createEvenementFromRow($row) : null;
	}
}