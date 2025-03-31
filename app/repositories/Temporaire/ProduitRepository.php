<?php
require_once './app/core/Repository.php';
require_once './app/entities/Temporaire/Produit.php';

class ProduitRepository
{
	private $pdo;

	public function __construct() { $this->pdo = Repository::getInstance()->getPDO(); }

	public function findAll(): array 
	{
		$stmt = $this->pdo->query('SELECT * FROM Produit');
		$produits = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$produits[] = $this->createProduitFromRow($row);
		}
		return $produits;
	}

	public function findById($idProduit): ?Produit
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Produit WHERE idProd = :idProduit');
		$stmt->bindParam(':idProduit', $idProduit);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createProduitFromRow($row) : null;
	}

	public function deleteById($idProduit): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Produit WHERE idProd = :idProduit');
		$stmt->bindParam(':idProduit', $idProduit);
		return $stmt->execute();
	}

	public function update(Produit $produit): bool
	{
		$stmt = $this->pdo->prepare('UPDATE Produit SET nomProd = :nomProd, qs = :qs, prixProd = :prixProd WHERE idProd = :idProd');
		return $stmt->execute([
			'idProd' => $produit->getIdProd(),
			'nomProd' => $produit->getNomProd(),
			'qs' => $produit->getQs(),
			'prixProd' => $produit->getPrixProd()
		]);
	}

	public function createProduitFromRow(array $row)
	{
		return new Produit(
			$row['idProd'],
			$row['nomProd'],
			(int)$row['qs'],
			(float)$row['prixProd']
		);
	}

	public function create(Produit $produit): void
	{
		$stmt = $this->pdo->prepare('INSERT INTO Produit (nomProd, qs, prixProd) VALUES (:nomProd, :qs, :prixProd)');

		$stmt->execute([
			':nomProd' => $produit->getNomProd(),
			':qs' => $produit->getQs(),
			':prixProd' => $produit->getPrixProd()
		]);
	}
}