<?php
require_once './app/core/Repository.php';
require_once './app/entities/Temporaire/Commande.php';

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
}