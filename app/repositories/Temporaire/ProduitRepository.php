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
		$stmt = $this->pdo->prepare('SELECT * FROM Produit WHERE idprod = :idproduit');
		$stmt->bindParam(':idproduit', $idProduit);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createProduitFromRow($row) : null;
	}

	public function deleteById($idProduit): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Produit WHERE idProd = :idProduit');
		$stmt->bindParam(':idproduit', $idProduit);
		return $stmt->execute();
	}

	public function update(Produit $produit): bool
	{
		$stmt = $this->pdo->prepare('UPDATE Produit SET nomProd = :nomProd, qs = :qs, prixProd = :prixProd WHERE idProd = :idProd');
		return $stmt->execute([
			'idprod' => $produit->getIdProd(),
			'nomprod' => $produit->getNomProd(),
			'qs' => $produit->getQs(),
			'prixprod' => $produit->getPrixProd()
		]);
	}

	public function createProduitFromRow(array $row)
	{
		return new Produit(
			$row['idprod'],
			$row['nomprod'],
			(int)$row['qs'],
			(float)$row['prixprod']
		);
	}

	public function create(Produit $produit): void
	{
		$stmt = $this->pdo->prepare('INSERT INTO Produit (nomprod, qs, prixprod) VALUES (:nomprod, :qs, :prixprod)');

		$stmt->execute([
			':nomprod' => $produit->getNomProd(),
			':qs' => $produit->getQs(),
			':prixprod' => $produit->getPrixProd()
		]);
	}
}