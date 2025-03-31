<?php

class Inscription
{
	public function __construct(private Evenement $evenement, private Utilisateur $utilisateur, private int $note, private string $commentaire) {}

	// Getters
	public function getEvenement(): Evenement { return $this->evenement; }
	public function getUtilisateur(): Utilisateur { return $this->utilisateur; }
	public function getNote(): int { return $this->note; }
	public function getCommentaire(): string { return $this->commentaire; }


	// Setters
	public function setEvenement(Evenement $evenement): void { $this->evenement = $evenement; }
	public function setUtilisateur(Utilisateur $utilisateur): void { $this->utilisateur = $utilisateur;	}
	public function setNote(int $note): void { $this->note = $note;	}
	public function setCommentaire(string $commentaire): void { $this->commentaire = $commentaire; }
}