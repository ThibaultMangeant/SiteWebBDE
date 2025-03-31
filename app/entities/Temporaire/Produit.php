<?php

class Produit
{
	public function __construct(private int $idProd, private string $nomProd, private int $qs, private float $prixProd) {}

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

	public function __serialize(): array
	{
		return [
			'idProd' => $this->idProd,
			'nomProd' => $this->nomProd,
			'qs' => $this->qs,
			'prixProd' => $this->prixProd
		];
	}
	public function __unserialize(array $data): void
	{
		$this->idProd = $data['idProd'];
		$this->nomProd = $data['nomProd'];
		$this->qs = $data['qs'];
		$this->prixProd = $data['prixProd'];
	}
	public function __toString(): string
	{
		return "Produit: {$this->nomProd}, Prix: {$this->prixProd}€";
	}
}