<?php

class Commande
{
	public function __construct(private int $numCommande, private int $qa, private Produit $produit, private Utilisateur $utilisateur) {}

	// Getters
	public function getNumCommande(): ?int { return $this->numCommande; }
	public function getQa(): int { return $this->qa; }
	public function getProduit(): Produit { return $this->produit; }
	public function getUtilisateur(): Utilisateur { return $this->utilisateur; }
	public function getTotal(): float { return $this->qa * $this->produit->getPrixProd(); }

	// Setters
	public function setNumCommande(?int $numCommande): void { $this->numCommande = $numCommande; }
	public function setQa(int $qa): void { $this->qa = $qa; }
	public function setProduit(Produit $produit): void { $this->produit = $produit; }
	public function setUtilisateur(Utilisateur $utilisateur): void { $this->utilisateur = $utilisateur; }

	public function __serialize(): array
	{
		return [
			'numCommande' => $this->numCommande,
			'qa' => $this->qa,
			'produit' => serialize($this->produit),
			'utilisateur' => serialize($this->utilisateur)
		];
	}
	public function __unserialize(array $data): void
	{
		$this->numCommande = $data['numCommande'];
		$this->qa = $data['qa'];

		// Vérification du type de $data['produit']
		if (is_array($data['produit'])) {
			$this->produit = new Produit(
				$data['produit']['idProd'], 
				$data['produit']['nomProd'], 
				$data['produit']['qs'], 
				$data['produit']['prixProd'], 
				$data['produit']['imgProd']
			);
		} else {
			$this->produit = unserialize($data['produit']);
		}

		// Vérification du type de $data['utilisateur']
		if (is_array($data['utilisateur'])) {
			$this->utilisateur = new Utilisateur(
				$data['utilisateur']['netud'], 
				$data['utilisateur']['nom'], 
				$data['utilisateur']['prenom'], 
				$data['utilisateur']['tel'], 
				$data['utilisateur']['email'], 
				$data['utilisateur']['mdp'], 
				$data['utilisateur']['typeNotification'], 
				new Role(
					$data['utilisateur']['role']['nomRole'], 
					$data['utilisateur']['role']['niveau']
				), 
				$data['utilisateur']['demande']
			);
		} else {
			$this->utilisateur = unserialize($data['utilisateur']);
		}
	}
	public function __toString(): string
	{
		return "Commande: {$this->numCommande}, Produit: {$this->produit->getNomProd()}, Quantité: {$this->qa}, Total: {$this->getTotal()}€";
	}
}