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
}