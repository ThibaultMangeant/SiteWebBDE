<?php

class Utilisateur 
{
	public function __construct(private ?int $netud, private string $nom, private string $prenom, private string $tel, private string $email, private string $mdp, private string $typeNotification, private Role $role) {}

	// Getters
	public function getNetud(): ?int { return $this->netud; }
	public function getNom(): string { return $this->nom; }
	public function getPrenom(): string { return $this->prenom; }
	public function getTel(): string { return $this->tel;	}
	public function getEmail(): string { return $this->email; }
	public function getMdp(): string { return $this->mdp; }
	public function getTypeNotification(): string { return $this->typeNotification;	}
	public function getRole(): Role { return $this->role; }


	// Setters
	public function setNetud(?int $netud): void { $this->netud = $netud; }
	public function setNom(string $nom): void {	$this->nom = $nom; }
	public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
	public function setTel(string $tel): void { $this->tel = $tel; }
	public function setEmail(string $email): void { $this->email = $email; }
	public function setMdp(string $mdp): void { $this->mdp = $mdp; }
	public function setTypeNotification(string $typeNotification): void { $this->typeNotification = $typeNotification; }
	public function setRole(Role $role): void { $this->role = $role; }
}