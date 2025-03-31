<?php

class Produit
{
	public function __construct(private ?int $idProd, private string $nomProd, private int $qs, private float $prixProd) {}

	// Getters
	public function getIdProd(): ?int {	return $this->idProd; }
	public function getNomProd(): string { return $this->nomProd; }
	public function getQs(): int { return $this->qs; }
	public function getPrixProd(): float { return $this->prixProd; }


	// Setters 
	public function setIdProd(?int $idProd): void { $this->idProd = $idProd; }
	public function setNomProd(string $nomProd): void { $this->nomProd = $nomProd; }
	public function setQs(int $qs): void { $this->qs = $qs; }
	public function setPrixProd(float $prixProd): void { $this->prixProd = $prixProd; }
}