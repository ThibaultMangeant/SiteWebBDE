<?php

class Utilisateur 
{
	public function __construct(private int $netud, private string $nom, private string $prenom, private string $tel, private string $email, private string $mdp, private string $typeNotification, private Role $role, private bool $demande) {}

	// Getters
	public function getNetud(): ?int { return $this->netud; }
	public function getNom(): string { return $this->nom; }
	public function getPrenom(): string { return $this->prenom; }
	public function getTel(): string { return $this->tel;	}
	public function getEmail(): string { return $this->email; }
	public function getMdp(): string { return $this->mdp; }
	public function getTypeNotification(): string { return $this->typeNotification;	}
	public function getRole(): Role { return $this->role; }
	public function getDemande(): bool { return $this->demande; }


	// Setters
	public function setNetud(?int $netud): void { $this->netud = $netud; }
	public function setNom(string $nom): void {	$this->nom = $nom; }
	public function setPrenom(string $prenom): void { $this->prenom = $prenom; }
	public function setTel(string $tel): void { $this->tel = $tel; }
	public function setEmail(string $email): void { $this->email = $email; }
	public function setMdp(string $mdp): void { $this->mdp = $mdp; }
	public function setTypeNotification(string $typeNotification): void { $this->typeNotification = $typeNotification; }
	public function setRole(Role $role): void { $this->role = $role; }
	public function setDemande(bool $demande): void { $this->demande = $demande; }

	public function __serialize() : array
	{
		return [
			'netud' => $this->netud,
			'nom' => $this->nom,
			'prenom' => $this->prenom,
			'tel' => $this->tel,
			'email' => $this->email,
			'mdp' => $this->mdp,
			'typeNotification' => $this->typeNotification,
			'role' => $this->role->__serialize(),
			'demande' => $this->demande
		];
	}

	public function __unserialize(array $data): void
	{
		$this->netud = $data['netud'];
		$this->nom = $data['nom'];
		$this->prenom = $data['prenom'];
		$this->tel = $data['tel'];
		$this->email = $data['email'];
		$this->mdp = $data['mdp'];
		$this->typeNotification = $data['typeNotification'];
		$this->role = (new Role("", 0));
		$this->role->__unserialize($data['roleAutorise']);
		$this->demande = $data['demande'];
	}
	public function __toString(): string
	{
		return "Utilisateur: {$this->nom} {$this->prenom}, Email: {$this->email}, Role: {$this->role}";
	}
}