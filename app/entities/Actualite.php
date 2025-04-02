<?php

class Actualite
{
	public function __construct(private int $idActu, private string $titreActu, private string $descActu) {}

	// Getters
	public function getIdActu(): int { return $this->idActu; }
	public function getTitreActu(): string { return $this->titreActu; }
	public function getDescActu(): string { return $this->descActu; }


	// Setters 
	public function setIdActu(int $idActu): void { $this->idActu = $idActu; }
	public function setTitreActu(string $titreActu): void { $this->titreActu = $titreActu; }
	public function setDescActu(string $descActu): void { $this->descActu = $descActu; }

	public function __serialize(): array
	{
		return [
			'idActu' => $this->idActu,
			'titreActu' => $this->titreActu,
			'descActu' => $this->descActu,
		];
	}
	public function __unserialize(array $data): void
	{
		$this->idActu = $data['idActu'];
		$this->titreActu = $data['titreActu'];
		$this->descActu = $data['descActu'];
	}
	public function __toString(): string
	{
		return "Actualite : {$this->idActu}, Titre : {$this->titreActu}, Description : {$this->descActu}";
	}
}