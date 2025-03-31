<?php

class Evenement 
{
	public function __construct(private ?int $idEvent, private string $nomEvent, private DateTime $dateEvent, private float $prixEvent, private Role $roleAutorise) {}

	// Getters
	public function getIdEvent(): ?int { return $this->idEvent; }
	public function getNomEvent(): string { return $this->nomEvent; }
	public function getDateEvent(): DateTime { return $this->dateEvent; }
	public function getPrixEvent(): float { return $this->prixEvent; }

	// Setters
	public function setIdEvent(?int $idEvent): void { $this->idEvent = $idEvent; }
	public function setNomEvent(string $nomEvent): void { $this->nomEvent = $nomEvent; }
	public function setDateEvent(DateTime $dateEvent): void { $this->dateEvent = $dateEvent; }
	public function setPrixEvent(float $prixEvent): void { $this->prixEvent = $prixEvent; }
}