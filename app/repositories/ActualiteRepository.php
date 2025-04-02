<?php
require_once './app/core/Repository.php';
require_once './app/entities/Actualite.php';

class ActualiteRepository
{
	private $pdo;

	public function __construct() { $this->pdo = Repository::getInstance()->getPDO(); }
	
	public function findAll(): array 
	{
		$stmt = $this->pdo->query('SELECT * FROM Actualite ORDER BY idActu DESC');
		$actualites = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$actualites[] = $this->createActualiteFromRow($row);
		}
		return $actualites;
	}

	public function findById($idActualite): ?Actualite
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Actualite WHERE idActu = :idActualite');
		$stmt->bindParam(':idActualite', $idActualite);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createActualiteFromRow($row) : null;
	}

	public function deleteById($idActualite): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Actualite WHERE idActu = :idActualite');
		$stmt->bindParam(':idActualite', $idActualite);
		return $stmt->execute();
	}

	public function createActualiteFromRow(array $row): Actualite
	{
		return new Actualite(
			(int)$row['idactu'],
			$row['titreactu'],
			$row['descactu']
		);
	}

	public function create(Actualite $actualite): bool
	{
		$stmt = $this->pdo->prepare('INSERT INTO Actualite (titreActu, descActu) VALUES (:titreActu , :descActu)');

		return $stmt->execute([
			':titreActu' => $actualite->getTitreActu(),
			':descActu'  => $actualite->getDescActu ()
		]);
	}

	public function update(Actualite $actualite): bool
	{
		$stmt = $this->pdo->prepare('UPDATE Actualite SET titreActu = :titreActu, descActu = :descActu WHERE idActu = :idActu');

		return $stmt->execute([
			':idActu'    => $actualite->getIdActu   (),
			':titreActu' => $actualite->getTitreActu(),
			':descActu'  => $actualite->getDescActu (),
		]);
	}
}