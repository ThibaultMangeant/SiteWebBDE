<?php
require_once './app/core/Repository.php';
require_once './app/entities/Commande.php';

require_once './app/repositories/ProduitRepository.php';
require_once './app/entities/Produit.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/entities/Utilisateur.php';

class CommandeRepository
{
	private $pdo;

	public function __construct() { $this->pdo = Repository::getInstance()->getPDO(); }

	public function findAll(): array 
	{
        $stmt = $this->pdo->query('SELECT * FROM Commande');
        $commandes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = $this->createCommandeFromRow($row);
        }
        return $commandes;
    }

	public function findById($numCommande): ?Commande
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Commande WHERE numCommande = :numCommande');
		$stmt->bindParam(':numCommande', $numCommande);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createCommandeFromRow($row) : null;
	}

	public function findByUtilisateur($idUtilisateur): array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Commande WHERE netud = :idUtilisateur');
		$stmt->bindParam(':idUtilisateur', $idUtilisateur);
		$stmt->execute();
		$commandes = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$commandes[] = $this->createCommandeFromRow($row);
		}
		return $commandes;
	}

	public function findByProduit($idProduit): array
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Commande WHERE idProd = :idProduit');
		$stmt->bindParam(':idProduit', $idProduit);
		$stmt->execute();
		$commandes = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$commandes[] = $this->createCommandeFromRow($row);
		}
		return $commandes;
	}

	public function deleteById($numCommande): bool
	{
		$stmt = $this->pdo->prepare('DELETE FROM Commande WHERE numCommande = :numCommande');
		$stmt->bindParam(':numCommande', $numCommande);
		return $stmt->execute();
	}

	public function createCommandeFromRow(array $row)
	{
		$commande = new Commande(
			$row['numcommande'],
			(int)$row['qa'],
			(new ProduitRepository())->findById($row['idproduit']),
			(new UtilisateurRepository())->findById($row['netud'])
		);
		return $commande;
	}	

	public function create(Commande $commande): bool
	{
		$stmt = $this->pdo->prepare('
			INSERT INTO Commande (numCommande, qa, idProd, netud)
			VALUES (:numCommande, :qa, :idProduit, :idUtilisateur)
		');

		return $stmt->execute([
			'numCommande' => $commande->getNumCommande(),
			'qa' => $commande->getQa(),
			'idProduit' => $commande->getProduit()->getIdProd(),
			'idUtilisateur' => $commande->getUtilisateur()->getNetud()
		]);
	}

	public function update(Commande $commande): bool
	{
		$stmt = $this->pdo->prepare('UPDATE Commande	SET qa = :qa, idProd = :idProduit, netud = :idUtilisateur WHERE numCommande = :numCommande');

		return $stmt->execute([
			'numCommande' => $commande->getNumCommande(),
			'qa' => $commande->getQa(),
			'idProduit' => $commande->getProduit()->getIdProd(),
			'idUtilisateur' => $commande->getUtilisateur()->getNetud()
		]);
	}
}