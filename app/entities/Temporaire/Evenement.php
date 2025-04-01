<?php
require_once 'Role.php';

class Evenement 
{
	public function __construct(private int $idEvent, private string $nomEvent, private string $descEvent, private DateTime $dateEvent, private string $lieuEvent, private float $prixEvent, private Role $roleAutorise) {}

	// Getters
	public function getIdEvent(): ?int { return $this->idEvent; }
	public function getNomEvent(): string { return $this->nomEvent; }
	public function getDescEvent(): string { return $this->descEvent; }
	public function getDateEvent(): DateTime { return $this->dateEvent; }
	public function getLieuEvent(): string { return $this->lieuEvent; }
	public function getPrixEvent(): float { return $this->prixEvent; }
	public function getRoleAutorise(): role { return $this->roleAutorise; }


	// Setters
	public function setIdEvent(?int $idEvent): void { $this->idEvent = $idEvent; }
	public function setNomEvent(string $nomEvent): void { $this->nomEvent = $nomEvent; }
	public function setDescEvent(string $descEvent): void { $this->descEvent = $descEvent; }
	public function setDateEvent(DateTime $dateEvent): void { $this->dateEvent = $dateEvent; }
	public function setLieuEvent(string $lieuEvent): void { $this->lieuEvent = $lieuEvent; }
	public function setPrixEvent(float $prixEvent): void { $this->prixEvent = $prixEvent; }
	public function setRoleAutorise(role $roleAutorise): void { $this->roleAutorise = $roleAutorise; }

	public function __serialize(): array
	{
		return [
			'idEvent' => $this->idEvent,
			'nomEvent' => $this->nomEvent,
			'descEvent' => $this->descEvent,
			'dateEvent' => $this->dateEvent,
			'lieuEvent' => $this->lieuEvent,
			'prixEvent' => $this->prixEvent,
			'roleAutorise' => $this->roleAutorise->__serialize()
		];
	}
	public function __unserialize(array $data): void
	{
		$this->idEvent = $data['idEvent'];
		$this->nomEvent = $data['nomEvent'];
		$this->descEvent = $data['descEvent'];
		$this->dateEvent = $data['dateEvent'];
		$this->lieuEvent = $data['lieuEvent'];
		$this->prixEvent = $data['prixEvent'];
		$this->roleAutorise = (new Role("", 0));
		$this->roleAutorise->__unserialize($data['roleAutorise']);
	}
	public function __toString(): string
	{
		return "Evenement: {$this->nomEvent}, Date: {$this->dateEvent->format('Y-m-d')}, Prix: {$this->prixEvent}€";
	}
}