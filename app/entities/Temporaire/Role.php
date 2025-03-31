<?php

class Role 
{
	public function __construct(private String $nomRole, private int $niveau) {}

	// Getters
	public function getNomRole(): string { return $this->nomRole; }
	public function getNiveau(): int { return $this->niveau; }

	// Setters
	public function setNomRole(string $nomRole): void {	$this->nomRole = $nomRole; }
	public function setNiveau(int $niveau): void { $this->niveau = $niveau; }

	public function __serialize(): array
	{
		return [
			'nomRole' => $this->nomRole,
			'niveau' => $this->niveau
		];
	}
	public function __unserialize(array $data): void
	{
		$this->nomRole = $data['nomRole'];
		$this->niveau = $data['niveau'];
	}
	public function __toString(): string
	{
		return "Role: {$this->nomRole}, Niveau: {$this->niveau}";
	}
}