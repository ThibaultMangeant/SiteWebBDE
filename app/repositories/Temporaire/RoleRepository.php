<?php
require_once './app/core/Repository.php';
require_once './app/entities/Temporaire/Role.php';

class RoleRepository
{
	private $pdo;

	public function __construct() { $this->pdo = Repository::getInstance()->getPDO(); }

	public function findAll(): array 
	{
		$stmt = $this->pdo->query('SELECT * FROM Role');
		$roles = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$roles[] = $this->createRoleFromRow($row);
		}
		return $roles;
	}

	public function findByNom($nomRole): ?Role
	{
		$stmt = $this->pdo->prepare('SELECT * FROM Role WHERE nomRole = :nomRole');
		$stmt->bindParam(':nomRole', $nomRole);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->createRoleFromRow($row) : null;
	}

	public function createRoleFromRow(array $row): Role
	{
		return new Role(
			$row['nomRole'],
			(int)$row['niveau']
		);
	}

	public function create(Role $role): bool
	{
		$stmt = $this->pdo->prepare('INSERT INTO Role (nomRole, niveau) VALUES (:nomRole, :niveau)');
		return $stmt->execute([
			'nomRole' => $role->getNomRole(),
			'niveau' => $role->getNiveau()
		]);
	}
}