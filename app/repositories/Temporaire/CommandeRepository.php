<?php
require_once './app/core/Repository.php';
require_once './app/entities/Temporaire/Commande.php';

require_once './app/entities/Temporaire/Produit.php';
require_once './app/repositories/Temporaire/ProduitRepository.php';

require_once './app/entities/Temporaire/Utilisateur.php';
require_once './app/entities/Temporaire/UtilisateurRepository.php';

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

	public function createCommandeFromRow(array $row)
	{
		$commande = new Commande(
			$row['numCommande'],
			$row['qa'],
			ProduitRepository::getInstance()->findById($row['idProduit']),
			UtilisateurRepository::getInstance()->findById($row['idUtilisateur'])
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
}