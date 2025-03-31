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

	public function createProduitFromRow(array $row)
	{
		return new Produit(
			$row['idProd'],
			$row['nomProd'],
			(float)$row['qs'],
			(int)$row['prixProd']
		);
	}
}